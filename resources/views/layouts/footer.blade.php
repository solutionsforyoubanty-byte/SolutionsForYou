<footer class="site-footer" id="contact">
    <div class="container">

        <div class="row">

            <!-- About -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-logo mb-3">
                    <img src="{{ asset('assets/logo/my-logo.png') }}" alt="SolutionsForYou" class="footer-logo-img">
                    <h4 class="footer-title">SolutionsForYou</h4>
                </div>
                <p class="footer-text">
                    We are a digital development agency providing modern web development, AI solutions, and branding services to help businesses grow and succeed in the digital world.
                </p>
                <div class="footer-contact">
                    <p><i class="bi bi-envelope"></i> info@solutionsforyou.com</p>
                    <p><i class="bi bi-telephone"></i> +91 9876543210</p>
                    <p><i class="bi bi-geo-alt"></i> India</p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="bi bi-chevron-right"></i> Home</a></li>
                    <li><a href="{{ url('/#about') }}"><i class="bi bi-chevron-right"></i> About Us</a></li>
                    <li><a href="{{ route('services.index') }}"><i class="bi bi-chevron-right"></i> Services</a></li>
                    <li><a href="{{ url('/#projects') }}"><i class="bi bi-chevron-right"></i> Portfolio</a></li>
                    <li><a href="{{ url('/#contact') }}"><i class="bi bi-chevron-right"></i> Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-title">Our Services</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Web Development</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Mobile Apps</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> UI/UX Design</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> SEO Services</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> AI Solutions</a></li>
                </ul>
            </div>

            <!-- Newsletter & Social -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h4 class="footer-title">Stay Connected</h4>
                <p class="footer-text mb-3">Subscribe to our newsletter for updates and special offers.</p>
                
                <!-- Newsletter Form -->
                <form class="footer-newsletter mb-4" id="footerSubscribeForm">
                    <div class="input-group">
                        <input type="email" name="email" id="footerSubscribeEmail" class="form-control" placeholder="Your email address" required>
                        <button type="submit" class="btn btn-primary" id="footerSubscribeBtn">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                    <div id="footerSubscribeMessage" class="mt-2" style="display: none;"></div>
                </form>

                <script>
                document.getElementById('footerSubscribeForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const email = document.getElementById('footerSubscribeEmail').value;
                    const btn = document.getElementById('footerSubscribeBtn');
                    const msgDiv = document.getElementById('footerSubscribeMessage');
                    const originalBtnHtml = btn.innerHTML;
                    
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                    
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
                            msgDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle"></i> ' + data.message + '</small>';
                            document.getElementById('footerSubscribeEmail').value = '';
                        } else {
                            msgDiv.innerHTML = '<small class="text-warning"><i class="bi bi-info-circle"></i> ' + data.message + '</small>';
                        }
                    })
                    .catch(error => {
                        msgDiv.style.display = 'block';
                        msgDiv.innerHTML = '<small class="text-danger"><i class="bi bi-x-circle"></i> Something went wrong!</small>';
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalBtnHtml;
                        setTimeout(() => { msgDiv.style.display = 'none'; }, 5000);
                    });
                });
                </script>

                <!-- Social Icons -->
                <div class="footer-social">
                    <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" title="Twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    <a href="#" title="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" title="GitHub"><i class="bi bi-github"></i></a>
                </div>

                <!-- Legal Links -->
                <div class="footer-legal mt-3">
                    <a href="#" class="legal-link">Privacy Policy</a>
                    <span class="separator">|</span>
                    <a href="#" class="legal-link">Terms of Service</a>
                </div>
            </div>

        </div>

        <hr class="footer-divider" />

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright-text">© {{ date('Y') }} SolutionsForYou. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="made-with">Made with <i class="bi bi-heart-fill text-danger"></i> in India</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="Back to Top">
        <i class="bi bi-arrow-up"></i>
    </button>
</footer>
