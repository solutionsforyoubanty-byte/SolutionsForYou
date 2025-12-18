<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceQuestion;
use App\Models\ServiceInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(5);
        return view('admin.services.index', compact('services'));
    }

    public function UserIndex()
    {
        $services = Service::latest()->paginate(10);
        $projects = \App\Models\Project::active()->latest()->take(6)->get();
        $blogs = \App\Models\Blog::published()->latest('published_at')->take(6)->get();
        return view('home', compact('services', 'projects', 'blogs'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,png,jpeg,webp,avif|max:2048',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/services'), $image);
        }

        Service::create([
            'title' => $validated['title'],
            'slug' => null, // Auto slug via model
            'image' => $image,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'basic_price' => $request->basic_price,
            'standard_price' => $request->standard_price,
            'premium_price' => $request->premium_price,
            'basic_features' => $request->basic_features,
            'standard_features' => $request->standard_features,
            'premium_features' => $request->premium_features,
            'basic_delivery' => $request->basic_delivery,
            'standard_delivery' => $request->standard_delivery,
            'premium_delivery' => $request->premium_delivery,
            'show_pricing' => $request->has('show_pricing'),
        ]);

        return redirect()->route('services.index')
            ->with('toast_success', 'Service Added Successfully!');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp,avif|max:2048',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $image = $service->image;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($image && file_exists(public_path("uploads/services/$image"))) {
                unlink(public_path("uploads/services/$image"));
            }
            $image = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/services'), $image);
        }

        $service->update([
            'title' => $validated['title'],
            'image' => $image,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'basic_price' => $request->basic_price,
            'standard_price' => $request->standard_price,
            'premium_price' => $request->premium_price,
            'basic_features' => $request->basic_features,
            'standard_features' => $request->standard_features,
            'premium_features' => $request->premium_features,
            'basic_delivery' => $request->basic_delivery,
            'standard_delivery' => $request->standard_delivery,
            'premium_delivery' => $request->premium_delivery,
            'show_pricing' => $request->has('show_pricing'),
        ]);

        return redirect()->route('services.index')
            ->with('toast_success', 'Service Updated Successfully!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Delete image
        if ($service->image && file_exists(public_path("uploads/services/" . $service->image))) {
            unlink(public_path("uploads/services/" . $service->image));
        }

        $service->delete();

        return back()->with('toast_success', 'Service Deleted!');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $services = Service::where('title', 'LIKE', "%{$query}%")
            ->orWhere('short_description', 'LIKE', "%{$query}%")
            ->select('id', 'title', 'slug', 'short_description', 'image')
            ->take(10)
            ->get();

        return response()->json($services);
    }

    public function saveInquiry(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'timeline' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:1000',
            'question_1' => 'nullable|string|max:500',
            'question_2' => 'nullable|string|max:500',
            'question_3' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            ServiceInquiry::create([
                'service_id' => $request->service_id,
                'question_1' => $request->question_1,
                'question_2' => $request->question_2,
                'question_3' => $request->question_3,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'timeline' => $request->timeline,
                'message' => $request->message,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Inquiry submitted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Inquiry submission error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function getQuestions(Request $request)
    {
        $serviceId = $request->get('service_id');

        if (!$serviceId) {
            return response()->json([]);
        }

        $questions = ServiceQuestion::where('service_id', $serviceId)
            ->select('id', 'question')
            ->get();

        return response()->json($questions);
    }

      /**
     * Show questions page for a service
     */
    public function questionsPage($id)
    {
        $service = Service::findOrFail($id);
        $questions = ServiceQuestion::where('service_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.services.questions', compact('service', 'questions'));
    }

    /**
     * Add a new question
     */
    public function addQuestion(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'question' => 'required|string|min:10|max:500'
        ], [
            'question.required' => 'Question field is required',
            'question.min' => 'Question must be at least 10 characters',
            'question.max' => 'Question must not exceed 500 characters'
        ]);

        try {
            ServiceQuestion::create([
                'service_id' => $validated['service_id'],
                'question' => $validated['question']
            ]);

            return back()->with('success', 'Question added successfully!');
        } catch (\Exception $e) {
            Log::error('Error adding question: ' . $e->getMessage());
            return back()->with('error', 'Failed to add question. Please try again.');
        }
    }

    /**
     * Update an existing question
     */
    public function updateQuestion(Request $request, $id)
    {
        $question = ServiceQuestion::findOrFail($id);

        $validated = $request->validate([
            'question' => 'required|string|min:10|max:500'
        ], [
            'question.required' => 'Question field is required',
            'question.min' => 'Question must be at least 10 characters',
            'question.max' => 'Question must not exceed 500 characters'
        ]);

        try {
            $question->update([
                'question' => $validated['question']
            ]);

            return back()->with('success', 'Question updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating question: ' . $e->getMessage());
            return back()->with('error', 'Failed to update question. Please try again.');
        }
    }

    /**
     * Delete a question
     */
    public function deleteQuestion($id)
    {
        try {
            $question = ServiceQuestion::findOrFail($id);
            $question->delete();

            return back()->with('success', 'Question deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting question: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete question. Please try again.');
        }
    }

    // Services index page
    public function serviceIndex()
    {
        $services = Service::latest()->paginate(12);
        return view('user.services.index', compact('services'));
    }

    // Show single service details
    public function Usershow($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        // Get related services (exclude current, limit 4)
        $relatedServices = Service::where('id', '!=', $service->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('user.services.show', compact('service', 'relatedServices'));
    }

        // Show single service details
    public function show($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        // Get related services (exclude current, limit 4)
        $relatedServices = Service::where('id', '!=', $service->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('user.services.show', compact('service', 'relatedServices'));
    }

    // Pricing page
    public function pricing()
    {
        $services = Service::where('show_pricing', true)
            ->whereNotNull('basic_price')
            ->orWhereNotNull('standard_price')
            ->orWhereNotNull('premium_price')
            ->latest()
            ->get();

        return view('user.pricing.index', compact('services'));
    }
}