@extends('layouts.app')
@section('title', 'E-Shop - Online Shopping India')

@section('content')
<!-- Hero Banner Slider -->
<div class="bg-white">
    <div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-2">
        <div class="relative overflow-hidden rounded" id="heroSlider">
            <div class="flex transition-transform duration-500" id="sliderTrack">
                <div class="w-full flex-shrink-0">
                    <div class="bg-gradient-to-r from-primary to-blue-600 h-36 md:h-56 lg:h-72 flex items-center justify-between px-4 md:px-8 lg:px-16 rounded">
                        <div class="text-white">
                            <p class="text-xs md:text-lg opacity-80">Big Savings Days</p>
                            <h2 class="text-xl md:text-4xl lg:text-5xl font-bold my-1 md:my-2">UP TO 80% OFF</h2>
                            <p class="text-sm md:text-xl">On Electronics & More</p>
                            <a href="{{ route('shop.index') }}" class="inline-block mt-2 md:mt-4 bg-secondary text-white px-4 md:px-6 py-1.5 md:py-2 rounded font-medium text-xs md:text-base hover:bg-orange-600">
                                Shop Now <i class="fas fa-arrow-right ml-1 md:ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full flex-shrink-0">
                    <div class="bg-gradient-to-r from-green-600 to-teal-500 h-36 md:h-56 lg:h-72 flex items-center justify-between px-4 md:px-8 lg:px-16 rounded">
                        <div class="text-white">
                            <p class="text-xs md:text-lg opacity-80">Fashion Sale</p>
                            <h2 class="text-xl md:text-4xl lg:text-5xl font-bold my-1 md:my-2">MIN 50% OFF</h2>
                            <p class="text-sm md:text-xl">Top Brands Collection</p>
                            <a href="{{ route('shop.index') }}" class="inline-block mt-2 md:mt-4 bg-white text-green-600 px-4 md:px-6 py-1.5 md:py-2 rounded font-medium text-xs md:text-base hover:bg-gray-100">
                                Explore <i class="fas fa-arrow-right ml-1 md:ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="slideHero(-1)" class="absolute left-1 md:left-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white w-7 h-12 md:w-10 md:h-20 rounded shadow flex items-center justify-center">
                <i class="fas fa-chevron-left text-gray-600 text-sm md:text-base"></i>
            </button>
            <button onclick="slideHero(1)" class="absolute right-1 md:right-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white w-7 h-12 md:w-10 md:h-20 rounded shadow flex items-center justify-center">
                <i class="fas fa-chevron-right text-gray-600 text-sm md:text-base"></i>
            </button>
        </div>
    </div>
</div>

<!-- Categories Strip - Mobile Horizontal Scroll -->
@if($categories->count())
<div class="bg-white mt-2 md:mt-3">
    <div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-4">
        <div class="flex md:grid md:grid-cols-8 gap-3 md:gap-4 overflow-x-auto scrollbar-hide pb-2 md:pb-0">
            @foreach($categories->take(8) as $category)
            <a href="{{ route('shop.category', $category->slug) }}" class="flex flex-col items-center group flex-shrink-0 w-16 md:w-auto">
                <div class="w-14 h-14 md:w-20 md:h-20 rounded-full overflow-hidden bg-gray-100 group-hover:shadow-lg transition">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-tag text-xl md:text-2xl text-gray-300"></i>
                        </div>
                    @endif
                </div>
                <span class="text-[10px] md:text-sm font-medium mt-1 md:mt-2 text-center group-hover:text-primary line-clamp-2">{{ $category->name }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Deals of the Day -->
@if($deals->count())
<div class="bg-white mt-2 md:mt-3">
    <div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-4">
        <div class="flex items-center justify-between mb-3 md:mb-4">
            <div class="flex items-center gap-2 md:gap-4">
                <h2 class="text-base md:text-2xl font-bold">Deals of the Day</h2>
                <div class="flex items-center gap-1 md:gap-2 bg-red-600 text-white px-2 md:px-3 py-0.5 md:py-1 rounded text-xs md:text-sm">
                    <i class="fas fa-clock"></i>
                    <span id="dealTimer">22:15:30</span>
                </div>
            </div>
            <a href="{{ route('shop.index', ['deals' => 1]) }}" class="bg-primary text-white px-3 md:px-6 py-1.5 md:py-2 rounded text-xs md:text-sm font-medium hover:bg-blue-700">
                VIEW ALL
            </a>
        </div>
        <div class="flex md:grid md:grid-cols-6 gap-2 md:gap-4 overflow-x-auto scrollbar-hide pb-2 md:pb-0">
            @foreach($deals as $product)
            <a href="{{ route('shop.show', $product->slug) }}" class="group flex-shrink-0 w-32 md:w-auto">
                <div class="bg-white border rounded p-2 md:p-3 hover:shadow-lg transition">
                    <div class="relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-24 md:h-40 object-contain group-hover:scale-105 transition">
                        @else
                            <div class="w-full h-24 md:h-40 bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-image text-2xl md:text-4xl text-gray-300"></i>
                            </div>
                        @endif
                        @if($product->discount_percent > 0)
                            <span class="absolute top-0 left-0 bg-red-500 text-white text-[10px] md:text-xs px-1.5 md:px-2 py-0.5 md:py-1 rounded-br">
                                {{ $product->discount_percent }}% OFF
                            </span>
                        @endif
                    </div>
                    <div class="mt-2 md:mt-3 text-center">
                        <h3 class="text-xs md:text-sm font-medium text-dark line-clamp-2">{{ $product->name }}</h3>
                        <div class="mt-1">
                            <span class="text-sm md:text-lg font-bold text-dark">₹{{ number_format($product->current_price) }}</span>
                            @if($product->is_on_sale)
                                <span class="text-[10px] md:text-sm text-gray-400 line-through ml-1">₹{{ number_format($product->price) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Featured Products -->
@if($featured_products->count())
<div class="bg-white mt-2 md:mt-3">
    <div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-4">
        <div class="flex items-center justify-between mb-3 md:mb-4">
            <h2 class="text-base md:text-2xl font-bold">Featured Products</h2>
            <a href="{{ route('shop.index', ['featured' => 1]) }}" class="text-primary font-medium text-xs md:text-base hover:underline">
                View All <i class="fas fa-chevron-right text-xs ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 md:gap-4">
            @foreach($featured_products->take(10) as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Banner Strip -->
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto mt-2 md:mt-3">
    <div class="grid md:grid-cols-2 gap-2 md:gap-3">
        <div class="bg-gradient-to-r from-purple-600 to-pink-500 rounded p-4 md:p-6 text-white">
            <p class="text-xs md:text-sm opacity-80">New Arrivals</p>
            <h3 class="text-lg md:text-2xl font-bold my-1 md:my-2">Fashion Collection</h3>
            <p class="text-xs md:text-sm opacity-80 mb-2 md:mb-4">Trending styles at best prices</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-white text-purple-600 px-3 md:px-4 py-1.5 md:py-2 rounded text-xs md:text-sm font-medium">Shop Now</a>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded p-4 md:p-6 text-white">
            <p class="text-xs md:text-sm opacity-80">Limited Time</p>
            <h3 class="text-lg md:text-2xl font-bold my-1 md:my-2">Electronics Sale</h3>
            <p class="text-xs md:text-sm opacity-80 mb-2 md:mb-4">Up to 70% off on gadgets</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-white text-orange-600 px-3 md:px-4 py-1.5 md:py-2 rounded text-xs md:text-sm font-medium">Explore</a>
        </div>
    </div>
</div>

<!-- Latest Products -->
@if($latest_products->count())
<div class="bg-white mt-2 md:mt-3">
    <div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-4">
        <div class="flex items-center justify-between mb-3 md:mb-4">
            <h2 class="text-base md:text-2xl font-bold">Recently Added</h2>
            <a href="{{ route('shop.index', ['sort' => 'latest']) }}" class="text-primary font-medium text-xs md:text-base hover:underline">
                View All <i class="fas fa-chevron-right text-xs ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 md:gap-4">
            @foreach($latest_products->take(10) as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Why Shop With Us -->
<div class="bg-white mt-2 md:mt-3">
    <div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-6 md:py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 text-center">
            <div>
                <div class="w-12 h-12 md:w-16 md:h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fas fa-truck text-lg md:text-2xl text-primary"></i>
                </div>
                <h4 class="font-medium text-sm md:text-base">Free Delivery</h4>
                <p class="text-xs md:text-sm text-gray-500">On orders above ₹499</p>
            </div>
            <div>
                <div class="w-12 h-12 md:w-16 md:h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fas fa-undo text-lg md:text-2xl text-green-600"></i>
                </div>
                <h4 class="font-medium text-sm md:text-base">Easy Returns</h4>
                <p class="text-xs md:text-sm text-gray-500">7 days return policy</p>
            </div>
            <div>
                <div class="w-12 h-12 md:w-16 md:h-16 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fas fa-shield-alt text-lg md:text-2xl text-orange-600"></i>
                </div>
                <h4 class="font-medium text-sm md:text-base">Secure Payment</h4>
                <p class="text-xs md:text-sm text-gray-500">100% secure checkout</p>
            </div>
            <div>
                <div class="w-12 h-12 md:w-16 md:h-16 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fas fa-headset text-lg md:text-2xl text-purple-600"></i>
                </div>
                <h4 class="font-medium text-sm md:text-base">24/7 Support</h4>
                <p class="text-xs md:text-sm text-gray-500">Dedicated support</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentSlide = 0;
const totalSlides = 2;

function slideHero(dir) {
    currentSlide = (currentSlide + dir + totalSlides) % totalSlides;
    document.getElementById('sliderTrack').style.transform = `translateX(-${currentSlide * 100}%)`;
}

setInterval(() => slideHero(1), 5000);

function updateTimer() {
    const now = new Date();
    const end = new Date();
    end.setHours(23, 59, 59);
    const diff = end - now;
    const h = Math.floor(diff / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    const timer = document.getElementById('dealTimer');
    if (timer) timer.textContent = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
}
setInterval(updateTimer, 1000);
updateTimer();
</script>
@endpush
