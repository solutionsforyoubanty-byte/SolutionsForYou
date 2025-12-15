@extends('layouts.app')

@section('title', 'Our Projects | SolutionsForYou')
@section('meta_description', 'Explore our portfolio of successful web development projects.')

@section('content')

<!-- PROJECTS HERO SECTION -->
<section class="project-hero">
    <div class="container">
        <div class="text-center">
            <h1 class="project-main-title">
                Our <span>Projects</span> Portfolio
            </h1>
            <p class="project-subtitle">
                Explore our successful projects and see how we've helped businesses grow.
            </p>
        </div>
    </div>
</section>

<!-- FEATURED PROJECTS -->
@if($featuredProjects->count() > 0)
<section class="featured-projects-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle">Our most impactful work</p>
        </div>

        <div class="row g-4">
            @foreach($featuredProjects as $project)
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="featured-project-card">
                    <div class="project-image">
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                        <div class="project-overlay">
                            <a href="{{ route('user.project.show', $project->slug) }}" class="btn btn-light">
                                <i class="bi bi-eye"></i> View Project
                            </a>
                        </div>
                    </div>
                    <div class="project-info">
                        <span class="project-category">{{ $project->category }}</span>
                        <h4>{{ $project->title }}</h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- PROJECTS FILTER & GRID -->
<section class="projects-grid-section py-5">
    <div class="container">
        <!-- Filter Buttons -->
        @if($categories->count() > 0)
        <div class="projects-filter text-center mb-5" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">All</button>
            @foreach($categories as $category)
            <button class="filter-btn" data-filter="{{ Str::slug($category) }}">{{ $category }}</button>
            @endforeach
        </div>
        @endif

        <!-- Projects Grid -->
        <div class="row g-4" id="projectsGrid">
            @forelse($projects as $project)
            <div class="col-12 col-md-6 col-lg-4 project-item" data-category="{{ Str::slug($project->category) }}" data-aos="fade-up">
                <div class="project-card">
                    <div class="project-card-image">
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                        <div class="project-card-overlay">
                            <a href="{{ route('user.project.show', $project->slug) }}" class="btn btn-primary">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        @if($project->is_featured)
                        <span class="featured-badge"><i class="bi bi-star-fill"></i></span>
                        @endif
                    </div>
                    <div class="project-card-body">
                        <span class="project-category-tag">{{ $project->category ?? 'Project' }}</span>
                        <h4 class="project-title">
                            <a href="{{ route('user.project.show', $project->slug) }}">{{ $project->title }}</a>
                        </h4>
                        <p class="project-description">{{ Str::limit($project->short_description, 80) }}</p>
                        
                        @if($project->technologies)
                        <div class="project-tech">
                            @foreach(array_slice($project->technologies_array, 0, 3) as $tech)
                            <span class="tech-tag">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="no-projects text-center py-5">
                    <i class="bi bi-folder2-open display-1 text-muted"></i>
                    <h3 class="mt-3">No Projects Yet</h3>
                    <p class="text-muted">We're working on adding our portfolio. Check back soon!</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="projects-pagination mt-5" data-aos="fade-up">
            <div class="d-flex justify-content-center">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</section>

<!-- CTA SECTION -->
<section class="projects-cta-section" data-aos="zoom-in">
    <div class="cta-overlay"></div>
    <div class="container text-center cta-content">
        <h2 class="cta-title">Have a Project in Mind?</h2>
        <p class="cta-subtitle">Let's work together to bring your ideas to life.</p>
        <div class="cta-actions">
            <a href="{{ url('/services') }}" class="btn btn-light btn-lg me-3">
                <i class="bi bi-grid"></i> Our Services
            </a>
            <a href="{{ url('/') }}#contact" class="btn btn-outline-light btn-lg">
                <i class="bi bi-chat-dots"></i> Contact Us
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            projectItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    item.style.animation = 'fadeIn 0.5s ease';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush
