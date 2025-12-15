<!-- Service Inquiry Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">
                    <i class="bi bi-chat-square-text me-2"></i>Service Inquiry
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="service_id">

                <!-- STEP 1: Dynamic Questions -->
                <div id="step1">
                    <div id="dynamicQuestions">
                        <p class="text-center">Loading questions...</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 w-100" id="nextBtn" disabled>
                        Next <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>

                <!-- STEP 2: Contact Information -->
                <div id="step2" class="d-none">
                    <h6><i class="bi bi-person-lines-fill me-2"></i>Your Contact Information</h6>
                    
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person me-1"></i>Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               class="form-control" 
                               placeholder="Enter your full name" 
                               autocomplete="name"
                               required>
                        <div class="invalid-feedback">Please enter your name</div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1"></i>Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               class="form-control" 
                               placeholder="example@email.com" 
                               autocomplete="email"
                               required>
                        <div class="invalid-feedback">Please enter a valid email</div>
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            <i class="bi bi-telephone me-1"></i>Phone Number
                        </label>
                        <input type="tel" 
                               id="phone" 
                               class="form-control" 
                               placeholder="Enter 10-digit phone number" 
                               maxlength="10"
                               pattern="[0-9]{10}"
                               autocomplete="tel">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>Optional - For faster communication
                        </small>
                    </div>

                    <!-- Timeline Field -->
                    <div class="mb-3">
                        <label for="timeline" class="form-label">
                            <i class="bi bi-calendar-event me-1"></i>Project Timeline
                        </label>
                        <select id="timeline" class="form-select">
                            <option value="">Select timeline</option>
                            <option value="urgent">Urgent (Within 1 week)</option>
                            <option value="1-2 weeks">1-2 Weeks</option>
                            <option value="2-4 weeks">2-4 Weeks</option>
                            <option value="1-2 months">1-2 Months</option>
                            <option value="flexible">Flexible / Not Sure</option>
                        </select>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>When do you need this completed?
                        </small>
                    </div>

                    <!-- Message Field -->
                    <div class="mb-3">
                        <label for="message" class="form-label">
                            <i class="bi bi-chat-left-text me-1"></i>Additional Message
                        </label>
                        <textarea id="message" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Any additional details or requirements..."></textarea>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>Optional - Share more about your project
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" id="backBtn">
                            <i class="bi bi-arrow-left"></i> Back
                        </button>
                        <button type="button" id="submitInquiry" class="btn btn-success flex-grow-1">
                            <i class="bi bi-send-fill"></i> Submit Inquiry
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const backBtn = document.getElementById('backBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (backBtn) {
        backBtn.addEventListener('click', function() {
            document.getElementById('step2').classList.add('d-none');
            document.getElementById('step1').classList.remove('d-none');
        });
    }

    // Questions validation - Enable/Disable Next button
    function validateQuestions() {
        const questionsContainer = document.getElementById('dynamicQuestions');
        const inputs = questionsContainer.querySelectorAll('input, select, textarea');
        let allFilled = true;

        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value.trim()) {
                allFilled = false;
            }
        });

        if (nextBtn) {
            nextBtn.disabled = !allFilled;
            if (allFilled) {
                nextBtn.classList.remove('btn-disabled');
            } else {
                nextBtn.classList.add('btn-disabled');
            }
        }
    }

    // Watch for dynamic questions being loaded
    const observer = new MutationObserver(function() {
        const questionsContainer = document.getElementById('dynamicQuestions');
        const inputs = questionsContainer.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.removeEventListener('input', validateQuestions);
            input.removeEventListener('change', validateQuestions);
            input.addEventListener('input', validateQuestions);
            input.addEventListener('change', validateQuestions);

            // Add validation styling on blur
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });

        // Initial check
        validateQuestions();
    });

    observer.observe(document.getElementById('dynamicQuestions'), {
        childList: true,
        subtree: true
    });

    // Step 2 validation
    const requiredInputs = document.querySelectorAll('#step2 input[required]');
    requiredInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(this);
        });

        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });

    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (this.value) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }

    // Phone number - only digits
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length === 10) {
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });
    }

    function validateInput(input) {
        if (input.required && !input.value.trim()) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            return false;
        } else if (input.value.trim()) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            return true;
        }
        return true;
    }
});
</script>
