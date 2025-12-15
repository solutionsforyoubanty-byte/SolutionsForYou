<?php

namespace App\Http\Controllers;

use App\Models\ServiceInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries
     */
    public function index(Request $request)
    {
        $status = $request->get('status');

        // Build query
        $query = ServiceInquiry::with('service')->latest();

        // Filter by status if provided
        if ($status && in_array($status, ['pending', 'in_progress', 'completed'])) {
            $query->where('status', $status);
        }

        // Paginate results
        $inquiries = $query->paginate(15);

        // Calculate stats
        $stats = [
            'total' => ServiceInquiry::count(),
            'pending' => ServiceInquiry::where('status', 'pending')->count(),
            'in_progress' => ServiceInquiry::where('status', 'in_progress')->count(),
            'completed' => ServiceInquiry::where('status', 'completed')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'stats'));
    }

    /**
     * Display the specified inquiry
     */
    public function show($id)
    {
        $inquiry = ServiceInquiry::with('service')->findOrFail($id);

        // Mark as read if pending
        if ($inquiry->status === 'pending') {
            $inquiry->update(['status' => 'in_progress']);
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Update inquiry status
     */
    public function updateStatus(Request $request, $id)
    {
        $inquiry = ServiceInquiry::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        try {
            $inquiry->update([
                'status' => $validated['status']
            ]);

            return back()->with('success', 'Inquiry status updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating inquiry status: ' . $e->getMessage());
            return back()->with('error', 'Failed to update status. Please try again.');
        }
    }

    /**
     * Delete inquiry
     */
    public function destroy($id)
    {
        try {
            $inquiry = ServiceInquiry::findOrFail($id);
            $inquiry->delete();

            return redirect()->route('inquiries.index')
                ->with('success', 'Inquiry deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting inquiry: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete inquiry. Please try again.');
        }
    }
}