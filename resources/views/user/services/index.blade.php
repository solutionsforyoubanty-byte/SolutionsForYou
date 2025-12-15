@extends('layouts.app')

@section('title', 'Our Services | SolutionsForYou')
@section('meta_description',
    'Explore our comprehensive web development services - Laravel, PHP, React, SEO, and more
    professional solutions.')
@section('meta_keywords',
    'web development services, Laravel development, PHP services, React development, SEO
    services')

@section('og_title', 'Professional Web Development Services - SolutionsForYou')
@section('og_description', 'Discover our range of professional web development and digital services.')
@section('og_image', asset('images/services-og.jpg'))

{{-- JSON-LD --}}
@section('json_ld')
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "SolutionsForYou Services",
  "description": "Professional web development and digital services",
  "url": "{{ url('/services') }}",
  "provider": {
    "@type": "Organization",
    "name": "SolutionsForYou",
    "url": "{{ url('/') }}"
  }
}
</script>
@endsection

@section('content')

    <!-- SERVICES SEARCH HERO SECTION -->
    <section class="service-hero">
        <div class="container">
            <div class="service-hero-content text-center">
                <h1 class="service-main-title">
                    Find the Best <span>Web Services</span> For Your Business
                </h1>
                <p class="service-subtitle">
                    Search any service you need — Web Development, SEO, Branding, LMS, CRM & more.
                </p>

                <!-- Search Input -->
                <div class="service-search-box mt-4 position-relative" style="max-width: 500px; margin: 0 auto;">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="serviceSearch" class="form-control" placeholder="Search service...">
                    </div>

                    <ul class="list-group suggestion-box" id="searchResults" style="display:none;">
                    </ul>
                </div>

                <!-- Service Stats -->
                <div class="service-stats mt-5">
                    <div class="row g-4">
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <h3>{{ $services->total() }}+</h3>
                                <p>Services</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <h3>100+</h3>
                                <p>Happy Clients</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <h3>3+</h3>
                                <p>Years Experience</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <h3>24/7</h3>
                                <p>Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES GRID SECTION -->
    <section class="services-grid-section py-5">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Our Professional Services</h2>
                <p class="section-subtitle">Choose from our wide range of professional web development and digital services
                </p>
                <div class="title-divider"></div>
            </div>

            <!-- Services Filter -->
            <div class="services-filter text-center mb-5" data-aos="fade-up">
                <button class="filter-btn active" data-filter="all">All Services</button>
                <button class="filter-btn" data-filter="development">Development</button>
                <button class="filter-btn" data-filter="design">Design</button>
                <button class="filter-btn" data-filter="marketing">Marketing</button>
                <button class="filter-btn" data-filter="other">Other</button>
            </div>

            <!-- Services Grid -->
            <div class="services-grid">
                <div class="row g-4">
                    @forelse($services as $service)
                        <div class="col-12 col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="service-card" data-category="development">
                                <div class="service-card-header">
                                    <div class="service-image">
                                        <img src="{{ asset('uploads/services/' . $service->image) }}"
                                            alt="{{ $service->title }}" class="img-fluid">
                                        <div class="service-overlay">
                                            <a href="{{ route('user.service.show', $service->slug) }}"
                                                class="btn btn-primary">
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="service-badge">
                                        <i class="bi bi-star-fill"></i>
                                        <span>Popular</span>
                                    </div>
                                </div>

                                <div class="service-card-body">
                                    <h4 class="service-title">
                                        <a href="{{ route('user.service.show', $service->slug) }}">{{ $service->title }}</a>
                                    </h4>
                                    <p class="service-description">{{ Str::limit($service->short_description, 100) }}</p>

                                    <div class="service-features">
                                        <span class="feature-tag"><i class="bi bi-check-circle"></i> Professional</span>
                                        <span class="feature-tag"><i class="bi bi-lightning"></i> Fast</span>
                                        <span class="feature-tag"><i class="bi bi-shield-check"></i> Secure</span>
                                    </div>
                                </div>

                                <div class="service-card-footer">
                                    <div class="service-actions">
                                        <a href="{{ route('user.service.show', $service->slug) }}"
                                            class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i> View Details
                                        </a>
                                        <button type="button" class="btn btn-primary get-quote-btn" data-bs-toggle="modal"
                                            data-bs-target="#serviceModal" data-service-id="{{ $service->id }}">
                                            <i class="bi bi-envelope-fill"></i> Get Quote
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="no-services text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <h3 class="mt-3">No Services Found</h3>
                                <p class="text-muted">We're working on adding more services. Please check back later.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if ($services->hasPages())
                <div class="services-pagination mt-5" data-aos="fade-up">
                    <div class="d-flex justify-content-center">
                        {{ $services->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- CALL TO ACTION SECTION -->
    <section class="services-cta-section" data-aos="zoom-in">
        <div class="cta-overlay"></div>
        <div class="container text-center cta-content">
            <h2 class="cta-title">Need a Custom Solution?</h2>
            <p class="cta-subtitle">Can't find what you're looking for? Let's discuss your custom requirements.</p>

            <div class="cta-actions">
                <a href="#contact" class="btn btn-light btn-lg me-3">
                    <i class="bi bi-chat-dots"></i> Let's Talk
                </a>
                <a href="{{ url('/') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-house"></i> Back to Home
                </a>
            </div>
        </div>
    </section>

    @include('components.modal')



@endsection

@push('scripts')
    <!-- Make sure jQuery is loaded in your layout -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentServiceId = null;

            // Handle modal open - Load questions
            document.querySelectorAll('.get-quote-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentServiceId = this.getAttribute('data-service-id');
                    document.getElementById('service_id').value = currentServiceId;

                    // Reset steps
                    document.getElementById('step1').classList.remove('d-none');
                    document.getElementById('step2').classList.add('d-none');

                    // Clear previous data
                    document.getElementById('dynamicQuestions').innerHTML =
                        '<p class="text-center">Loading questions...</p>';

                    // Fetch questions
                    fetch(`/get-service-questions?service_id=${currentServiceId}`)
                        .then(res => {
                            if (!res.ok) throw new Error('Failed to load questions');
                            return res.json();
                        })
                        .then(data => {
                            let html = '';
                            const nextBtn = document.getElementById('nextBtn');
                            
                            if (data.length === 0) {
                                html = '<p class="text-muted">No specific questions for this service.</p>';
                                // Enable next button if no questions
                                if (nextBtn) nextBtn.disabled = false;
                            } else {
                                data.forEach((q, index) => {
                                    html += `
                                <div class="mb-3">
                                    <label class="form-label fw-bold">${q.question} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="question_${index + 1}" 
                                           id="question_${index + 1}"
                                           class="form-control question-input" 
                                           placeholder="Your answer..."
                                           required />
                                    <div class="invalid-feedback">Please answer this question</div>
                                </div>
                            `;
                                });
                                // Disable next button until questions are filled
                                if (nextBtn) nextBtn.disabled = true;
                            }
                            document.getElementById('dynamicQuestions').innerHTML = html;
                            
                            // Attach validation listeners to new inputs
                            attachQuestionValidation();
                        })
                        .catch(err => {
                            console.error('Error loading questions:', err);
                            document.getElementById('dynamicQuestions').innerHTML =
                                '<p class="text-danger">Failed to load questions. Please try again.</p>';
                        });
                });
            });

            

            // Question validation function
            function attachQuestionValidation() {
                const questionInputs = document.querySelectorAll('.question-input');
                const nextBtn = document.getElementById('nextBtn');

                function validateAllQuestions() {
                    let allFilled = true;
                    questionInputs.forEach(input => {
                        if (!input.value.trim()) {
                            allFilled = false;
                        }
                    });
                    if (nextBtn) {
                        nextBtn.disabled = !allFilled;
                    }
                }

                questionInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        this.classList.remove('is-invalid');
                        validateAllQuestions();
                    });

                    input.addEventListener('blur', function() {
                        if (!this.value.trim()) {
                            this.classList.add('is-invalid');
                            this.classList.remove('is-valid');
                        } else {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        }
                    });
                });

                // Initial validation check
                validateAllQuestions();
            }

            // Next button - Go to Step 2
            document.getElementById('nextBtn').addEventListener('click', function() {
                // Final validation before moving to step 2
                const questionInputs = document.querySelectorAll('.question-input');
                let allValid = true;

                questionInputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        allValid = false;
                    }
                });

                if (allValid) {
                    document.getElementById('step1').classList.add('d-none');
                    document.getElementById('step2').classList.remove('d-none');
                }
            });

            // Submit inquiry
            document.getElementById('submitInquiry').addEventListener('click', function() {
                const serviceId = document.getElementById('service_id').value;
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();

                // Get question answers
                const question1 = document.getElementById('question_1')?.value || '';
                const question2 = document.getElementById('question_2')?.value || '';
                const question3 = document.getElementById('question_3')?.value || '';

                // Client-side validation
                if (!name) {
                    showToast('Name is required', 'error');
                    return;
                }

                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showToast('Enter a valid email', 'error');
                    return;
                }

                if (phone && !/^[0-9]{10}$/.test(phone)) {
                    showToast('Enter a valid 10-digit phone', 'error');
                    return;
                }

                // Disable button during submission
                this.disabled = true;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                'content');

                // AJAX submit
                fetch('/save-inquiry', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            service_id: serviceId,
                            question_1: question1,
                            question_2: question2,
                            question_3: question3,
                            name: name,
                            email: email,
                            phone: phone
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Inquiry Submitted Successfully!', 'success');

                            // Reset form
                            document.getElementById('step1').classList.remove('d-none');
                            document.getElementById('step2').classList.add('d-none');
                            document.querySelectorAll('#dynamicQuestions input, #name, #email, #phone')
                                .forEach(input => {
                                    input.value = '';
                                });

                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'serviceModal'));
                            if (modal) {
                                modal.hide();
                            }
                        } else {
                            showToast(data.message || 'Something went wrong!', 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Submission error:', err);
                        showToast('Network error. Please try again.', 'error');
                    })
                    .finally(() => {
                        // Re-enable button
                        document.getElementById('submitInquiry').disabled = false;
                        document.getElementById('submitInquiry').innerHTML = 'Submit Inquiry';
                    });
            });

            // Toast notification function
            function showToast(message, type = 'info') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: type === 'error' ? 'error' : 'success',
                        title: message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    alert(message);
                }
            }
        });
    </script>
@endpush
