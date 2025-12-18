@extends('layouts.app')

@section('title', 'Payment Successful | SolutionsForYou')

@section('content')
<section class="payment-success-page">
    <!-- Background Elements -->
    <div class="success-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="confetti-container" id="confetti"></div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="success-card" data-aos="zoom-in">
                    <!-- Success Animation -->
                    <div class="success-animation">
                        <div class="success-circle">
                            <div class="success-circle-inner">
                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Success Content -->
                    <div class="success-content">
                        <span class="success-badge">
                            <i class="bi bi-patch-check-fill"></i> Payment Verified
                        </span>
                        <h1 class="success-title">Thank You!</h1>
                        <p class="success-subtitle">Your payment has been processed successfully</p>
                    </div>

                    <!-- Order Summary Card -->
                    <div class="order-summary-card">
                        <div class="order-header">
                            <div class="order-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>
                                <h4>Order Summary</h4>
                                <p class="order-id">{{ $payment->order_id }}</p>
                            </div>
                        </div>

                        <div class="order-details">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="detail-info">
                                    <span class="detail-label">Service</span>
                                    <span class="detail-value">{{ $payment->service->title }}</span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-layers"></i>
                                </div>
                                <div class="detail-info">
                                    <span class="detail-label">Plan</span>
                                    <span class="detail-value">
                                        <span class="plan-badge plan-{{ $payment->plan_type }}">{{ ucfirst($payment->plan_type) }}</span>
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-credit-card-2-front"></i>
                                </div>
                                <div class="detail-info">
                                    <span class="detail-label">Payment ID</span>
                                    <span class="detail-value payment-id">{{ $payment->razorpay_payment_id }}</span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="detail-info">
                                    <span class="detail-label">Date</span>
                                    <span class="detail-value">{{ $payment->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="order-total">
                            <div class="total-label">
                                <i class="bi bi-wallet2"></i>
                                <span>Amount Paid</span>
                            </div>
                            <div class="total-amount">₹{{ number_format($payment->amount, 0) }}</div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="customer-info-card">
                        <div class="customer-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="customer-details">
                            <h5>{{ $payment->customer_name }}</h5>
                            <p><i class="bi bi-envelope"></i> {{ $payment->customer_email }}</p>
                            @if($payment->customer_phone)
                            <p><i class="bi bi-phone"></i> {{ $payment->customer_phone }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="next-steps">
                        <h5><i class="bi bi-signpost-split"></i> What's Next?</h5>
                        <div class="steps-timeline">
                            <div class="step-item completed">
                                <div class="step-marker"><i class="bi bi-check"></i></div>
                                <div class="step-content">
                                    <span class="step-title">Payment Received</span>
                                    <span class="step-desc">Your payment is confirmed</span>
                                </div>
                            </div>
                            <div class="step-item active">
                                <div class="step-marker">2</div>
                                <div class="step-content">
                                    <span class="step-title">Confirmation Email</span>
                                    <span class="step-desc">Check your inbox for details</span>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-marker">3</div>
                                <div class="step-content">
                                    <span class="step-title">Project Kickoff</span>
                                    <span class="step-desc">We'll contact you within 24 hours</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('home') }}" class="btn-action btn-primary-action">
                            <i class="bi bi-house"></i>
                            <span>Back to Home</span>
                        </a>
                        <a href="{{ url('/#contact') }}" class="btn-action btn-secondary-action">
                            <i class="bi bi-chat-dots"></i>
                            <span>Contact Us</span>
                        </a>
                    </div>

                    <!-- Support Note -->
                    <div class="support-note">
                        <i class="bi bi-headset"></i>
                        <p>Need help? Contact us at <a href="mailto:support@solutionsforyou.com">support@solutionsforyou.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
@vite('resources/css/payment-success.scss')
@endpush

@push('scripts')
<script>
// Confetti Animation
function createConfetti() {
    const container = document.getElementById('confetti');
    const colors = ['#FF6B6B', '#FFA500', '#10b981', '#3b82f6', '#f59e0b', '#ec4899'];
    
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti-piece';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 2 + 's';
            confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
            container.appendChild(confetti);
            
            setTimeout(() => confetti.remove(), 4000);
        }, i * 50);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    createConfetti();
});
</script>
@endpush
