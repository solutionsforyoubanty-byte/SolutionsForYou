@extends('layouts.app')

@section('title', $service->title . ' | SolutionsForYou')
@section('meta_description', $service->short_description)
@section('meta_keywords', $service->title . ', SolutionsForYou, web development')

@section('og_title', $service->title . ' - SolutionsForYou')
@section('og_description', $service->short_description)
@section('og_image', asset('uploads/services/' . $service->image))

{{-- JSON-LD --}}
@section('json_ld')
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "{{ $service->title }}",
  "description": "{{ $service->short_description }}",
  "provider": {
    "@type": "Organization",
    "name": "SolutionsForYou",
    "url": "{{ url('/') }}"
  },
  "url": "{{ url('service/' . $service->slug) }}"
}
</script>
@endsection

@section('content')
    <!-- SERVICE HERO SECTION -->
    <section class="service-hero">
        <div class="container">
            <div class="service-hero-content text-center">
                <h1 class="service-main-title">
                    {{ $service->title }} <span>Service</span>
                </h1>
                <p class="service-subtitle">
                    {{ $service->short_description }}
                </p>

                <!-- Breadcrumb Navigation -->
                <nav aria-label="breadcrumb" class="mt-4">
                    <ol class="breadcrumb justify-content-center bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/services') }}" class="text-white">Services</a></li>
                        <li class="breadcrumb-item active text-warning" aria-current="page">{{ $service->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- SERVICE HERO SECTION -->
    <section class="service-hero-section py-5" data-aos="fade-up">
        <div class="container-fluid px-3 px-md-4">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-6 order-2 order-lg-1">
                    <div class="service-hero-content">
                        <h1 class="service-title">{{ $service->title }}</h1>
                        <p class="service-subtitle">{{ $service->short_description }}</p>

                        <div class="service-meta d-flex flex-wrap gap-2 gap-md-3 mb-4">
                            <span class="badge bg-primary">Professional Service</span>
                            <span class="badge bg-success">Fast Delivery</span>
                            <span class="badge bg-info">24/7 Support</span>
                        </div>

                        <div class="service-actions d-flex flex-column flex-sm-row gap-3">
                            <button type="button" class="btn btn-primary btn-lg get-quote-btn" data-bs-toggle="modal"
                                data-bs-target="#serviceModal" data-service-id="{{ $service->id }}">
                                <i class="bi bi-envelope-fill"></i> Get Quote
                            </button>

                            <a href="#service-details" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-info-circle"></i> Learn More
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 order-1 order-lg-2">
                    <div class="service-hero-image" data-aos="zoom-in">
                        <img src="{{ asset('uploads/services/' . $service->image) }}" alt="{{ $service->title }}"
                            class="img-fluid rounded shadow w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICE CONTENT SECTION -->
    <section class="service-content-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-lg-8 order-2 order-lg-1">
                    <!-- Service Image -->
                    <div class="service-image-container" data-aos="fade-up">
                        <img src="{{ asset('uploads/services/' . $service->image) }}" alt="{{ $service->title }}"
                            class="img-fluid">
                    </div>

                    <!-- Service Badges -->
                    <div class="service-badges" data-aos="fade-up">
                        <span class="badge">Professional Service</span>
                        <span class="badge badge-success">Fast Delivery</span>
                        <span class="badge badge-info">24/7 Support</span>
                    </div>

                    <!-- Service Actions -->
                    <div class="service-actions" data-aos="fade-up">
                        <button type="button" class="btn btn-primary get-quote-btn" data-bs-toggle="modal"
                            data-bs-target="#serviceModal" data-service-id="{{ $service->id }}">
                            <i class="bi bi-envelope-fill"></i> Get Quote
                        </button>
                        <a href="#service-details" class="btn btn-outline-primary">
                            <i class="bi bi-info-circle"></i> Learn More
                        </a>
                    </div>
                    <!-- SERVICE DETAILS SECTION -->
                    <section id="service-details" class="service-details-section">
                        <div class="container">
                            <h2 class="section-title" data-aos="fade-up">About This Service</h2>

                            <div class="service-description" data-aos="fade-up">
                                {!! $service->description !!}
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar -->
                <div class="col-12 col-lg-4 order-1 order-lg-2">
                    <div class="service-sidebar">
                        <!-- Contact Card -->
                        <div class="contact-card" data-aos="fade-left">
                            <h4>Ready to Get Started?</h4>
                            <p>Contact us today for a free consultation and quote.</p>

                            <div class="contact-info">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope-fill"></i>
                                    <span>info@solutionsforyou.com</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-telephone-fill"></i>
                                    <span>+91 9876543210</span>
                                </div>
                            </div>

                            <button type="button" class="btn w-100 get-quote-btn" data-bs-toggle="modal"
                                data-bs-target="#serviceModal" data-service-id="{{ $service->id }}">
                                <i class="bi bi-chat-dots-fill"></i> Start Discussion
                            </button>
                        </div>

                        <!-- Related Services -->
                        @if ($relatedServices && $relatedServices->count() > 0)
                            <div class="related-services">
                                <h4>Related Services</h4>
                                @foreach ($relatedServices as $related)
                                    <div class="related-service-item">
                                        <a href="{{ url('service/' . $related->slug) }}"
                                            class="d-flex text-decoration-none">
                                            <img src="{{ asset('uploads/services/' . $related->image) }}"
                                                alt="{{ $related->title }}" class="related-service-img me-3 flex-shrink-0">
                                            <div class="flex-grow-1">
                                                <h6>{{ $related->title }}</h6>
                                                <p>{{ Str::limit($related->short_description, 60) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- SERVICE FEATURES SECTION -->
    <section class="service-features">
        <div class="container">
            <h3 data-aos="fade-up">What You Get</h3>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <h5>Professional Quality</h5>
                        <p>High-quality work that meets industry standards</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="feature-item">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <h5>Fast Delivery</h5>
                        <p>Quick turnaround time without compromising quality</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="feature-item">
                        <i class="bi bi-shield-lock-fill"></i>
                        <h5>Secure & Reliable</h5>
                        <p>Built with security and reliability in mind</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="feature-item">
                        <i class="bi bi-headset"></i>
                        <h5>Ongoing Support</h5>
                        <p>Continuous support and maintenance available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICE PROCESS SECTION -->
    <section class="service-process">
        <div class="container">
            <h3 data-aos="fade-up">Our Process</h3>

            <div class="row g-4">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h5>Consultation</h5>
                        <p>We discuss your requirements and goals</p>
                    </div>
                </div>

                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h5>Planning</h5>
                        <p>Create a detailed project plan and timeline</p>
                    </div>
                </div>

                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h5>Development</h5>
                        <p>Build your solution with regular updates</p>
                    </div>
                </div>

                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h5>Delivery</h5>
                        <p>Launch and provide ongoing support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="service-cta-section" data-aos="zoom-in">
        <div class="cta-overlay"></div>
        <div class="container cta-content">
            <h2>Ready to Transform Your Business?</h2>
            <p>Let's discuss how our {{ $service->title }} can help you achieve your goals.</p>

            <div class="cta-buttons">
                <button type="button" class="btn btn-primary get-quote-btn" data-bs-toggle="modal"
                    data-bs-target="#serviceModal" data-service-id="{{ $service->id }}">
                    <i class="bi bi-rocket-takeoff"></i> Start Your Project
                </button>
                <a href="{{ url('/') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>
    </section>

    <!-- SERVICE MODAL -->
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
                                html =
                                    '<p class="text-muted">No specific questions for this service.</p>';
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
