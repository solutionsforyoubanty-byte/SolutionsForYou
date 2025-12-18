<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::withCount('applications')->latest()->paginate(15);
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Full-time,Part-time,Contract,Internship',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        Career::create($request->all());

        return redirect()->route('admin.careers.index')->with('success', 'Job posting created!');
    }

    public function edit(Career $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, Career $career)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Full-time,Part-time,Contract,Internship',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $career->update($request->all());

        return redirect()->route('admin.careers.index')->with('success', 'Job posting updated!');
    }

    public function destroy(Career $career)
    {
        $career->delete();
        return redirect()->route('admin.careers.index')->with('success', 'Job posting deleted!');
    }

    // Applications
    public function applications()
    {
        $applications = JobApplication::with('career')->latest()->paginate(15);
        return view('admin.careers.applications', compact('applications'));
    }

    public function showApplication(JobApplication $application)
    {
        if ($application->status === 'new') {
            $application->update(['status' => 'reviewing']);
        }
        return view('admin.careers.application-show', compact('application'));
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:new,reviewing,shortlisted,rejected,hired',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update($request->only('status', 'admin_notes'));

        return redirect()->back()->with('success', 'Application status updated!');
    }

    public function destroyApplication(JobApplication $application)
    {
        $application->delete();
        return redirect()->route('admin.careers.applications')->with('success', 'Application deleted!');
    }
}
