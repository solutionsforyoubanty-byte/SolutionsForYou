@extends('layouts.app')

@section('title', $project->meta_title ?? $project->title . ' | SolutionsForYou')
@section('meta_description', $project->meta_description ?? $project->short_description)
@section('meta_keywords', $project->meta_keywords ?? $project->title)

@section('content')

<!-- PROJECT HERO -->
<section class="project-hero">
    <div class="container">
        <div class="text-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.projects') }}" class="text-white">Projects</a></li>
                    <li class="breadcrumb-item active text-warning">{{ $project->title }}</li>
                </ol>
            </nav>
            <h1 class="project-main-title">{{ $project->title }}</h1>
            <p class="project-subtitle">{{ $project->short_description }}</p>
        </div>
    </div>
</section>

<!-- PROJECT DETAILS -->
<section class="project-details-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Project Image -->
                <div class="project-main-image mb-4" data-aos="fade-up">
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="img-fluid rounded shadow">
                </div>

                <!-- Project Description -->
                <div class="project-description card shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <h3 class="mb-4">About This Project</h3>
                        <div class="content">
                            {!! $project->description !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 project-sticky">
                <!-- Project Info Card -->
                <div class="project-info-card card shadow-sm mb-4" data-aos="fade-left">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Project Details</h5>
                    </div>
                    <div class="card-body">
                        <ul class="project-meta-list">
                            @if($project->client_name)
                            <li>
                                <i class="bi bi-person"></i>
                                <span>Client</span>
                                <strong>{{ $project->client_name }}</strong>
                            </li>
                            @endif

                            @if($project->category)
                            <li>
                                <i class="bi bi-folder"></i>
                                <span>Category</span>
                                <strong>{{ $project->category }}</strong>
                            </li>
                            @endif

                            @if($project->completion_date)
                            <li>
                                <i class="bi bi-calendar"></i>
                                <span>Completed</span>
                                <strong>{{ $project->completion_date->format('M Y') }}</strong>
                            </li>
                            @endif

                            @if($project->project_url)
                            <li>
                                <i class="bi bi-link-45deg"></i>
                                <span>Website</span>
                                <a href="{{ $project->project_url }}" target="_blank" class="text-primary">
                                    Visit Site <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </li>
                            @endif
                        </ul>

                        @if($project->technologies)
                        <hr>
                        <h6 class="mb-3">Technologies Used</h6>
                        <div class="tech-tags">
                            @foreach($project->technologies_array as $tech)
                            <span class="badge bg-light text-dark me-1 mb-1">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- CTA Card -->
                <div class="project-cta-card card shadow-sm" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-body text-center">
                        <h5>Like What You See?</h5>
                        <p class="text-muted">Let's create something amazing together.</p>
                        <a href="{{ url('/services') }}" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-grid"></i> View Our Services
                        </a>
                        <a href="{{ url('/') }}#contact" class="btn btn-outline-primary w-100">
                            <i class="bi bi-chat-dots"></i> Get in Touch
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RELATED PROJECTS -->
@if($relatedProjects->count() > 0)
<section class="related-projects-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Related Projects</h2>
            <p class="section-subtitle">More projects you might like</p>
        </div>

        <div class="row g-4">
            @foreach($relatedProjects as $related)
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="project-card">
                    <div class="project-card-image">
                        <img src="{{ $related->image_url }}" alt="{{ $related->title }}">
                        <div class="project-card-overlay">
                            <a href="{{ route('user.project.show', $related->slug) }}" class="btn btn-primary">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="project-card-body">
                        <span class="project-category-tag">{{ $related->category }}</span>
                        <h4 class="project-title">
                            <a href="{{ route('user.project.show', $related->slug) }}">{{ $related->title }}</a>
                        </h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('user.projects') }}" class="btn btn-outline-primary">
                <i class="bi bi-grid"></i> View All Projects
            </a>
        </div>
    </div>
</section>
@endif

@endsection
