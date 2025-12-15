<div class="header" id="header">
    <div class="header-left">
        <div class="logo">
            <a href="{{ url('/') }}" class="logo-link">
                <img src="{{ asset('assets/logo/my-logo.png') }}" alt="SolutionsForYou Logo" class="logo-img">
                {{-- <span class="logo-text">SolutionsForYou</span> --}}
            </a>
        </div>
    </div>

    <div class="header-right">
        
        <!-- THEME TOGGLE -->
        <button id="themeToggle" class="btn theme-btn" title="Toggle Dark/Light Mode">
            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
        </button>

        <!-- MENU TOGGLE BUTTON -->
        <button class="menu-toggle" id="menuToggle" title="Open Menu">
            <i class="bi bi-menu-app"></i>
        </button>
    </div>
</div>

<!-- FULL SCREEN MENU -->
<div id="fullMenu" class="fullscreen-menu">
    <button class="menu-close" id="menuClose" title="Close Menu">
        <i class="bi bi-x-lg"></i>
    </button>

    <ul class="menu-links">
        <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house"></i> Home
        </a></li>
        <li><a href="{{ url('/#about') }}" class="{{ request()->is('/#about') ? 'active' : '' }}">
            <i class="bi bi-person"></i> About
        </a></li>
        <li><a href="{{ url('/#projects') }}" class="{{ request()->is('/#projects') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i> Portfolio
        </a></li>
        <li><a href="{{ route('user.services.index') }}" class="{{ request()->is('services*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Services
        </a></li>
        <li><a href="{{ route('user.blogs') }}" class="{{ request()->is('blogs*') ? 'active' : '' }}">
            <i class="bi bi-blog"></i> Blogs
        </a></li>
        <li><a href="{{ url('/#contact') }}" class="{{ request()->is('/#contact') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Contact
        </a></li>
    </ul>

    <!-- Social Links in Menu -->
    <div class="menu-social">
        <a href="#" class="social-link" title="Facebook">
            <i class="bi bi-facebook"></i>
        </a>
        <a href="#" class="social-link" title="Twitter">
            <i class="bi bi-twitter"></i>
        </a>
        <a href="#" class="social-link" title="Instagram">
            <i class="bi bi-instagram"></i>
        </a>
        <a href="#" class="social-link" title="LinkedIn">
            <i class="bi bi-linkedin"></i>
        </a>
    </div>
</div>

