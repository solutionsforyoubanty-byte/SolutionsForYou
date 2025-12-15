@extends('layouts.app')

@section('title', 'Home | SolutionsForYou')
@section('meta_description', 'Welcome to SolutionsForYou – Best Laravel Developer in India.')
@section('meta_keywords', 'Laravel developer, SolutionsForYou, web development')

@section('og_title', 'SolutionsForYou Homepage')
@section('og_description', 'We provide the best web development services.')
@section('og_image', asset('images/home-og.jpg'))

{{-- JSON-LD --}}
@section('json_ld')
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "SolutionsForYou",
  "url": "{{ url('/') }}"
}
</script>
@endsection

@section('content')
    <!-- HERO SECTION -->
    <section class="hero-section" data-aos="fade-up">
        <div class="container-xxl">
            <div class="hero-content">
                <h5 class="intro-heading">
                    <strong>Hi, I'm <span>Banty</span> — Full Stack Developer</strong>
                </h5>

                <h1 class="hero-title">Welcome to <span>SolutionsForYou</span></h1>
                <p class="hero-subtitle">We build professional portfolios, web apps and more!</p>
                <div class="hero-buttons">
                    <a href="{{ route('user.services.index') }}" class="btn btn-primary">
                        <i class="bi bi-rocket-takeoff"></i> Get Started
                    </a>
                    <a href="#about" class="btn btn-primary btn-outline-primary">
                        <i class="bi bi-info-circle"></i> Learn More
                    </a>
                </div>

                <div class="service-search-box mt-4 position-relative">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="serviceSearch" class="form-control" placeholder="Search service...">

                    </div>

                    <ul class="list-group" id="searchResults"
                        style="display:none; position:absolute; z-index:999; width:100%">
                    </ul>
                    </ul>
                </div>
            </div>
            <!-- Service Search Input -->


        </div>




        </div>
    </section>
   
    {{-- End hero section --}}

    {{-- About section --}}

    <section class="about-section position-relative bnt-section py-5" id="about" data-aos="fade-up">
        <div class="container-xl container-lg container-md container-sm container">
            <div class="heading-section text-center mb-4">
                <h2 class="heading-title">About Us</h2>
                <p class="heading-subtitle">We build digital solutions that help businesses grow faster.</p>
            </div>

            <div class="row align-items-center mt-4">
                <!-- Left Image -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image position-relative">

                        <img src="{{ asset('assets/about/ChatGPT Image Dec 2, 2025, 11_44_14 PM.png') }}"
                            alt="About SolutionsForYou" />

                        <div class="social-icons text-center d-flex align-items-center justify-content-center mt-5">
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>


                        <!-- Experience Badge -->
                        <div class="experience-badge">
                            <span>3+ Years</span>
                            <small>Experience</small>
                        </div>

                    </div>
                </div>


                <!-- Right Content -->
                <div class="col-lg-6">
                    <div class="about-content">
                        <h3>We Are <span>SolutionsForYou</span></h3>
                        <p>
                            We provide high-quality web development, AI tools, branding, and automation services.
                            Our goal is to deliver modern solutions that enhance your business performance.
                        </p>

                        <ul class="about-features">
                            <li><i class="bi bi-check-circle-fill"></i> Clean & Modern UI Design</li>
                            <li><i class="bi bi-check-circle-fill"></i> Fast & Secure Development</li>
                            <li><i class="bi bi-check-circle-fill"></i> SEO & Performance Optimized</li>
                        </ul>

                        <a href="#contact" class="btn about-btn mt-3">
                            <i class="bi bi-envelope"></i> Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- End about section --}}

    {{-- Technology section --}}

    <section class="tech-section py-5" id="services">
        <div class="container">

            <div class="heading-section text-center mb-4">
                <h2 class="heading-title">Our Services</h2>
                <p class="heading-subtitle">We build fast, modern & scalable digital solutions</p>
            </div>

            <div class="row g-4">

                @forelse ($services as $service)
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <a href="{{ route('user.service.show', $service->slug) }}" class="text-decoration-none">
                            <div class="tech-card">

                            <!-- Image -->
                            <img src="{{ $service->image_url }}" class="mb-3 rounded"
                                alt="{{ $service->title }}">

                            <!-- Title -->
                            <h4>{{ $service->title }}</h4>

                            <!-- Description -->
                            <p>{{ Str::limit($service->short_description, 100) }}</p>

                            <!-- View More Button -->
                            <div class="card-footer">
                                <span class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-arrow-right"></i> View Details
                                </span>
                            </div>

                        </div>
                        </a>
                        
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No services available at the moment.</p>
                        {{-- <a href="{{ route('services.index') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add Services
                        </a> --}}
                    </div>
                @endforelse

            </div>

            @if($services->hasPages())
            <div class="mt-4 text-center">
                {{ $services->links('pagination::bootstrap-5') }}
            </div>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('user.services.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-grid-3x3-gap"></i> View All Services
                </a>
            </div>

        </div>
    </section>


    {{-- End technology section --}}

    {{-- our projects section --}}
    <section class="projects-section py-5">
        <div class="container">
            <div class="row">

                <!-- Left Sticky Title -->
                <div class="col-lg-4" data-aos="fade-right">
                    <div class="project-left sticky-top">
                        <h2 class="project-title">Our Projects</h2>
                        <p class="project-sub">
                            Some of the recent works we proudly delivered for our clients.
                        </p>

                        <div class="project-actions">
                            <a href="{{ route('user.projects') }}" class="btn btn-project">
                                <i class="bi bi-grid-fill"></i> View All Projects
                            </a>

                            <a href="#contact" class="btn btn-outline-project mt-2">
                                <i class="bi bi-envelope-fill"></i> Start a Project
                            </a>
                        </div>
                    </div>
                </div>


                <!-- Right Scrolling Project Cards -->
                <div class="col-lg-8">
                    <div class="projects-list">

                        @forelse($projects as $project)
                        <div class="project-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <a href="{{ route('user.project.show', $project->slug) }}" class="text-decoration-none">
                                <div class="project-img">
                                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                                    @if($project->is_featured)
                                    <span class="project-featured-badge">
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                    @endif
                                </div>
                                <div class="project-info">
                                    <span class="project-category-badge">{{ $project->category ?? 'Project' }}</span>
                                    <h4>{{ $project->title }}</h4>
                                    <p>{{ Str::limit($project->short_description, 80) }}</p>
                                    @if($project->technologies)
                                    <div class="project-tech-tags">
                                        @foreach(array_slice($project->technologies_array, 0, 3) as $tech)
                                        <span class="tech-badge">{{ trim($tech) }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @empty
                        <div class="no-projects-message text-center py-5">
                            <i class="bi bi-folder2-open display-4 text-muted"></i>
                            <h5 class="mt-3 text-muted">No Projects Yet</h5>
                            <p class="text-muted">We're working on adding our portfolio. Check back soon!</p>
                        </div>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- end our projects section --}}

    {{-- why choose section --}}

    <section class="why-section py-5">
        <div class="container">
            <div class="row align-items-start">

                <!-- LEFT SIDE (Sticky Area) -->
                <div class="col-lg-4" data-aos="fade-right">
                    <div class="left-sticky">
                        <h2 class="section-title fw-bold">Why Choose Us</h2>
                        <p class="section-subtitle">
                            We provide high-quality solutions with modern design, secure development,
                            and outstanding performance.
                        </p>

                        <a href="#contact" class="btn btn-dark mt-3">
                            Contact Us
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- RIGHT SIDE (2 Columns Grid) -->
                <div class="col-lg-8">
                    <div class="row features-grid">

                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-lightning-charge-fill"></i>
                                <div>
                                    <h4>Fast Delivery</h4>
                                    <p>We complete projects quickly without compromising quality.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-code-slash"></i>
                                <div>
                                    <h4>Clean & Scalable Code</h4>
                                    <p>Modern coding standards ensure long-term maintainability.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-shield-lock-fill"></i>
                                <div>
                                    <h4>Top Security</h4>
                                    <p>Your application stays protected with advanced security.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-headset"></i>
                                <div>
                                    <h4>24/7 Support</h4>
                                    <p>Our team is always ready to <br> help you.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    {{-- end why choose section --}}

    {{-- Blog Section with Swiper --}}
    @if($blogs->count() > 0)
    <section class="blog-slider-section py-5">
        <div class="container">
            <div class="heading-section text-center mb-5" data-aos="fade-up">
                <h2 class="heading-title">Latest from Our Blog</h2>
                <p class="heading-subtitle">Insights, tutorials, and updates from our team</p>
            </div>

            <div class="swiper blogSwiper" data-aos="fade-up">
                <div class="swiper-wrapper">
                    @foreach($blogs as $blog)
                    <div class="swiper-slide">
                        <div class="blog-slide-card">
                            <div class="blog-slide-image">
                                <a href="{{ route('user.blog.show', $blog->slug) }}">
                                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
                                </a>
                                <span class="blog-category">{{ $blog->category ?? 'Blog' }}</span>
                            </div>
                            <div class="blog-slide-content">
                                <div class="blog-slide-meta">
                                    <span><i class="bi bi-calendar"></i> {{ $blog->published_at?->format('M d, Y') }}</span>
                                    <span><i class="bi bi-clock"></i> {{ $blog->read_time }}</span>
                                </div>
                                <h4><a href="{{ route('user.blog.show', $blog->slug) }}">{{ Str::limit($blog->title, 50) }}</a></h4>
                                <p>{{ Str::limit($blog->excerpt, 100) }}</p>
                                <a href="{{ route('user.blog.show', $blog->slug) }}" class="read-more-link">
                                    Read More <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('user.blogs') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-journal-text"></i> View All Posts
                </a>
            </div>
        </div>
    </section>
    @endif
    {{-- End Blog Section --}}

    {{-- CTA SECTIONS --}}
    <section class="cta-subscribe-section" data-aos="zoom-in">
        <div class="cta-overlay"></div>

        <div class="container text-center cta-content">
            <h2 class="cta-title">Stay Updated <span>With Us</span></h2>
            <p class="cta-subtitle">Subscribe now to get the latest updates, services & special offers.</p>

            <form class="cta-form d-flex justify-content-center" id="subscribeForm">
                @csrf
                <input type="email" name="email" id="subscribeEmail" placeholder="Enter your email" required />
                <button type="submit" id="subscribeBtn">
                    Subscribe <i class="bi bi-send-fill"></i>
                </button>
            </form>
            <div id="subscribeMessage" class="mt-3" style="display: none;"></div>
        </div>
    </section>


@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('subscribeForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('subscribeEmail').value;
            const btn = document.getElementById('subscribeBtn');
            const msgDiv = document.getElementById('subscribeMessage');
            const originalBtnText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Please wait...';
            
            fetch('{{ route("subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                msgDiv.style.display = 'block';
                if (data.success) {
                    msgDiv.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> ' + data.message + '</span>';
                    document.getElementById('subscribeEmail').value = '';
                } else {
                    msgDiv.innerHTML = '<span class="text-warning"><i class="bi bi-info-circle"></i> ' + data.message + '</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                msgDiv.style.display = 'block';
                msgDiv.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle"></i> Something went wrong. Please try again.</span>';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalBtnText;
                setTimeout(() => { msgDiv.style.display = 'none'; }, 5000);
            });
        });
    }
});
</script>
@endpush
