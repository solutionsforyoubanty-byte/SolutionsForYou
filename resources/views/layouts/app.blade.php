<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#2874f0">
    <title>@yield('title', 'E-Shop - Online Shopping')</title>
    
    <!-- Google Fonts - Inter (Professional E-commerce Font) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2874f0',
                        secondary: '#fb641b',
                        dark: '#212121',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        'display': ['Poppins', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        h1, h2, h3, .font-display { font-family: 'Poppins', 'Inter', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }
        body { -webkit-tap-highlight-color: transparent; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        @media (max-width: 768px) {
            .mobile-menu-open { overflow: hidden; }
        }
        .swiper-button-next, .swiper-button-prev {
            background: white;
            width: 35px !important;
            height: 35px !important;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 14px !important;
            color: #333;
            font-weight: bold;
        }
        /* Price styling */
        .price-tag { font-feature-settings: 'tnum' on, 'lnum' on; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans antialiased">
    <!-- Mobile Header -->
    <header class="bg-primary sticky top-0 z-50">
        <div class="px-3 md:px-4 lg:max-w-7xl lg:mx-auto">
            <div class="flex items-center justify-between py-2 md:py-3 gap-2 md:gap-4">
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden text-white p-2 -ml-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <h1 class="text-white text-xl md:text-2xl font-bold italic">E-Shop</h1>
                    <span class="hidden md:flex text-xs text-yellow-300 items-center gap-1">
                        Explore <span class="text-yellow-400">Plus</span> <i class="fas fa-star text-yellow-400 text-[8px]"></i>
                    </span>
                </a>

                <!-- Search Bar -->
                <form action="{{ route('shop.index') }}" method="GET" class="hidden md:flex flex-1 max-w-xl">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search for products, brands and more" 
                            class="w-full py-2.5 pl-4 pr-12 rounded-sm text-sm focus:outline-none">
                        <button type="submit" class="absolute right-0 top-0 h-full px-4 text-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Nav Links -->
                <nav class="flex items-center gap-2 md:gap-6">
                    @auth
                        <div class="relative group hidden md:block">
                            <button class="text-white font-medium flex items-center gap-1">
                                <i class="fas fa-user"></i>
                                <span class="hidden lg:inline">{{ Str::limit(auth()->user()->name, 10) }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                                <div class="py-2">
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                                        <i class="fas fa-user w-5"></i> My Profile
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                                        <i class="fas fa-box w-5"></i> Orders
                                    </a>
                                    <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                                        <i class="fas fa-heart w-5"></i> Wishlist
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <hr class="my-2">
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm text-primary">
                                            <i class="fas fa-cog w-5"></i> Admin Panel
                                        </a>
                                    @endif
                                    <hr class="my-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm text-red-600">
                                            <i class="fas fa-sign-out-alt w-5"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-primary px-4 md:px-8 py-1.5 rounded-sm font-medium text-xs md:text-sm hover:bg-gray-100">
                            Login
                        </a>
                    @endauth

                    <a href="{{ route('cart.index') }}" class="text-white font-medium flex items-center gap-1 md:gap-2 relative p-2">
                        <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
                        <span class="hidden md:inline">Cart</span>
                        @auth
                            @if(auth()->user()->carts->count() > 0)
                                <span class="absolute -top-0 right-0 md:-top-1 md:-right-2 bg-secondary text-white text-[10px] md:text-xs w-4 h-4 md:w-5 md:h-5 rounded-full flex items-center justify-center">
                                    {{ auth()->user()->carts->count() }}
                                </span>
                            @endif
                        @endauth
                    </a>
                </nav>
            </div>

            <!-- Mobile Search Bar -->
            <div class="md:hidden pb-2">
                <form action="{{ route('shop.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search products..." 
                            class="w-full py-2 pl-10 pr-4 rounded text-sm focus:outline-none">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <!-- Mobile Side Menu -->
    <div id="mobileMenu" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="toggleMobileMenu()"></div>
        <div class="absolute left-0 top-0 bottom-0 w-72 bg-white transform transition-transform duration-300 -translate-x-full" id="menuPanel">
            @auth
            <div class="bg-primary p-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-blue-200">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-primary p-4">
                <a href="{{ route('login') }}" class="text-white font-medium">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login / Sign Up
                </a>
            </div>
            @endauth

            <nav class="py-2">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100">
                    <i class="fas fa-home w-6 text-gray-500"></i> Home
                </a>
                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100">
                    <i class="fas fa-store w-6 text-gray-500"></i> Shop
                </a>
                @auth
                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100">
                    <i class="fas fa-box w-6 text-gray-500"></i> My Orders
                </a>
                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100">
                    <i class="fas fa-heart w-6 text-gray-500"></i> Wishlist
                </a>
                <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100">
                    <i class="fas fa-user w-6 text-gray-500"></i> My Profile
                </a>
                @if(auth()->user()->isAdmin())
                <hr class="my-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 text-primary">
                    <i class="fas fa-cog w-6"></i> Admin Panel
                </a>
                @endif
                <hr class="my-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-4 py-3 hover:bg-gray-100 text-red-600">
                        <i class="fas fa-sign-out-alt w-6"></i> Logout
                    </button>
                </form>
                @endauth
            </nav>

            <!-- Categories in Mobile Menu -->
            <div class="border-t">
                <p class="px-4 py-2 text-xs text-gray-500 font-medium">CATEGORIES</p>
                @php $categories = \App\Models\Category::where('is_active', true)->take(8)->get(); @endphp
                @foreach($categories as $cat)
                <a href="{{ route('shop.category', $cat->slug) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 text-sm">
                    <i class="fas fa-tag w-6 text-gray-400"></i> {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Category Bar - Desktop Only -->
    <div class="bg-white shadow-sm hidden md:block">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center gap-8 py-3 overflow-x-auto scrollbar-hide">
                @foreach($categories ?? [] as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}" class="flex flex-col items-center gap-1 flex-shrink-0 group">
                        @if($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" class="w-14 h-14 rounded-full object-cover group-hover:scale-110 transition">
                        @else
                            <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                        @endif
                        <span class="text-xs font-medium text-dark group-hover:text-primary">{{ Str::limit($cat->name, 10) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="px-3 md:px-4 lg:max-w-7xl lg:mx-auto mt-3">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-3 py-2 md:px-4 md:py-3 rounded flex items-center gap-2 text-sm">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="px-3 md:px-4 lg:max-w-7xl lg:mx-auto mt-3">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-3 py-2 md:px-4 md:py-3 rounded flex items-center gap-2 text-sm">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-gray-400 mt-8">
        <div class="px-4 lg:max-w-7xl lg:mx-auto py-8 md:py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div>
                    <h4 class="text-gray-300 text-xs font-medium mb-3 md:mb-4">ABOUT</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-white">Contact Us</a></li>
                        <li><a href="{{ route('pages.about') }}" class="hover:text-white">About Us</a></li>
                        <li><a href="{{ route('pages.careers') }}" class="hover:text-white">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gray-300 text-xs font-medium mb-3 md:mb-4">HELP</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('pages.payments') }}" class="hover:text-white">Payments</a></li>
                        <li><a href="{{ route('pages.shipping') }}" class="hover:text-white">Shipping</a></li>
                        <li><a href="{{ route('pages.returns') }}" class="hover:text-white">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gray-300 text-xs font-medium mb-3 md:mb-4">POLICY</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('pages.return-policy') }}" class="hover:text-white">Return Policy</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="hover:text-white">Terms Of Use</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="hover:text-white">Privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gray-300 text-xs font-medium mb-3 md:mb-4">SOCIAL</h4>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-white"><i class="fab fa-facebook text-lg"></i></a>
                        <a href="#" class="hover:text-white"><i class="fab fa-twitter text-lg"></i></a>
                        <a href="#" class="hover:text-white"><i class="fab fa-instagram text-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-gray-700 my-6 md:my-8">

            <!-- Payment Methods - Mobile -->
            <div class="md:hidden mb-4">
                <p class="text-gray-500 text-[10px] text-center mb-2">Payment Methods</p>
                <div class="flex items-center justify-center gap-4">
                    <i class="fab fa-cc-visa text-2xl text-blue-400" title="Visa"></i>
                    <i class="fab fa-cc-mastercard text-2xl text-orange-400" title="Mastercard"></i>
                    <i class="fab fa-cc-amex text-2xl text-blue-300" title="Amex"></i>
                    <i class="fab fa-google-pay text-2xl text-white" title="Google Pay"></i>
                    <span class="text-green-400 font-bold text-sm" title="RuPay">₹Pay</span>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-3 md:gap-4 text-xs text-center md:text-left">
                <p>&copy; {{ date('Y') }} E-Shop. All rights reserved.</p>
                <div class="flex flex-wrap justify-center items-center gap-2 md:gap-4">
                    <span><i class="fas fa-headset mr-1"></i> 24x7 Support</span>
                    <span><i class="fas fa-undo mr-1"></i> Easy Returns</span>
                    <span><i class="fas fa-shield-alt mr-1"></i> Secure</span>
                </div>
                <!-- Payment Methods - Desktop -->
                <div class="hidden md:flex items-center gap-3">
                    <i class="fab fa-cc-visa text-xl text-blue-400" title="Visa"></i>
                    <i class="fab fa-cc-mastercard text-xl text-orange-400" title="Mastercard"></i>
                    <i class="fab fa-cc-amex text-xl text-blue-300" title="American Express"></i>
                    <i class="fab fa-google-pay text-xl text-white" title="Google Pay"></i>
                    <i class="fab fa-apple-pay text-xl text-white" title="Apple Pay"></i>
                    <span class="text-green-400 font-bold text-sm" title="RuPay">₹Pay</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    @auth
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg z-40 safe-bottom">
        <div class="flex items-center justify-around py-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-500' }}">
                <i class="fas fa-home text-lg"></i>
                <span class="text-[10px]">Home</span>
            </a>
            <a href="{{ route('shop.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('shop.*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="fas fa-th-large text-lg"></i>
                <span class="text-[10px]">Shop</span>
            </a>
            <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 relative {{ request()->routeIs('cart.*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="fas fa-shopping-cart text-lg"></i>
                <span class="text-[10px]">Cart</span>
                @if(auth()->user()->carts->count() > 0)
                    <span class="absolute top-0 right-1 bg-secondary text-white text-[8px] w-4 h-4 rounded-full flex items-center justify-center">
                        {{ auth()->user()->carts->count() }}
                    </span>
                @endif
            </a>
            <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('wishlist.*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="fas fa-heart text-lg"></i>
                <span class="text-[10px]">Wishlist</span>
            </a>
            <a href="{{ route('profile.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="fas fa-user text-lg"></i>
                <span class="text-[10px]">Account</span>
            </a>
        </div>
    </div>
    <div class="md:hidden h-16"></div>
    @endauth

    <script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const panel = document.getElementById('menuPanel');
        
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            document.body.classList.add('mobile-menu-open');
            setTimeout(() => panel.classList.remove('-translate-x-full'), 10);
        } else {
            panel.classList.add('-translate-x-full');
            document.body.classList.remove('mobile-menu-open');
            setTimeout(() => menu.classList.add('hidden'), 300);
        }
    }

    function toggleWishlist(productId) {
        fetch('{{ route("wishlist.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(r => r.json())
        .then(data => {
            document.querySelectorAll('.wishlist-btn-' + productId).forEach(btn => {
                btn.classList.toggle('text-red-500', data.status === 'added');
            });
        });
    }
    </script>

    @stack('scripts')
</body>
</html>
