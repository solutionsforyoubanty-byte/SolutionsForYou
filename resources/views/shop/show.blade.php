@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="bg-gray-50 min-h-screen pb-20 md:pb-8">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="px-3 md:px-4 lg:max-w-7xl lg:mx-auto py-3">
            <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 overflow-x-auto scrollbar-hide">
                <a href="{{ route('home') }}" class="hover:text-primary flex-shrink-0"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <a href="{{ route('shop.index') }}" class="hover:text-primary flex-shrink-0">Shop</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-primary flex-shrink-0">{{ $product->category->name }}</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span class="text-dark truncate">{{ Str::limit($product->name, 25) }}</span>
            </div>
        </div>
    </div>

    <div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-4 md:py-6">
        <div class="grid lg:grid-cols-12 gap-4 md:gap-6">
            
            <!-- Left - Images Section -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-20">
                    <!-- Main Image -->
                    <div class="relative p-4 md:p-6">
                        <div class="aspect-square flex items-center justify-center bg-gradient-to-br from-gray-50 to-white rounded-lg overflow-hidden">
                            @if($product->image)
                                <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="max-w-full max-h-full object-contain transition-transform duration-300 hover:scale-105 cursor-zoom-in">
                            @else
                                <div class="text-gray-300">
                                    <i class="fas fa-image text-6xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Badges -->
                        <div class="absolute top-6 left-6 flex flex-col gap-2">
                            @if($product->discount_percent > 0)
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                    {{ $product->discount_percent }}% OFF
                                </span>
                            @endif
                            @if($product->is_featured)
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            @endif
                        </div>

                        <!-- Wishlist & Share -->
                        <div class="absolute top-6 right-6 flex flex-col gap-2">
                            @auth
                            <button onclick="toggleWishlist({{ $product->id }})" 
                                class="w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-400 hover:text-red-500 hover:scale-110 transition-all wishlist-btn-{{ $product->id }} {{ $product->isWishlisted() ? 'text-red-500' : '' }}">
                                <i class="fas fa-heart text-lg"></i>
                            </button>
                            @endauth
                            <button onclick="shareProduct()" class="w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-400 hover:text-primary hover:scale-110 transition-all">
                                <i class="fas fa-share-alt text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    @if(count($product->all_images) > 1)
                    <div class="px-4 pb-4 md:px-6 md:pb-6">
                        <div class="flex gap-2 overflow-x-auto scrollbar-hide">
                            @foreach($product->all_images as $index => $img)
                            <button onclick="changeImage('{{ asset('storage/' . $img) }}', this)" 
                                class="w-16 h-16 md:w-20 md:h-20 border-2 rounded-lg p-1.5 hover:border-primary transition-all thumbnail-btn flex-shrink-0 {{ $index == 0 ? 'border-primary ring-2 ring-primary/20' : 'border-gray-200' }}">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-contain">
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Desktop Action Buttons -->
                    <div class="hidden md:flex gap-3 p-6 border-t bg-gray-50">
                        @auth
                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="selectedQty" value="1">
                            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all {{ $product->quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->quantity == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart mr-2"></i> ADD TO CART
                            </button>
                        </form>
                        <button onclick="buyNow()" class="flex-1 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all {{ $product->quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->quantity == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-bolt mr-2"></i> BUY NOW
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="flex-1 bg-gradient-to-r from-primary to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-4 rounded-xl font-bold text-lg text-center shadow-lg hover:shadow-xl transition-all">
                            <i class="fas fa-sign-in-alt mr-2"></i> LOGIN TO BUY
                        </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Right - Product Details -->
            <div class="lg:col-span-7 space-y-4">
                <!-- Main Info Card -->
                <div class="bg-white rounded-xl shadow-sm p-5 md:p-6">
                    <!-- Brand -->
                    @if($product->brand)
                        <a href="{{ route('shop.index', ['search' => $product->brand]) }}" class="inline-block text-xs md:text-sm text-primary font-medium bg-primary/10 px-3 py-1 rounded-full hover:bg-primary/20 transition">
                            {{ $product->brand }}
                        </a>
                    @endif
                    
                    <!-- Title -->
                    <h1 class="text-lg md:text-2xl font-semibold text-dark mt-3 leading-tight">{{ $product->name }}</h1>

                    <!-- Rating Summary -->
                    <div class="flex flex-wrap items-center gap-3 mt-3">
                        <div class="flex items-center gap-1.5 bg-green-500 text-white px-2.5 py-1 rounded-lg">
                            <span class="font-bold text-sm">{{ number_format($product->avg_rating, 1) }}</span>
                            <i class="fas fa-star text-xs"></i>
                        </div>
                        <span class="text-gray-500 text-sm">{{ number_format($product->reviews_count) }} Ratings & Reviews</span>
                        @if($product->sold_count > 0)
                            <span class="text-green-600 text-sm font-medium">
                                <i class="fas fa-check-circle mr-1"></i> {{ number_format($product->sold_count) }}+ Sold
                            </span>
                        @endif
                    </div>

                    <!-- Price Section -->
                    <div class="mt-5 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100">
                        <div class="flex flex-wrap items-end gap-3">
                            <span class="text-3xl md:text-4xl font-bold text-dark">₹{{ number_format($product->current_price) }}</span>
                            @if($product->is_on_sale)
                                <span class="text-lg md:text-xl text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                                <span class="text-lg font-bold text-green-600">{{ $product->discount_percent }}% off</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-1">inclusive of all taxes</p>
                        @if($product->is_on_sale)
                            <p class="text-sm text-green-600 font-medium mt-2">
                                <i class="fas fa-piggy-bank mr-1"></i> You save ₹{{ number_format($product->price - $product->current_price) }}
                            </p>
                        @endif
                    </div>

                    <!-- Quantity Selector -->
                    <div class="mt-5 flex items-center gap-4">
                        <span class="text-sm font-medium text-gray-700">Quantity:</span>
                        <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                            <button onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 transition text-gray-600">
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <span id="qtyDisplay" class="w-12 text-center font-bold text-lg">1</span>
                            <button onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 transition text-gray-600">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                        @if($product->quantity <= 5 && $product->quantity > 0)
                            <span class="text-red-500 text-sm font-medium animate-pulse">
                                <i class="fas fa-fire mr-1"></i> Only {{ $product->quantity }} left!
                            </span>
                        @elseif($product->quantity == 0)
                            <span class="text-red-500 text-sm font-medium">
                                <i class="fas fa-times-circle mr-1"></i> Out of Stock
                            </span>
                        @else
                            <span class="text-green-600 text-sm">
                                <i class="fas fa-check-circle mr-1"></i> In Stock
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Offers Card -->
                <div class="bg-white rounded-xl shadow-sm p-5 md:p-6">
                    <h3 class="font-bold text-base flex items-center gap-2 mb-4">
                        <i class="fas fa-gift text-primary"></i> Available Offers
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg border border-green-100">
                            <i class="fas fa-tag text-green-600 mt-0.5"></i>
                            <div>
                                <p class="text-sm"><span class="font-semibold">Bank Offer:</span> 10% Instant Discount on HDFC Bank Credit Cards</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <i class="fas fa-credit-card text-blue-600 mt-0.5"></i>
                            <div>
                                <p class="text-sm"><span class="font-semibold">No Cost EMI:</span> Starting from ₹{{ number_format($product->current_price / 6) }}/month</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-lg border border-purple-100">
                            <i class="fas fa-percent text-purple-600 mt-0.5"></i>
                            <div>
                                <p class="text-sm"><span class="font-semibold">Special Price:</span> Get extra 5% off with coupon SUPER5</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery & Services -->
                <div class="bg-white rounded-xl shadow-sm p-5 md:p-6">
                    <h3 class="font-bold text-base flex items-center gap-2 mb-4">
                        <i class="fas fa-truck text-primary"></i> Delivery & Services
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-shipping-fast text-blue-600"></i>
                            </div>
                            <p class="text-xs font-medium">Free Delivery</p>
                            <p class="text-[10px] text-gray-500">{{ now()->addDays(3)->format('d M') }}</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-undo text-green-600"></i>
                            </div>
                            <p class="text-xs font-medium">7 Days Return</p>
                            <p class="text-[10px] text-gray-500">Easy returns</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-12 h-12 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-shield-alt text-orange-600"></i>
                            </div>
                            <p class="text-xs font-medium">Warranty</p>
                            <p class="text-[10px] text-gray-500">1 Year</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-12 h-12 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-money-bill-wave text-purple-600"></i>
                            </div>
                            <p class="text-xs font-medium">COD Available</p>
                            <p class="text-[10px] text-gray-500">Pay on delivery</p>
                        </div>
                    </div>
                </div>


                <!-- Description -->
                @if($product->description)
                <div class="bg-white rounded-xl shadow-sm p-5 md:p-6">
                    <h3 class="font-bold text-base flex items-center gap-2 mb-4">
                        <i class="fas fa-info-circle text-primary"></i> Product Description
                    </h3>
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        {{ $product->description }}
                    </div>
                </div>
                @endif

                <!-- Ratings & Reviews -->
                <div class="bg-white rounded-xl shadow-sm p-5 md:p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold text-base flex items-center gap-2">
                            <i class="fas fa-star text-yellow-400"></i> Ratings & Reviews
                        </h3>
                        @auth
                        <button onclick="document.getElementById('reviewForm').classList.toggle('hidden')" class="text-primary text-sm font-medium hover:underline">
                            <i class="fas fa-pen mr-1"></i> Write Review
                        </button>
                        @endauth
                    </div>

                    <!-- Rating Summary -->
                    <div class="flex flex-col md:flex-row gap-6 mb-6 p-4 bg-gray-50 rounded-xl">
                        <div class="text-center md:border-r md:pr-6">
                            <div class="text-5xl font-bold text-dark">{{ number_format($product->avg_rating, 1) }}</div>
                            <div class="flex justify-center gap-1 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($product->avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ number_format($product->reviews_count) }} reviews</p>
                        </div>
                        <div class="flex-1 space-y-2">
                            @foreach([5, 4, 3, 2, 1] as $star)
                            @php $percent = $product->reviews_count > 0 ? ($product->reviews()->where('rating', $star)->count() / $product->reviews_count) * 100 : 0; @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-sm w-3">{{ $star }}</span>
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500 w-10">{{ round($percent) }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Review Form -->
                    @auth
                    <form action="{{ route('reviews.store', $product) }}" method="POST" id="reviewForm" class="hidden mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        @csrf
                        <h4 class="font-medium mb-4">Write Your Review</h4>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Your Rating</label>
                            <div class="flex gap-2" id="starRating">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})" class="text-3xl text-gray-300 hover:text-yellow-400 transition star-btn">
                                    <i class="fas fa-star"></i>
                                </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="5">
                        </div>
                        <div class="mb-4">
                            <input type="text" name="title" placeholder="Review Title (optional)" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:outline-none">
                        </div>
                        <div class="mb-4">
                            <textarea name="comment" rows="4" placeholder="Share your experience with this product..." class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:outline-none resize-none"></textarea>
                        </div>
                        <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Review
                        </button>
                    </form>
                    @endauth

                    <!-- Reviews List -->
                    <div class="space-y-4">
                        @forelse($product->reviews()->with('user')->latest()->take(5)->get() as $review)
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm">{{ $review->user->name }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <div class="flex gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if($review->is_verified)
                                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i> Verified
                                    </span>
                                @endif
                            </div>
                            @if($review->title)
                                <h4 class="font-medium mt-3">{{ $review->title }}</h4>
                            @endif
                            @if($review->comment)
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-comment-slash text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No reviews yet. Be the first to review!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($related->count())
        <div class="mt-6 md:mt-8 bg-white rounded-xl shadow-sm p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-th-large text-primary"></i> Similar Products
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:gap-4">
                @foreach($related as $relatedProduct)
                    @include('partials.product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Mobile Fixed Bottom Actions -->
@auth
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-2xl z-40 safe-bottom">
    <div class="flex gap-2 p-3">
        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="selectedQtyMobile" value="1">
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-orange-500 text-white py-3.5 rounded-xl font-bold text-sm shadow-lg {{ $product->quantity == 0 ? 'opacity-50' : '' }}" {{ $product->quantity == 0 ? 'disabled' : '' }}>
                <i class="fas fa-shopping-cart mr-1"></i> ADD TO CART
            </button>
        </form>
        <button onclick="buyNow()" class="flex-1 bg-gradient-to-r from-orange-500 to-red-500 text-white py-3.5 rounded-xl font-bold text-sm shadow-lg {{ $product->quantity == 0 ? 'opacity-50' : '' }}" {{ $product->quantity == 0 ? 'disabled' : '' }}>
            <i class="fas fa-bolt mr-1"></i> BUY NOW
        </button>
    </div>
</div>
@else
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-2xl z-40 safe-bottom">
    <div class="p-3">
        <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-primary to-blue-600 text-white py-3.5 rounded-xl font-bold text-sm text-center shadow-lg">
            <i class="fas fa-sign-in-alt mr-1"></i> LOGIN TO BUY
        </a>
    </div>
</div>
@endauth

@push('scripts')
<script>
let qty = 1;
const maxQty = {{ $product->quantity }};

function changeQty(delta) {
    qty = Math.max(1, Math.min(maxQty, qty + delta));
    document.getElementById('qtyDisplay').textContent = qty;
    document.getElementById('selectedQty').value = qty;
    const mobileQty = document.getElementById('selectedQtyMobile');
    if (mobileQty) mobileQty.value = qty;
}

function changeImage(src, btn) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail-btn').forEach(b => {
        b.classList.remove('border-primary', 'ring-2', 'ring-primary/20');
        b.classList.add('border-gray-200');
    });
    btn.classList.remove('border-gray-200');
    btn.classList.add('border-primary', 'ring-2', 'ring-primary/20');
}

function setRating(rating) {
    document.getElementById('ratingInput').value = rating;
    document.querySelectorAll('.star-btn').forEach((btn, i) => {
        btn.classList.toggle('text-yellow-400', i < rating);
        btn.classList.toggle('text-gray-300', i >= rating);
    });
}

function buyNow() {
    const form = document.querySelector('form[action="{{ route("cart.add") }}"]');
    if (form) {
        form.submit();
        setTimeout(() => window.location.href = '{{ route("checkout.index") }}', 500);
    }
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->name }}',
            text: 'Check out this product!',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
}

// Initialize rating stars
setRating(5);
</script>
@endpush
@endsection
