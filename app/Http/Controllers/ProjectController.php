<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    // Admin Methods
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
            'category' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $data = $request->only([
            'title', 'category', 'short_description', 'description',
            'client_name', 'project_url', 'technologies', 'completion_date',
            'status', 'meta_title', 'meta_description', 'meta_keywords'
        ]);
        
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['status'] = $request->status ?? 'active';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/projects'), $imageName);
            $data['image'] = $imageName;
        }

        Project::create($data);

        return redirect()->route('projects.index')->with('toast_success', 'Project Added Successfully!');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image && file_exists(public_path('uploads/projects/' . $project->image))) {
                unlink(public_path('uploads/projects/' . $project->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/projects'), $imageName);
            $data['image'] = $imageName;
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('toast_success', 'Project Updated Successfully!');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        
        // Delete image
        if ($project->image && file_exists(public_path('uploads/projects/' . $project->image))) {
            unlink(public_path('uploads/projects/' . $project->image));
        }
        
        $project->delete();

        return redirect()->route('projects.index')->with('toast_success', 'Project Deleted Successfully!');
    }

    // User/Frontend Methods
    public function userIndex()
    {
        $projects = Project::active()->latest()->paginate(12);
        $featuredProjects = Project::active()->featured()->take(3)->get();
        $categories = Project::active()->distinct()->pluck('category')->filter();
        
        return view('user.projects.index', compact('projects', 'featuredProjects', 'categories'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::active()
            ->where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->take(3)
            ->get();
            
        return view('user.projects.show', compact('project', 'relatedProjects'));
    }
}
