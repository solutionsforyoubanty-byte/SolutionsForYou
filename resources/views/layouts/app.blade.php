<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    {{-- Responsive --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic Title --}}
    <title>@yield('title', 'SolutionsForYou')</title>

    {{-- Dynamic Meta Description --}}
    <meta name="description" content="@yield('meta_description', 'Best Laravel Website by SolutionsForYou')">

    {{-- Keywords --}}
    <meta name="keywords" content="@yield('meta_keywords', 'Laravel, PHP, SolutionsForYou')">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
        
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />




    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', 'SolutionsForYou')">
    <meta property="og:description" content="@yield('og_description', 'Best services by SolutionsForYou')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="@yield('og_image', asset('default-og.jpg'))">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'SolutionsForYou')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Best services by SolutionsForYou')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('default-twitter.jpg'))">

    {{-- JSON-LD Schema --}}
    @yield('json_ld')

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- CSS via Vite --}}
    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    {{-- Extra Head --}}
    @stack('head')
</head>

<body class="loading">
{{ $slot ?? '' }}
<!-- Preloader -->
    <div id="preloader">
        <!-- Floating Particles -->
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>

        <!-- Logo with Animation -->
        <div class="logo-container">
            <div class="loading-ring"></div>
            <div class="wave-logo">
                <div class="wave-shape wave-1"></div>
                <div class="wave-shape wave-2"></div>
            </div>
        </div>

        <!-- Loading Text -->
        <div class="loading-text">
            <span>S</span><span>o</span><span>l</span><span>u</span><span>t</span><span>i</span><span>o</span><span>n</span><span>s</span><span>F</span><span>o</span><span>r</span><span>Y</span><span>o</span><span>u</span>
        </div>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <!-- Loading Message -->
        <div class="loading-message">Loading your experience...</div>
    </div>



    {{-- Header --}}
    @include('layouts.header')

    {{-- Main Content --}}
    <main id="app">
        @yield('content')
    </main>

    <!-- AI Chat Icon with Tooltip -->
    <div style="position: relative; display: inline-block;">
        <div id="aiChatIcon">
            <i class="bi bi-robot"></i>
        </div>
        <div id="aiTooltip">Chat with AI 🤖</div>
    </div>

    <!-- AI Chat Box -->
    <div id="aiChatBox" style="display: none;">
        <div class="header">AI Assistant</div>
        <div class="body" id="chatBody"></div>
        <div class="footer">
            <input type="text" id="chatInput" placeholder="Type your message..." />
            <button id="sendBtn">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>



    {{-- Footer --}}
    @include('layouts.footer')

    {{-- Extra Scripts --}}
    @stack('scripts')
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
AOS.init({
  duration: 800,
  easing: "ease-in-out",
  once: true,
  mirror: false,
  offset: 120,
});

// Blog Swiper
const blogSwiper = new Swiper(".blogSwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
});
</script>

<script>
        // Preloader Logic
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            const body = document.body;
            
            // Minimum display time: 1.5 seconds (adjust as needed)
            setTimeout(function() {
                preloader.classList.add('hidden');
                body.classList.remove('loading');
                
                // Remove from DOM after fade out
                setTimeout(function() {
                    preloader.remove();
                }, 500);
            }, 1500); // Change this value to adjust minimum display time
        });

        // Safety: Remove preloader if page takes too long (10 seconds max)
        setTimeout(function() {
            const preloader = document.getElementById('preloader');
            const body = document.body;
            if (preloader) {
                preloader.classList.add('hidden');
                body.classList.remove('loading');
                setTimeout(function() {
                    preloader.remove();
                }, 500);
            }
        }, 10000);

        // Optional: Show preloader on route changes (for SPAs)
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="/"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Show mini loader or use existing preloader
                    // This is optional for better UX
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>

</html>
