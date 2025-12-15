import './bootstrap';
import * as bootstrap from 'bootstrap';

// ===== THEME MANAGEMENT =====
class ThemeManager {
    constructor() {
        this.themeToggle = document.getElementById('themeToggle');
        this.themeIcon = document.getElementById('themeIcon');
        this.init();
    }

    init() {
        // Check saved theme or system preference
        const savedTheme = localStorage.getItem("theme");
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === "dark" || (!savedTheme && systemDark)) {
            this.setDarkMode(true);
        }

        // Event listeners
        this.themeToggle?.addEventListener("click", () => this.toggleTheme());
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem("theme")) {
                this.setDarkMode(e.matches);
            }
        });
    }

    toggleTheme() {
        const isDark = document.body.classList.contains("dark-mode");
        this.setDarkMode(!isDark);
        localStorage.setItem("theme", !isDark ? "dark" : "light");
    }

    setDarkMode(isDark) {
        if (isDark) {
            document.body.classList.add("dark-mode");
            this.themeIcon?.classList.remove("bi-moon-stars-fill");
            this.themeIcon?.classList.add("bi-sun-fill");
        } else {
            document.body.classList.remove("dark-mode");
            this.themeIcon?.classList.remove("bi-sun-fill");
            this.themeIcon?.classList.add("bi-moon-stars-fill");
        }
    }
}

// Initialize theme manager
new ThemeManager();


// ===== NAVIGATION MANAGEMENT =====
class NavigationManager {
    constructor() {
        this.menuToggle = document.querySelector("#menuToggle");
        this.menuClose = document.querySelector("#menuClose");
        this.fullMenu = document.querySelector("#fullMenu");
        this.header = document.getElementById("header");
        this.backToTop = document.getElementById("backToTop");
        this.init();
    }

    init() {
        // Menu toggle events
        this.menuToggle?.addEventListener("click", () => this.openMenu());
        this.menuClose?.addEventListener("click", () => this.closeMenu());
        
        // Close menu when clicking on links
        this.fullMenu?.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => this.closeMenu());
        });

        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.fullMenu?.classList.contains('active')) {
                this.closeMenu();
            }
        });

        // Scroll events
        window.addEventListener("scroll", () => this.handleScroll());
        
        // Back to top button
        this.backToTop?.addEventListener('click', () => this.scrollToTop());
    }

    openMenu() {
        this.fullMenu?.classList.add("active");
        document.body.style.overflow = 'hidden'; // Prevent background scroll
    }

    closeMenu() {
        this.fullMenu?.classList.remove("active");
        document.body.style.overflow = ''; // Restore scroll
    }

    handleScroll() {
        const scrollY = window.scrollY;
        
        // Sticky header
        if (scrollY > 50) {
            this.header?.classList.add("sticky");
        } else {
            this.header?.classList.remove("sticky");
        }

        // Back to top button
        if (scrollY > 300) {
            this.backToTop?.classList.add("show");
        } else {
            this.backToTop?.classList.remove("show");
        }
    }

    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
}

// Initialize navigation manager
new NavigationManager();


// ===== AI CHAT MANAGEMENT =====
class AIChatManager {
    constructor() {
        this.aiIcon = document.getElementById("aiChatIcon");
        this.chatBox = document.getElementById("aiChatBox");
        this.chatInput = document.getElementById("chatInput");
        this.chatBody = document.getElementById("chatBody");
        this.sendBtn = document.getElementById("sendBtn");
        this.isOpen = false;
        this.init();
    }

    init() {
        if (!this.aiIcon) return;

        this.aiIcon.addEventListener("click", () => this.toggleChat());
        this.sendBtn?.addEventListener("click", () => this.sendMessage());
        this.chatInput?.addEventListener("keypress", (e) => {
            if (e.key === "Enter" && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        
        if (this.isOpen) {
            this.chatBox.style.display = "flex";
            this.chatInput?.focus();
            
            // Welcome message if chat is empty
            if (this.chatBody.innerHTML.trim() === "") {
                const welcomeMsg = this.createMessage("ai", "Hello! I'm your AI assistant. How can I help you today?");
                this.chatBody.appendChild(welcomeMsg);
            }
        } else {
            this.chatBox.style.display = "none";
        }
    }

    async sendMessage() {
        const msg = this.chatInput.value.trim();
        if (!msg) return;

        // Add user message
        const userMsg = this.createMessage("me", msg);
        this.chatBody.appendChild(userMsg);
        this.chatInput.value = "";

        // Add typing indicator
        const typing = this.createTypingIndicator();
        this.chatBody.appendChild(typing);
        this.scrollToBottom();

        try {
            const response = await fetch("/ai-chat", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({ message: msg })
            });

            const data = await response.json();
            typing.remove();

            if (data.success) {
                const aiMsg = this.createMessage("ai", data.message, true);
                this.chatBody.appendChild(aiMsg);
            } else {
                const errorMsg = this.createMessage("ai", data.message || "Sorry, I couldn't process your request.");
                this.chatBody.appendChild(errorMsg);
            }

        } catch (error) {
            typing.remove();
            const errorMsg = this.createMessage("ai", "Sorry, I'm currently unavailable. Please try again later.");
            this.chatBody.appendChild(errorMsg);
        }

        this.scrollToBottom();
    }

    createMessage(type, text, isHtml = false) {
        const messageDiv = document.createElement("div");
        messageDiv.className = `chat-message ${type}`;

        const contentDiv = document.createElement("div");
        contentDiv.className = "message-content";
        
        if (isHtml) {
            contentDiv.innerHTML = text;
        } else {
            contentDiv.textContent = text;
        }

        const toolsDiv = document.createElement("div");
        toolsDiv.className = "message-tools";

        // Copy button
        const copyBtn = document.createElement("button");
        copyBtn.className = "tool-btn copy-btn";
        copyBtn.innerHTML = '<i class="bi bi-clipboard"></i>';
        copyBtn.title = "Copy message";
        copyBtn.addEventListener("click", () => this.copyMessage(text, copyBtn, isHtml));

        toolsDiv.appendChild(copyBtn);

        // Edit button for user messages
        if (type === "me") {
            const editBtn = document.createElement("button");
            editBtn.className = "tool-btn edit-btn";
            editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
            editBtn.title = "Edit message";
            editBtn.addEventListener("click", () => {
                this.chatInput.value = text;
                this.chatInput.focus();
            });
            toolsDiv.appendChild(editBtn);
        }

        messageDiv.appendChild(contentDiv);
        messageDiv.appendChild(toolsDiv);

        return messageDiv;
    }

    createTypingIndicator() {
        const typingDiv = document.createElement("div");
        typingDiv.className = "chat-message ai typing-indicator";
        typingDiv.innerHTML = `
            <div class="message-content">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        return typingDiv;
    }

    async copyMessage(text, button, isHtml = false) {
        try {
            const textToCopy = isHtml ? this.stripHtml(text) : text;
            await navigator.clipboard.writeText(textToCopy);
            
            const originalIcon = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check2"></i>';
            button.classList.add('copied');
            
            setTimeout(() => {
                button.innerHTML = originalIcon;
                button.classList.remove('copied');
            }, 2000);
        } catch (error) {
            console.error('Failed to copy text:', error);
        }
    }

    stripHtml(html) {
        const div = document.createElement("div");
        div.innerHTML = html;
        return div.textContent || div.innerText || "";
    }

    scrollToBottom() {
        this.chatBody.scrollTop = this.chatBody.scrollHeight;
    }
}

// Initialize AI chat manager
new AIChatManager();







// ===== SERVICE SEARCH MANAGEMENT =====
class ServiceSearchManager {
    constructor() {
        this.searchInput = document.getElementById('serviceSearch');
        this.searchResults = document.getElementById('searchResults');
        this.debounceTimer = null;
        this.init();
    }

    init() {
        if (!this.searchInput) return;

        this.searchInput.addEventListener('input', (e) => this.handleSearch(e.target.value));
        this.searchInput.addEventListener('focus', () => this.showResults());
        
        // Hide results when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.service-search-box')) {
                this.hideResults();
            }
        });
    }

    handleSearch(query) {
        clearTimeout(this.debounceTimer);
        
        if (query.length < 2) {
            this.hideResults();
            return;
        }

        // Debounce search requests
        this.debounceTimer = setTimeout(() => {
            this.performSearch(query);
        }, 300);
    }

    async performSearch(query) {
        try {
            const response = await fetch(`/search-services?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            this.displayResults(data);
        } catch (error) {
            console.error('Search error:', error);
            this.displayError();
        }
    }

    displayResults(services) {
        if (!this.searchResults) return;

        this.searchResults.innerHTML = '';
        
        if (services.length === 0) {
            this.searchResults.innerHTML = `
                <li class="list-group-item text-muted text-center">
                    <i class="bi bi-search"></i> No services found
                </li>
            `;
        } else {
            services.forEach(service => {
                const li = document.createElement('li');
                li.className = 'list-group-item list-group-item-action search-item';
                li.innerHTML = `
                    <div class="d-flex align-items-center">
                        <img src="${service.image ? '/uploads/services/' + service.image : '/images/default-service.jpg'}" 
                             alt="${service.title}" class="search-item-img me-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">${service.title}</h6>
                            <small class="text-muted">${service.short_description ? service.short_description.substring(0, 60) + '...' : ''}</small>
                        </div>
                    </div>
                `;
                
                li.addEventListener('click', () => {
                    window.location.href = `/service/${service.slug}`;
                });
                
                this.searchResults.appendChild(li);
            });
        }
        
        this.showResults();
    }

    displayError() {
        if (!this.searchResults) return;
        
        this.searchResults.innerHTML = `
            <li class="list-group-item text-danger text-center">
                <i class="bi bi-exclamation-triangle"></i> Search error occurred
            </li>
        `;
        this.showResults();
    }

    showResults() {
        if (this.searchResults) {
            this.searchResults.style.display = 'block';
        }
    }

    hideResults() {
        if (this.searchResults) {
            this.searchResults.style.display = 'none';
        }
    }
}

// Initialize service search manager
new ServiceSearchManager();


// ===== FORM MANAGEMENT =====
class FormManager {
    constructor() {
        this.init();
    }

    init() {
        // Newsletter forms
        this.initNewsletterForms();
        
        // Service inquiry forms
        this.initServiceInquiryForms();
        
        // Contact forms
        this.initContactForms();
    }

    initNewsletterForms() {
        // Main CTA newsletter
        const ctaForm = document.getElementById('subscribeForm');
        if (ctaForm) {
            ctaForm.addEventListener('submit', (e) => this.handleNewsletterSubmit(e));
        }

        // Footer newsletter
        const footerForm = document.getElementById('footerSubscribe');
        if (footerForm) {
            footerForm.addEventListener('submit', (e) => this.handleNewsletterSubmit(e));
        }
    }

    initServiceInquiryForms() {
        const inquiryForm = document.getElementById('inquiryForm');
        if (inquiryForm) {
            inquiryForm.addEventListener('submit', (e) => this.handleInquirySubmit(e));
        }
    }

    initContactForms() {
        // Add contact form handlers here if needed
    }

    async handleNewsletterSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const email = formData.get('email');

        if (!this.validateEmail(email)) {
            this.showToast('Please enter a valid email address', 'error');
            return;
        }

        try {
            // Simulate API call - replace with actual endpoint
            await new Promise(resolve => setTimeout(resolve, 1000));
            
            this.showToast('Successfully subscribed to newsletter!', 'success');
            form.reset();
        } catch (error) {
            this.showToast('Subscription failed. Please try again.', 'error');
        }
    }

    async handleInquirySubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        
        // Validate form
        if (!this.validateInquiryForm(form)) {
            return;
        }

        try {
            const response = await fetch('/save-inquiry', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showToast('Inquiry submitted successfully!', 'success');
                
                // Close modal if exists
                const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                if (modal) {
                    modal.hide();
                }
                
                form.reset();
            } else {
                this.showToast(data.message || 'Submission failed. Please try again.', 'error');
            }
        } catch (error) {
            this.showToast('Network error. Please try again.', 'error');
        }
    }

    validateInquiryForm(form) {
        let isValid = true;
        
        // Clear previous errors
        form.querySelectorAll('.error-msg').forEach(error => error.remove());
        
        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                this.showFieldError(field, 'This field is required');
                isValid = false;
            }
        });

        // Validate email
        const emailField = form.querySelector('[type="email"]');
        if (emailField && emailField.value && !this.validateEmail(emailField.value)) {
            this.showFieldError(emailField, 'Please enter a valid email address');
            isValid = false;
        }

        // Validate phone
        const phoneField = form.querySelector('[name="phone"]');
        if (phoneField && phoneField.value && !this.validatePhone(phoneField.value)) {
            this.showFieldError(phoneField, 'Please enter a valid phone number');
            isValid = false;
        }

        return isValid;
    }

    showFieldError(field, message) {
        const error = document.createElement('div');
        error.className = 'error-msg text-danger small mt-1';
        error.textContent = message;
        field.parentNode.appendChild(error);
        field.classList.add('is-invalid');
    }

    validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    validatePhone(phone) {
        return /^[\+]?[1-9][\d]{0,15}$/.test(phone.replace(/\s/g, ''));
    }

    showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        // Add to toast container or create one
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }

        toastContainer.appendChild(toast);

        // Show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // Remove toast element after it's hidden
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
}

// Initialize form manager
new FormManager();

// ===== UTILITY FUNCTIONS =====
class Utils {
    static smoothScroll(target) {
        const element = document.querySelector(target);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    static debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    static throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
}

// ===== INITIALIZE ALL COMPONENTS =====
document.addEventListener('DOMContentLoaded', () => {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = this.getAttribute('href');
            if (target !== '#') {
                Utils.smoothScroll(target);
            }
        });
    });

    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.refresh();
    }
});


