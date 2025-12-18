@extends('layouts.app')

@section('title', 'Contact Us | SolutionsForYou')
@section('meta_description', 'Get in touch with us for your web development, mobile app, and digital service needs.')

@push('styles')
@vite('resources/css/contact.scss')
@endpush

@section('content')
<!-- Hero Section -->
<section class="contact-hero">
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container">
        <div class="hero-content text-center" data-aos="fade-up">
            <span class="hero-badge"><i class="bi bi-chat-dots-fill"></i> Get In Touch</span>
            <h1 class="hero-title">Let's Start a <span>Conversation</span></h1>
            <p class="hero-subtitle">Have a project in mind? We'd love to hear from you.</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="contact-form-card">
                    <div class="form-header">
                        <h2>Send us a Message</h2>
                        <p>Fill out the form below and we'll get back to you within 24 hours.</p>
                    </div>
                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name"><i class="bi bi-person"></i> Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="John Doe" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><i class="bi bi-envelope"></i> Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" 
                                           placeholder="john@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"><i class="bi bi-phone"></i> Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}" 
                                           placeholder="+91 98765 43210">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_id"><i class="bi bi-grid"></i> Choose Service</label>
                                    <select class="form-control @error('service_id') is-invalid @enderror" 
                                            id="service_id" name="service_id">
                                        <option value="">Select a service (optional)</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subject"><i class="bi bi-chat-left-text"></i> Subject</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" name="subject" value="{{ old('subject') }}" 
                                           placeholder="How can we help you?">
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message"><i class="bi bi-pencil"></i> Your Message</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" rows="5" 
                                              placeholder="Tell us about your project..." required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send"></i>
                                    <span>Send Message</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="contact-info-wrapper">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="info-content">
                            <h4>Our Location</h4>
                            <p>123 Business Street, Tech Park<br>New Delhi, India 110001</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="info-content">
                            <h4>Email Us</h4>
                            <p><a href="mailto:hello@solutionsforyou.com">hello@solutionsforyou.com</a></p>
                            <p><a href="mailto:support@solutionsforyou.com">support@solutionsforyou.com</a></p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="info-content">
                            <h4>Call Us</h4>
                            <p><a href="tel:+919876543210">+91 98765 43210</a></p>
                            <p><a href="tel:+919876543211">+91 98765 43211</a></p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div class="info-content">
                            <h4>Working Hours</h4>
                            <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p>Saturday: 10:00 AM - 4:00 PM</p>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="social-links">
                        <h4>Follow Us</h4>
                        <div class="social-icons">
                            <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container-fluid p-0">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224345.83923192776!2d77.06889754725782!3d28.52758200617607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x52c2b7494e204dce!2sNew%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1702700000000!5m2!1sen!2sin" 
            width="100%" 
            height="400" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>
@endsection
