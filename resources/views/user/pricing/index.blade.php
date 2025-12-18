@extends('layouts.app')

@section('title', 'Pricing | SolutionsForYou')
@section('meta_description', 'Affordable pricing plans for web development, mobile apps, and digital services.')

@push('styles')
<style>
    .payment-modal .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    .payment-modal .modal-header {
        background: linear-gradient(135deg, #FF6B6B 0%, #FFA500 100%);
        color: white;
        border: none;
        padding: 25px 30px;
    }
    .payment-modal .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }
    .payment-modal .modal-body {
        padding: 30px;
    }
    .payment-modal .plan-summary {
        background: #f8fafc;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
    }
    .payment-modal .plan-summary .plan-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
    }
    .payment-modal .plan-summary .plan-price {
        font-size: 2rem;
        font-weight: 800;
        color: #FF6B6B;
    }
    .payment-modal .form-label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }
    .payment-modal .form-control {
        border-radius: 12px;
        padding: 14px 18px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .payment-modal .form-control:focus {
        border-color: #FF6B6B;
        box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
    }
    .payment-modal .btn-pay {
        background: linear-gradient(135deg, #FF6B6B 0%, #FFA500 100%);
        border: none;
        border-radius: 14px;
        padding: 16px 30px;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
    }
    .payment-modal .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
    }
    .payment-modal .btn-pay:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .payment-modal .secure-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #64748b;
        font-size: 13px;
        margin-top: 15px;
    }
    .payment-modal .secure-badge i {
        color: #10b981;
    }
    .razorpay-logo {
        height: 25px;
        margin-left: 5px;
    }

    /* Dark Mode */
    @media (prefers-color-scheme: dark) {
        .payment-modal .modal-content {
            background: #1e293b;
        }
        .payment-modal .plan-summary {
            background: #0f172a;
        }
        .payment-modal .plan-summary .plan-name {
            color: #e2e8f0;
        }
        .payment-modal .form-label {
            color: #94a3b8;
        }
        .payment-modal .form-control {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }
        .payment-modal .form-control:focus {
            border-color: #FF6B6B;
        }
        .payment-modal .secure-badge {
            color: #94a3b8;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="pricing-hero">
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container">
        <div class="hero-content text-center" data-aos="fade-up">
            <span class="hero-badge"><i class="bi bi-tag-fill"></i> Transparent Pricing</span>
            <h1 class="hero-title">Choose Your Perfect <span>Plan</span></h1>
            <p class="hero-subtitle">Simple, transparent pricing that grows with you. No hidden fees.</p>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing-section">
    <div class="container">
        @forelse($services as $index => $service)
            @if($service->show_pricing && ($service->basic_price || $service->standard_price || $service->premium_price))
            <div class="service-pricing-wrapper" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <!-- Service Header -->
                <div class="service-header">
                    <div class="service-icon">
                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
                    </div>
                    <div class="service-info">
                        <h2 class="service-title">{{ $service->title }}</h2>
                        <p class="service-desc">{{ $service->short_description }}</p>
                    </div>
                </div>

                <!-- Pricing Cards -->
                <div class="pricing-cards-container">
                    <div class="row g-4">
                        <!-- Basic Plan -->
                        @if($service->basic_price)
                        <div class="col-lg-4 col-md-6">
                            <div class="pricing-card basic" data-aos="zoom-in" data-aos-delay="100">
                                <div class="card-ribbon">Starter</div>
                                <div class="card-header">
                                    <div class="plan-icon">
                                        <i class="bi bi-rocket"></i>
                                    </div>
                                    <h3 class="plan-name">Basic</h3>
                                    <p class="plan-tagline">Perfect for getting started</p>
                                </div>
                                <div class="card-price">
                                    <span class="currency">₹</span>
                                    <span class="amount">{{ number_format($service->basic_price, 0) }}</span>
                                    <span class="period">/project</span>
                                </div>
                                @if($service->basic_delivery)
                                <div class="delivery-badge">
                                    <i class="bi bi-clock-history"></i> {{ $service->basic_delivery }}
                                </div>
                                @endif
                                <div class="card-features">
                                    <ul>
                                        @foreach($service->basic_features_array as $feature)
                                            @if(trim($feature))
                                            <li>
                                                <i class="bi bi-check-circle-fill"></i>
                                                <span>{{ trim($feature) }}</span>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-action">
                                    <button type="button" class="btn-plan btn-basic" 
                                        onclick="openPaymentModal({{ $service->id }}, '{{ $service->title }}', 'basic', {{ $service->basic_price }})">
                                        <span>Buy Now</span>
                                        <i class="bi bi-credit-card"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Standard Plan -->
                        @if($service->standard_price)
                        <div class="col-lg-4 col-md-6">
                            <div class="pricing-card standard popular" data-aos="zoom-in" data-aos-delay="200">
                                <div class="popular-badge">
                                    <i class="bi bi-star-fill"></i> Most Popular
                                </div>
                                <div class="card-header">
                                    <div class="plan-icon">
                                        <i class="bi bi-lightning-charge-fill"></i>
                                    </div>
                                    <h3 class="plan-name">Standard</h3>
                                    <p class="plan-tagline">Best value for money</p>
                                </div>
                                <div class="card-price">
                                    <span class="currency">₹</span>
                                    <span class="amount">{{ number_format($service->standard_price, 0) }}</span>
                                    <span class="period">/project</span>
                                </div>
                                @if($service->standard_delivery)
                                <div class="delivery-badge">
                                    <i class="bi bi-clock-history"></i> {{ $service->standard_delivery }}
                                </div>
                                @endif
                                <div class="card-features">
                                    <ul>
                                        @foreach($service->standard_features_array as $feature)
                                            @if(trim($feature))
                                            <li>
                                                <i class="bi bi-check-circle-fill"></i>
                                                <span>{{ trim($feature) }}</span>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-action">
                                    <button type="button" class="btn-plan btn-standard" 
                                        onclick="openPaymentModal({{ $service->id }}, '{{ $service->title }}', 'standard', {{ $service->standard_price }})">
                                        <span>Buy Now</span>
                                        <i class="bi bi-credit-card"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Premium Plan -->
                        @if($service->premium_price)
                        <div class="col-lg-4 col-md-6">
                            <div class="pricing-card premium" data-aos="zoom-in" data-aos-delay="300">
                                <div class="card-ribbon premium-ribbon">Pro</div>
                                <div class="card-header">
                                    <div class="plan-icon">
                                        <i class="bi bi-gem"></i>
                                    </div>
                                    <h3 class="plan-name">Premium</h3>
                                    <p class="plan-tagline">For serious businesses</p>
                                </div>
                                <div class="card-price">
                                    <span class="currency">₹</span>
                                    <span class="amount">{{ number_format($service->premium_price, 0) }}</span>
                                    <span class="period">/project</span>
                                </div>
                                @if($service->premium_delivery)
                                <div class="delivery-badge">
                                    <i class="bi bi-clock-history"></i> {{ $service->premium_delivery }}
                                </div>
                                @endif
                                <div class="card-features">
                                    <ul>
                                        @foreach($service->premium_features_array as $feature)
                                            @if(trim($feature))
                                            <li>
                                                <i class="bi bi-check-circle-fill"></i>
                                                <span>{{ trim($feature) }}</span>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-action">
                                    <button type="button" class="btn-plan btn-premium" 
                                        onclick="openPaymentModal({{ $service->id }}, '{{ $service->title }}', 'premium', {{ $service->premium_price }})">
                                        <span>Buy Now</span>
                                        <i class="bi bi-credit-card"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @empty
            <div class="empty-pricing" data-aos="fade-up">
                <div class="empty-icon">
                    <i class="bi bi-tags"></i>
                </div>
                <h3>Pricing Coming Soon</h3>
                <p>We're working on our pricing plans. Contact us for a custom quote.</p>
                <a href="{{ url('/#contact') }}" class="btn-contact">
                    <i class="bi bi-envelope"></i> Contact Us
                </a>
            </div>
        @endforelse
    </div>
</section>

<!-- Features Section -->
<section class="why-choose-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Why Choose Us</span>
            <h2>What's Included in Every Plan</h2>
        </div>
        <div class="row g-4 mt-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>Quality Guarantee</h4>
                    <p>100% satisfaction or we'll revise until you're happy</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>24/7 Support</h4>
                    <p>Round the clock support for all your queries</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h4>Free Revisions</h4>
                    <p>Multiple revision rounds included in every plan</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-file-earmark-code"></i>
                    </div>
                    <h4>Source Files</h4>
                    <p>Get complete source code and assets</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="pricing-cta">
    <div class="cta-bg-shapes">
        <div class="cta-shape cta-shape-1"></div>
        <div class="cta-shape cta-shape-2"></div>
    </div>
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <div class="cta-icon">
                <i class="bi bi-chat-dots-fill"></i>
            </div>
            <h2>Need a Custom Solution?</h2>
            <p>Can't find what you're looking for? Let's discuss your specific requirements.</p>
            <div class="cta-buttons">
                <a href="{{ url('/#contact') }}" class="btn-cta-primary">
                    <i class="bi bi-envelope-fill"></i> Get Custom Quote
                </a>
                <a href="https://wa.me/919876543210" class="btn-cta-secondary" target="_blank">
                    <i class="bi bi-whatsapp"></i> WhatsApp Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">FAQ</span>
            <h2>Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                <div class="accordion" id="pricingFaq">
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-question-circle"></i> What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#pricingFaq">
                            <div class="accordion-body">
                                We accept UPI, Bank Transfer, PayPal, and all major credit/debit cards. 50% advance payment is required to start the project.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="bi bi-question-circle"></i> Do you offer refunds?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body">
                                Yes, we offer a full refund if you're not satisfied with the initial design concept. Once development begins, partial refunds are available based on work completed.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="bi bi-question-circle"></i> How long does a typical project take?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body">
                                Project timelines vary based on complexity. Basic projects take 3-5 days, Standard 5-10 days, and Premium projects 10-15 days. We'll provide exact timelines after understanding your requirements.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment Modal -->
<div class="modal fade payment-modal" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1">Complete Your Purchase</h5>
                    <p class="mb-0 opacity-75" style="font-size: 14px;">Secure payment powered by Razorpay</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Plan Summary -->
                <div class="plan-summary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted" style="font-size: 13px;">Selected Plan</p>
                            <h4 class="plan-name mb-0" id="modalPlanName">-</h4>
                        </div>
                        <div class="text-end">
                            <p class="mb-1 text-muted" style="font-size: 13px;">Amount</p>
                            <p class="plan-price mb-0">₹<span id="modalPlanPrice">0</span></p>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form id="paymentForm">
                    <input type="hidden" id="serviceId" name="service_id">
                    <input type="hidden" id="planType" name="plan_type">
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person me-2"></i>Full Name</label>
                        <input type="text" class="form-control" id="customerName" name="name" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-envelope me-2"></i>Email Address</label>
                        <input type="email" class="form-control" id="customerEmail" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-phone me-2"></i>Phone Number</label>
                        <input type="tel" class="form-control" id="customerPhone" name="phone" placeholder="Enter your phone number">
                    </div>
                    
                    <button type="submit" class="btn btn-pay text-white" id="payBtn">
                        <i class="bi bi-shield-lock"></i>
                        <span>Pay Securely</span>
                    </button>
                    
                    <div class="secure-badge">
                        <i class="bi bi-shield-check"></i>
                        <span>256-bit SSL Encrypted | Powered by</span>
                        <img src="https://razorpay.com/assets/razorpay-logo.svg" alt="Razorpay" class="razorpay-logo">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    let paymentModal;
    
    document.addEventListener('DOMContentLoaded', function() {
        paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    });

    function openPaymentModal(serviceId, serviceName, planType, price) {
        document.getElementById('serviceId').value = serviceId;
        document.getElementById('planType').value = planType;
        document.getElementById('modalPlanName').textContent = serviceName + ' - ' + planType.charAt(0).toUpperCase() + planType.slice(1);
        document.getElementById('modalPlanPrice').textContent = new Intl.NumberFormat('en-IN').format(price);
        paymentModal.show();
    }

    document.getElementById('paymentForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const payBtn = document.getElementById('payBtn');
        const originalText = payBtn.innerHTML;
        payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
        payBtn.disabled = true;

        try {
            // Create order
            const response = await fetch('{{ route("payment.create") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    service_id: document.getElementById('serviceId').value,
                    plan_type: document.getElementById('planType').value,
                    name: document.getElementById('customerName').value,
                    email: document.getElementById('customerEmail').value,
                    phone: document.getElementById('customerPhone').value
                })
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.error || 'Failed to create order');
            }

            // Close modal
            paymentModal.hide();

            // Open Razorpay checkout
            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency,
                name: data.name,
                description: data.description,
                order_id: data.order_id,
                prefill: data.prefill,
                theme: {
                    color: '#FF6B6B'
                },
                handler: async function(response) {
                    // Verify payment
                    const verifyResponse = await fetch('{{ route("payment.verify") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature
                        })
                    });

                    const verifyData = await verifyResponse.json();

                    if (verifyData.success) {
                        window.location.href = '{{ route("payment.success") }}?order_id=' + verifyData.payment_id;
                    } else {
                        alert('Payment verification failed. Please contact support.');
                    }
                },
                modal: {
                    ondismiss: function() {
                        payBtn.innerHTML = originalText;
                        payBtn.disabled = false;
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();

        } catch (error) {
            alert(error.message || 'Something went wrong. Please try again.');
            payBtn.innerHTML = originalText;
            payBtn.disabled = false;
        }
    });
</script>
@endpush
