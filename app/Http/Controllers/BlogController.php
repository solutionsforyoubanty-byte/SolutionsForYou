<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // Admin Methods
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
        ]);

        $data = $request->only([
            'title', 'category', 'excerpt', 'content', 'author', 'tags',
            'status', 'meta_title', 'meta_description', 'meta_keywords'
        ]);
        
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['status'] = $request->status ?? 'draft';
        $data['author'] = $request->author ?? 'Admin';
        
        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/blogs'), $imageName);
            $data['image'] = $imageName;
        }

        Blog::create($data);

        return redirect()->route('blogs.index')->with('toast_success', 'Blog Post Created Successfully!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
        ]);

        $data = $request->only([
            'title', 'category', 'excerpt', 'content', 'author', 'tags',
            'status', 'meta_title', 'meta_description', 'meta_keywords'
        ]);
        
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        
        if ($request->status === 'published' && !$blog->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            if ($blog->image && file_exists(public_path('uploads/blogs/' . $blog->image))) {
                unlink(public_path('uploads/blogs/' . $blog->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/blogs'), $imageName);
            $data['image'] = $imageName;
        }

        $blog->update($data);

        return redirect()->route('blogs.index')->with('toast_success', 'Blog Post Updated Successfully!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        
        if ($blog->image && file_exists(public_path('uploads/blogs/' . $blog->image))) {
            unlink(public_path('uploads/blogs/' . $blog->image));
        }
        
        $blog->delete();

        return redirect()->route('blogs.index')->with('toast_success', 'Blog Post Deleted Successfully!');
    }

    // User/Frontend Methods
    public function userIndex()
    {
        $blogs = Blog::published()->latest('published_at')->paginate(12);
        $featuredBlogs = Blog::published()->featured()->latest()->take(3)->get();
        $categories = Blog::published()->distinct()->pluck('category')->filter();
        $popularBlogs = Blog::published()->orderBy('views', 'desc')->take(5)->get();
        
        return view('user.blogs.index', compact('blogs', 'featuredBlogs', 'categories', 'popularBlogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $blog->incrementViews();
        
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('category', $blog->category)
            ->take(3)
            ->get();
        
        $recentBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(5)
            ->get();
            
        return view('user.blogs.show', compact('blog', 'relatedBlogs', 'recentBlogs'));
    }

    public function byCategory($category)
    {
        // Find actual category name from slug
        $categories = Blog::published()->distinct()->pluck('category')->filter();
        $actualCategory = $categories->first(function ($cat) use ($category) {
            return \Illuminate\Support\Str::slug($cat) === $category;
        });

        if (!$actualCategory) {
            abort(404);
        }

        $blogs = Blog::published()->byCategory($actualCategory)->latest()->paginate(12);
        
        return view('user.blogs.category', [
            'blogs' => $blogs,
            'categories' => $categories,
            'category' => $actualCategory
        ]);
    }
}
