@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->title . ' | SolutionsForYou')
@section('meta_description', $blog->meta_description ?? $blog->excerpt)
@section('meta_keywords', $blog->meta_keywords ?? $blog->tags)

@section('content')

<!-- BLOG HERO -->
<section class="blog-hero">
    <div class="container">
        <div class="text-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.blogs') }}" class="text-white">Blog</a></li>
                    <li class="breadcrumb-item active text-warning">{{ Str::limit($blog->title, 30) }}</li>
                </ol>
            </nav>
            <h1 class="blog-main-title">{{ $blog->title }}</h1>
            <div class="blog-post-meta">
                <span><i class="bi bi-person"></i> {{ $blog->author }}</span>
                <span><i class="bi bi-calendar"></i> {{ $blog->published_at?->format('M d, Y') }}</span>
                <span><i class="bi bi-clock"></i> {{ $blog->read_time }}</span>
                <span><i class="bi bi-eye"></i> {{ $blog->views }} views</span>
            </div>
        </div>
    </div>
</section>

<!-- BLOG CONTENT -->
<section class="blog-content-section py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Featured Image -->
                <div class="blog-featured-image mb-4" data-aos="fade-up">
                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="img-fluid rounded shadow">
                </div>

                <!-- Tags -->
                @if($blog->tags)
                <div class="blog-tags mb-4" data-aos="fade-up">
                    @foreach($blog->tags_array as $tag)
                    <span class="tag-badge"><i class="bi bi-tag"></i> {{ trim($tag) }}</span>
                    @endforeach
                </div>
                @endif

                <!-- Content -->
                <div class="blog-article card shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <div class="article-content">
                            {!! $blog->content !!}
                        </div>
                    </div>
                </div>

                <!-- Share -->
                <div class="blog-share mt-4" data-aos="fade-up">
                    <h5>Share this post:</h5>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="btn btn-twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($blog->title) }}" target="_blank" class="btn btn-linkedin">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . request()->url()) }}" target="_blank" class="btn btn-whatsapp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar-sticky">
                    <!-- Author Card -->
                    <div class="sidebar-widget author-card" data-aos="fade-left">
                        <h5>About Author</h5>
                        <div class="author-info">
                            <div class="author-avatar">{{ substr($blog->author, 0, 1) }}</div>
                            <h6>{{ $blog->author }}</h6>
                            <p class="text-muted">Content Writer at SolutionsForYou</p>
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    @if($recentBlogs->count() > 0)
                    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
                        <h5>Recent Posts</h5>
                        @foreach($recentBlogs as $recent)
                        <div class="popular-post">
                            <img src="{{ $recent->image_url }}" alt="{{ $recent->title }}">
                            <div>
                                <a href="{{ route('user.blog.show', $recent->slug) }}">{{ Str::limit($recent->title, 45) }}</a>
                                <small>{{ $recent->published_at?->format('M d, Y') }}</small>
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

<!-- RELATED POSTS -->
@if($relatedBlogs->count() > 0)
<section class="related-blogs-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Related Posts</h2>
        </div>

        <div class="row g-4">
            @foreach($relatedBlogs as $related)
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="blog-card">
                    <div class="blog-image">
                        <a href="{{ route('user.blog.show', $related->slug) }}">
                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}">
                        </a>
                    </div>
                    <div class="blog-content">
                        <h4><a href="{{ route('user.blog.show', $related->slug) }}">{{ $related->title }}</a></h4>
                        <p>{{ Str::limit($related->excerpt, 80) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
