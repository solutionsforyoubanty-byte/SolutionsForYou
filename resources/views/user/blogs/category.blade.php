@extends('layouts.app')

@section('title', $category . ' - Blog | SolutionsForYou')
@section('meta_description', 'Browse all blog posts in ' . $category . ' category.')

@section('content')

<!-- BLOG HERO -->
<section class="blog-hero">
    <div class="container">
        <div class="text-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.blogs') }}" class="text-white">Blog</a></li>
                    <li class="breadcrumb-item active text-warning">{{ $category }}</li>
                </ol>
            </nav>
            <h1 class="blog-main-title">{{ $category }}</h1>
            <p class="blog-subtitle">{{ $blogs->total() }} posts in this category</p>
        </div>
    </div>
</section>

<!-- BLOG GRID -->
<section class="blog-grid-section py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($blogs as $blog)
                    <div class="col-md-6" data-aos="fade-up">
                        <div class="blog-card">
                            <div class="blog-image">
                                <a href="{{ route('user.blog.show', $blog->slug) }}">
                                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
                                </a>
                                <span class="category-badge">{{ $blog->category }}</span>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="bi bi-person"></i> {{ $blog->author }}</span>
                                    <span><i class="bi bi-calendar"></i> {{ $blog->published_at?->format('M d, Y') }}</span>
                                </div>
                                <h4><a href="{{ route('user.blog.show', $blog->slug) }}">{{ $blog->title }}</a></h4>
                                <p>{{ Str::limit($blog->excerpt, 120) }}</p>
                                <a href="{{ route('user.blog.show', $blog->slug) }}" class="read-more">
                                    Read More <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="no-blogs text-center py-5">
                            <i class="bi bi-journal-text display-1 text-muted"></i>
                            <h3 class="mt-3">No Posts in This Category</h3>
                            <p class="text-muted">Check back later for new content.</p>
                            <a href="{{ route('user.blogs') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> Back to Blog
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($blogs->hasPages())
                <div class="blog-pagination mt-5">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar-sticky">
                    <!-- Categories -->
                    @if($categories->count() > 0)
                    <div class="sidebar-widget" data-aos="fade-left">
                        <h5>Categories</h5>
                        <ul class="category-list">
                            @foreach($categories as $cat)
                            <li class="{{ $cat == $category ? 'active' : '' }}">
                                <a href="{{ route('user.blog.category', Str::slug($cat)) }}">{{ $cat }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Back to All -->
                    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
                        <a href="{{ route('user.blogs') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-grid"></i> View All Posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
