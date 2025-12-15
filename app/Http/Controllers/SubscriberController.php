<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    // User: Subscribe via AJAX
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($request->email));

        // Check if already exists
        $existing = Subscriber::where('email', $email)->first();

        if ($existing) {
            if ($existing->status === 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already subscribed!'
                ], 200);
            }

            // Reactivate unsubscribed user
            $existing->update([
                'status' => 'active',
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Welcome back! You have been re-subscribed.'
            ]);
        }

        // Create new subscriber
        Subscriber::create([
            'email' => $email,
            'status' => 'active',
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing!'
        ]);
    }

    // Admin: List all subscribers
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(20);
        $totalActive = Subscriber::active()->count();
        $totalUnsubscribed = Subscriber::unsubscribed()->count();

        return view('admin.subscribers.index', compact('subscribers', 'totalActive', 'totalUnsubscribed'));
    }

    // Admin: Delete subscriber
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('subscribers.index')->with('success', 'Subscriber deleted successfully!');
    }

    // Admin: Toggle status
    public function toggleStatus($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        
        if ($subscriber->status === 'active') {
            $subscriber->update([
                'status' => 'unsubscribed',
                'unsubscribed_at' => now(),
            ]);
            $message = 'Subscriber marked as unsubscribed.';
        } else {
            $subscriber->update([
                'status' => 'active',
                'unsubscribed_at' => null,
            ]);
            $message = 'Subscriber reactivated.';
        }

        return redirect()->route('subscribers.index')->with('success', $message);
    }

    // Admin: Export subscribers (CSV)
    public function export()
    {
        $subscribers = Subscriber::active()->get();

        $filename = 'subscribers_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Status', 'Subscribed At']);

            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->status,
                    $subscriber->subscribed_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Admin: Newsletter form
    public function newsletterForm()
    {
        $totalActive = Subscriber::active()->count();
        return view('admin.subscribers.newsletter', compact('totalActive'));
    }

    // Admin: Send newsletter
    public function sendNewsletter(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $subscribers = Subscriber::active()->get();
        
        if ($subscribers->isEmpty()) {
            return redirect()->back()->with('error', 'No active subscribers found!');
        }

        $sentCount = 0;
        $failedCount = 0;
        $errors = [];

        foreach ($subscribers as $subscriber) {
            try {
                \Mail::send('emails.newsletter', [
                    'content' => $request->message,
                    'subscriberEmail' => $subscriber->email
                ], function ($mail) use ($subscriber, $request) {
                    $mail->to($subscriber->email)
                         ->subject($request->subject);
                });
                $sentCount++;
            } catch (\Exception $e) {
                $failedCount++;
                $errors[] = $subscriber->email . ': ' . $e->getMessage();
                \Log::error('Newsletter send failed for: ' . $subscriber->email . ' - ' . $e->getMessage());
            }
        }

        if ($sentCount > 0) {
            $message = "Newsletter sent successfully to {$sentCount} subscribers.";
            if ($failedCount > 0) {
                $message .= " Failed: {$failedCount}";
            }
            return redirect()->route('subscribers.newsletter')->with('success', $message);
        } else {
            return redirect()->route('subscribers.newsletter')->with('error', 'Failed to send newsletter. Check mail configuration. Errors: ' . implode(', ', $errors));
        }
    }
}
