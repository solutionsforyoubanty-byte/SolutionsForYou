<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }

    /**
     * Create Razorpay Order
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'plan_type' => 'required|in:basic,standard,premium',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $service = Service::findOrFail($request->service_id);
        
        // Get price based on plan type
        $priceField = $request->plan_type . '_price';
        $amount = $service->$priceField;

        if (!$amount) {
            return response()->json(['error' => 'Invalid plan selected'], 400);
        }

        // Generate unique order ID
        $orderId = 'ORD_' . strtoupper(Str::random(12));

        try {
            // Create Razorpay Order
            $razorpayOrder = $this->razorpay->order->create([
                'receipt' => $orderId,
                'amount' => $amount * 100, // Amount in paise
                'currency' => 'INR',
                'notes' => [
                    'service' => $service->title,
                    'plan' => ucfirst($request->plan_type),
                ]
            ]);

            // Save payment record
            $payment = Payment::create([
                'order_id' => $orderId,
                'razorpay_order_id' => $razorpayOrder->id,
                'service_id' => $service->id,
                'plan_type' => $request->plan_type,
                'amount' => $amount,
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'status' => 'pending',
                'notes' => [
                    'service_title' => $service->title,
                    'plan_name' => ucfirst($request->plan_type),
                ]
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $razorpayOrder->id,
                'amount' => $amount * 100,
                'currency' => 'INR',
                'key' => config('services.razorpay.key'),
                'name' => config('app.name'),
                'description' => $service->title . ' - ' . ucfirst($request->plan_type) . ' Plan',
                'prefill' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'contact' => $request->phone,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Verify Payment
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        try {
            // Verify signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            // Get payment details from Razorpay
            $razorpayPayment = $this->razorpay->payment->fetch($request->razorpay_payment_id);

            // Update payment record
            $payment->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'paid',
                'payment_method' => $razorpayPayment->method ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful!',
                'payment_id' => $payment->order_id,
            ]);

        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            return response()->json(['error' => 'Payment verification failed'], 400);
        }
    }

    /**
     * Payment Success Page
     */
    public function success(Request $request)
    {
        $payment = Payment::where('order_id', $request->order_id)
            ->where('status', 'paid')
            ->with('service')
            ->first();

        if (!$payment) {
            return redirect()->route('user.pricing')->with('error', 'Payment not found');
        }

        return view('user.payment.success', compact('payment'));
    }

    /**
     * Admin: List all payments
     */
    public function index(Request $request)
    {
        $query = Payment::with('service');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan type
        if ($request->filled('plan')) {
            $query->where('plan_type', $request->plan);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $payments = $query->latest()->paginate(20);

        // Chart data for last 7 days
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('D');
            $chartData[] = Payment::where('status', 'paid')
                ->whereDate('created_at', $date)
                ->sum('amount');
        }

        return view('admin.payments.index', compact('payments', 'chartLabels', 'chartData'));
    }

    /**
     * Export payments to CSV
     */
    public function export(Request $request)
    {
        $payments = Payment::with('service')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
            ->latest()
            ->get();

        $filename = 'payments_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'Order ID',
                'Razorpay Payment ID',
                'Customer Name',
                'Email',
                'Phone',
                'Service',
                'Plan',
                'Amount',
                'Status',
                'Payment Method',
                'Date'
            ]);

            // CSV Data
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->order_id,
                    $payment->razorpay_payment_id,
                    $payment->customer_name,
                    $payment->customer_email,
                    $payment->customer_phone,
                    $payment->service->title ?? 'N/A',
                    ucfirst($payment->plan_type),
                    $payment->amount,
                    ucfirst($payment->status),
                    $payment->payment_method,
                    $payment->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Admin: View payment details
     */
    public function show($id)
    {
        $payment = Payment::with('service')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }
}
