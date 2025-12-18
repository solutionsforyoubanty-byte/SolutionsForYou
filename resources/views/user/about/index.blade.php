@extends('layouts.app')

@section('title', 'About Us | SolutionsForYou')
@section('meta_description', 'Learn about SolutionsForYou - Your trusted partner for web development, mobile apps, and digital solutions.')

@push('styles')
@vite('resources/css/about.scss')
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="hero-badge"><i class="bi bi-building"></i> About Us</span>
            <h1 class="hero-title">We Build <span>Digital Solutions</span><br>That Matter</h1>
            <p class="hero-desc">We're a passionate team of developers, designers, and digital strategists dedicated to transforming your ideas into powerful digital experiences.</p>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="story-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="story-image">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=500&fit=crop" alt="Our Team" class="img-fluid">
                    <div class="experience-badge">
                        <div class="number">5+</div>
                        <span>Years Experience</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="story-content">
                    <span class="section-badge">Our Story</span>
                    <h2>Turning Ideas Into Digital Reality Since 2019</h2>
                    <p>SolutionsForYou was founded with a simple mission: to help businesses of all sizes harness the power of technology. What started as a small team of passionate developers has grown into a full-service digital agency.</p>
                    <p>We believe that great technology should be accessible to everyone. That's why we focus on delivering high-quality solutions at competitive prices, without compromising on quality or customer service.</p>
                    <p>Our team combines creativity with technical expertise to deliver solutions that not only look great but also perform exceptionally. We're not just service providers – we're your digital partners.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Projects Completed</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-item">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Team Members</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="stat-item">
                    <div class="stat-number">99%</div>
                    <div class="stat-label">Client Satisfaction</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge" style="background: white;">Our Values</span>
            <h2 class="section-title">What Drives Us Forward</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p>We stay ahead of the curve, embracing new technologies and creative solutions.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4>Quality</h4>
                    <p>We never compromise on quality, delivering excellence in every project.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4>Collaboration</h4>
                    <p>We work closely with clients, treating their goals as our own.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>Integrity</h4>
                    <p>We build trust through transparency, honesty, and reliability.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Our Team</span>
            <h2 class="section-title">Meet The Experts</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card">
                    <div class="team-image">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face" alt="Team Member">
                        <div class="team-social">
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h4>Rahul Sharma</h4>
                        <p>Founder & CEO</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card">
                    <div class="team-image">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop&crop=face" alt="Team Member">
                        <div class="team-social">
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-dribbble"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h4>Priya Patel</h4>
                        <p>Lead Designer</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card">
                    <div class="team-image">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop&crop=face" alt="Team Member">
                        <div class="team-social">
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-github"></i></a>
                            <a href="#"><i class="bi bi-stack-overflow"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h4>Amit Kumar</h4>
                        <p>Senior Developer</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="team-card">
                    <div class="team-image">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop&crop=face" alt="Team Member">
                        <div class="team-social">
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h4>Sneha Gupta</h4>
                        <p>Project Manager</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Section -->
<section class="why-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-badge" style="background: white;">Why Choose Us</span>
                <h2 class="section-title">What Makes Us Different</h2>
                
                <div class="why-item">
                    <div class="why-icon">
                        <i class="bi bi-rocket-takeoff"></i>
                    </div>
                    <div>
                        <h4>Fast Delivery</h4>
                        <p>We understand time is money. Our agile approach ensures quick turnaround without compromising quality.</p>
                    </div>
                </div>
                
                <div class="why-item">
                    <div class="why-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <div>
                        <h4>24/7 Support</h4>
                        <p>Our dedicated support team is always available to help you with any questions or issues.</p>
                    </div>
                </div>
                
                <div class="why-item">
                    <div class="why-icon">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                    <div>
                        <h4>Affordable Pricing</h4>
                        <p>Premium quality services at competitive prices. No hidden costs, transparent pricing.</p>
                    </div>
                </div>
                
                <div class="why-item">
                    <div class="why-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <h4>Free Revisions</h4>
                        <p>We work until you're 100% satisfied. Multiple revision rounds included in every project.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&h=500&fit=crop" alt="Why Choose Us" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="about-cta">
    <div class="cta-shapes">
        <div class="shape cta-shape-1"></div>
        <div class="shape cta-shape-2"></div>
    </div>
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>Ready to Start Your Project?</h2>
            <p>Let's work together to bring your vision to life. Get in touch with us today!</p>
            <a href="{{ url('/#contact') }}" class="btn-cta">
                <i class="bi bi-chat-dots"></i> Let's Talk
            </a>
        </div>
    </div>
</section>
@endsection
