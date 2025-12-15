<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $addresses = auth()->user()->addresses;
        $subtotal = $carts->sum('total');
        
        // Get settings
        $freeShippingMin = (float) Setting::get('free_shipping_min', '499');
        $shippingCharge = (float) Setting::get('shipping_charge', '40');
        $taxPercent = (float) Setting::get('tax_percent', '18');
        
        $shipping = $subtotal >= $freeShippingMin ? 0 : $shippingCharge;
        $tax = round($subtotal * ($taxPercent / 100), 2);
        $total = $subtotal + $shipping + $tax;

        // COD availability check
        $codEnabled = Setting::isCodEnabled();
        $codMinOrder = Setting::getCodMinOrder();
        $codMaxOrder = Setting::getCodMaxOrder();
        
        $codAvailable = $codEnabled;
        if ($codAvailable && $codMinOrder > 0 && $total < $codMinOrder) {
            $codAvailable = false;
        }
        if ($codAvailable && $codMaxOrder && $total > $codMaxOrder) {
            $codAvailable = false;
        }

        return view('checkout.index', compact(
            'carts', 'addresses', 'subtotal', 'shipping', 'tax', 'total',
            'codAvailable', 'codMinOrder', 'codMaxOrder'
        ));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code']);
        }

        $subtotal = auth()->user()->getCartTotal();

        if (!$coupon->isValid($subtotal)) {
            return response()->json(['success' => false, 'message' => 'Coupon is not valid or minimum order not met']);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'coupon_code' => $coupon->code,
            'message' => "Coupon applied! You save ₹" . number_format($discount, 2)
        ]);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,razorpay',
        ]);

        // Validate COD availability
        if ($request->payment_method === 'cod') {
            if (!Setting::isCodEnabled()) {
                return response()->json(['success' => false, 'message' => 'Cash on Delivery is not available']);
            }
            
            $subtotal = auth()->user()->getCartTotal();
            $codMinOrder = Setting::getCodMinOrder();
            $codMaxOrder = Setting::getCodMaxOrder();
            
            if ($codMinOrder > 0 && $subtotal < $codMinOrder) {
                return response()->json(['success' => false, 'message' => "COD requires minimum order of ₹{$codMinOrder}"]);
            }
            if ($codMaxOrder && $subtotal > $codMaxOrder) {
                return response()->json(['success' => false, 'message' => "COD is not available for orders above ₹{$codMaxOrder}"]);
            }
        }

        $address = Address::findOrFail($request->address_id);
        if ($address->user_id !== auth()->id()) abort(403);

        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty']);
        }

        // Check stock
        foreach ($carts as $cart) {
            if ($cart->product->quantity < $cart->quantity) {
                return response()->json(['success' => false, 'message' => "Not enough stock for {$cart->product->name}"]);
            }
        }

        $subtotal = $carts->sum('total');
        
        // Get settings
        $freeShippingMin = (float) Setting::get('free_shipping_min', '499');
        $shippingCharge = (float) Setting::get('shipping_charge', '40');
        $taxPercent = (float) Setting::get('tax_percent', '18');
        
        $shipping = $subtotal >= $freeShippingMin ? 0 : $shippingCharge;
        $tax = round($subtotal * ($taxPercent / 100), 2);
        $discount = 0;
        $couponCode = null;

        // Apply coupon if provided
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
                $couponCode = $coupon->code;
            }
        }

        $total = $subtotal + $shipping + $tax - $discount;

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => auth()->id(),
            'address_id' => $address->id,
            'subtotal' => $subtotal,
            'shipping_charge' => $shipping,
            'tax' => $tax,
            'discount' => $discount,
            'coupon_code' => $couponCode,
            'total' => $total,
            'name' => $address->name,
            'email' => auth()->user()->email,
            'phone' => $address->phone,
            'address' => $address->full_address,
            'city' => $address->city,
            'state' => $address->state,
            'zip_code' => $address->pincode,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Create order items
        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'product_name' => $cart->product->name,
                'price' => $cart->product->current_price,
                'quantity' => $cart->quantity,
                'total' => $cart->total,
            ]);
        }

        if ($request->payment_method === 'cod') {
            // COD - Complete order
            $this->completeOrder($order, $carts, $couponCode);
            return response()->json([
                'success' => true,
                'payment_method' => 'cod',
                'redirect' => route('orders.show', $order)
            ]);
        }

        // Razorpay payment
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            $razorpayOrder = $api->order->create([
                'receipt' => $order->order_number,
                'amount' => $total * 100, // Amount in paise
                'currency' => 'INR'
            ]);

            $order->update(['razorpay_order_id' => $razorpayOrder->id]);

            return response()->json([
                'success' => true,
                'payment_method' => 'razorpay',
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $total * 100,
                'key' => config('services.razorpay.key'),
                'name' => config('app.name'),
                'email' => auth()->user()->email,
                'phone' => $address->phone,
            ]);
        } catch (\Exception $e) {
            $order->delete();
            return response()->json(['success' => false, 'message' => 'Payment initialization failed']);
        }
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->user_id !== auth()->id()) abort(403);

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $order->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_status' => 'paid',
            ]);

            $carts = auth()->user()->carts()->with('product')->get();
            $this->completeOrder($order, $carts, $order->coupon_code);

            return response()->json([
                'success' => true,
                'redirect' => route('orders.show', $order)
            ]);
        } catch (\Exception $e) {
            $order->update(['payment_status' => 'failed']);
            return response()->json(['success' => false, 'message' => 'Payment verification failed']);
        }
    }

    private function completeOrder($order, $carts, $couponCode)
    {
        DB::transaction(function () use ($order, $carts, $couponCode) {
            // Reduce stock
            foreach ($carts as $cart) {
                $cart->product->decrement('quantity', $cart->quantity);
                $cart->product->increment('sold_count', $cart->quantity);
            }

            // Update coupon usage
            if ($couponCode) {
                Coupon::where('code', $couponCode)->increment('used_count');
            }

            // Clear cart
            auth()->user()->carts()->delete();

            // Update order status for COD
            if ($order->payment_method === 'cod') {
                $order->update(['status' => 'processing']);
            } else {
                $order->update(['status' => 'processing']);
            }
        });
    }
}
