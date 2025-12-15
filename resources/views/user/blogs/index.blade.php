@extends('layouts.app')

@section('title', 'Blog | SolutionsForYou')
@section('meta_description', 'Read our latest articles on web development, technology, and business.')

@section('content')

<!-- BLOG HERO -->
<section class="blog-hero">
    <div class="container">
        <div class="text-center">
            <h1 class="blog-main-title">Our <span>Blog</span></h1>
            <p class="blog-subtitle">Insights, tutorials, and updates from our team</p>
        </div>
    </div>
</section>

<!-- FEATURED POSTS -->
@if($featuredBlogs->count() > 0)
<section class="featured-blogs-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Featured Posts</h2>
        </div>

        <div class="row g-4">
            @foreach($featuredBlogs as $blog)
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="blog-card featured">
                    <div class="blog-image">
                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
                        <span class="featured-badge"><i class="bi bi-star-fill"></i> Featured</span>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="bi bi-folder"></i> {{ $blog->category }}</span>
                            <span><i class="bi bi-clock"></i> {{ $blog->read_time }}</span>
                        </div>
                        <h4><a href="{{ route('user.blog.show', $blog->slug) }}">{{ $blog->title }}</a></h4>
                        <p>{{ Str::limit($blog->excerpt, 100) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

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
                                <span class="category-badge">{{ $blog->category ?? 'Blog' }}</span>
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
                            <h3 class="mt-3">No Blog Posts Yet</h3>
                            <p class="text-muted">We're working on creating great content. Check back soon!</p>
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
                            <li><a href="{{ route('user.blog.category', Str::slug($cat)) }}">{{ $cat }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Popular Posts -->
                    @if($popularBlogs->count() > 0)
                    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
                        <h5>Popular Posts</h5>
                        @foreach($popularBlogs as $popular)
                        <div class="popular-post">
                            <img src="{{ $popular->image_url }}" alt="{{ $popular->title }}">
                            <div>
                                <a href="{{ route('user.blog.show', $popular->slug) }}">{{ Str::limit($popular->title, 50) }}</a>
                                <small><i class="bi bi-eye"></i> {{ $popular->views }} views</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
