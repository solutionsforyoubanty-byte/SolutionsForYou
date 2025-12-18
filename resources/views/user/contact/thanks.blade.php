@extends('layouts.app')

@section('title', 'Thank You | SolutionsForYou')

@push('styles')
@vite('resources/css/contact.scss')
@endpush

@section('content')
<section class="thanks-page">
    <!-- Background Shapes -->
    <div class="thanks-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <!-- Confetti Container -->
    <div class="confetti-container" id="confetti"></div>

    <div class="container">
        <div class="thanks-card" data-aos="zoom-in">
            <!-- Animated Success Icon -->
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

            <!-- Content -->
            <div class="thanks-content">
                <span class="thanks-badge">
                    <i class="bi bi-envelope-check"></i> Message Sent
                </span>
                <h1>Thank You!</h1>
                <p class="thanks-message">Your message has been sent successfully. We appreciate you reaching out to us.</p>
            </div>

            <!-- What's Next -->
            <div class="whats-next">
                <h4><i class="bi bi-clock-history"></i> What happens next?</h4>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon completed">
                            <i class="bi bi-check"></i>
                        </div>
                        <div class="timeline-content">
                            <span class="timeline-title">Message Received</span>
                            <span class="timeline-desc">We got your message</span>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon active">
                            <span>2</span>
                        </div>
                        <div class="timeline-content">
                            <span class="timeline-title">Under Review</span>
                            <span class="timeline-desc">Our team is reviewing</span>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <span>3</span>
                        </div>
                        <div class="timeline-content">
                            <span class="timeline-title">We'll Respond</span>
                            <span class="timeline-desc">Within 24 hours</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="thanks-actions">
                <a href="{{ route('home') }}" class="btn-primary-action">
                    <i class="bi bi-house"></i>
                    <span>Back to Home</span>
                </a>
                <a href="{{ route('user.services.index') }}" class="btn-secondary-action">
                    <i class="bi bi-grid"></i>
                    <span>Explore Services</span>
                </a>
            </div>

            <!-- Contact Info -->
            <div class="quick-contact">
                <p>Need immediate assistance?</p>
                <div class="contact-options">
                    <a href="tel:+919876543210" class="contact-option">
                        <i class="bi bi-telephone"></i>
                        <span>Call Us</span>
                    </a>
                    <a href="https://wa.me/919876543210" class="contact-option" target="_blank">
                        <i class="bi bi-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="mailto:hello@solutionsforyou.com" class="contact-option">
                        <i class="bi bi-envelope"></i>
                        <span>Email</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

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
