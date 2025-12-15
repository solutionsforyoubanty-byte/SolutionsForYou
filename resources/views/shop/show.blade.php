@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-6">
    <!-- Breadcrumb -->
    <div class="hidden md:flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-primary">{{ $product->category->name }}</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-dark line-clamp-1">{{ Str::limit($product->name, 30) }}</span>
    </div>

    <div class="grid lg:grid-cols-2 gap-4 md:gap-6">
        <!-- Left - Images -->
        <div class="flex flex-col-reverse md:flex-row gap-2 md:gap-4">
            <!-- Thumbnails -->
            <div class="flex md:flex-col gap-2 overflow-x-auto md:overflow-visible scrollbar-hide">
                @foreach($product->all_images as $index => $img)
                <button onclick="changeImage('{{ asset('storage/' . $img) }}')" 
                    class="w-14 h-14 md:w-16 md:h-16 border rounded p-1 hover:border-primary thumbnail-btn flex-shrink-0 {{ $index == 0 ? 'border-primary' : '' }}">
                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-contain">
                </button>
                @endforeach
            </div>

            <!-- Main Image -->
            <div class="flex-1 bg-white rounded shadow p-3 md:p-4 md:sticky md:top-20">
                <div class="relative">
                    @if($product->image)
                        <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="w-full h-64 md:h-96 object-contain">
                    @else
                        <div class="w-full h-64 md:h-96 bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-image text-4xl md:text-6xl text-gray-300"></i>
                        </div>
                    @endif

                    @if($product->discount_percent > 0)
                        <span class="absolute top-0 left-0 bg-green-600 text-white text-xs md:text-sm px-2 md:px-3 py-1 rounded-br">
                            {{ $product->discount_percent }}% off
                        </span>
                    @endif

                    @auth
                    <button onclick="toggleWishlist({{ $product->id }})" 
                        class="absolute top-0 right-0 w-8 h-8 md:w-10 md:h-10 bg-white rounded-full shadow flex items-center justify-center text-gray-400 hover:text-red-500 wishlist-btn-{{ $product->id }} {{ $product->isWishlisted() ? 'text-red-500' : '' }}">
                        <i class="fas fa-heart text-lg md:text-xl"></i>
                    </button>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Right - Details -->
        <div class="space-y-3 md:space-y-4">
            <div class="bg-white rounded shadow p-4 md:p-6">
                @if($product->brand)
                    <p class="text-xs md:text-sm text-gray-500">{{ $product->brand }}</p>
                @endif
                <h1 class="text-base md:text-xl font-medium text-dark mt-1">{{ $product->name }}</h1>

                <!-- Rating -->
                <div class="flex items-center gap-2 md:gap-3 mt-2 md:mt-3">
                    <span class="bg-green-600 text-white text-xs md:text-sm px-1.5 md:px-2 py-0.5 md:py-1 rounded flex items-center gap-1">
                        {{ number_format($product->avg_rating, 1) }} <i class="fas fa-star text-[10px] md:text-xs"></i>
                    </span>
                    <span class="text-gray-500 text-xs md:text-sm">{{ $product->reviews_count }} Ratings</span>
                </div>

                <!-- Price -->
                <div class="mt-3 md:mt-4">
                    <div class="flex flex-wrap items-baseline gap-2 md:gap-3">
                        <span class="text-2xl md:text-3xl font-bold text-dark">₹{{ number_format($product->current_price) }}</span>
                        @if($product->is_on_sale)
                            <span class="text-base md:text-xl text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                            <span class="text-sm md:text-lg text-green-600 font-medium">{{ $product->discount_percent }}% off</span>
                        @endif
                    </div>
                    <p class="text-xs md:text-sm text-gray-500 mt-1">inclusive of all taxes</p>
                </div>

                <!-- Offers -->
                <div class="mt-4 md:mt-6">
                    <h3 class="font-medium text-sm md:text-base mb-2 md:mb-3">Available Offers</h3>
                    <div class="space-y-1.5 md:space-y-2 text-xs md:text-sm">
                        <p class="flex items-start gap-2">
                            <i class="fas fa-tag text-green-600 mt-0.5"></i>
                            <span><strong>Bank Offer:</strong> 10% off on HDFC Cards</span>
                        </p>
                        <p class="flex items-start gap-2">
                            <i class="fas fa-tag text-green-600 mt-0.5"></i>
                            <span><strong>No Cost EMI:</strong> Starting ₹{{ number_format($product->current_price / 6) }}/month</span>
                        </p>
                    </div>
                </div>

                <!-- Delivery -->
                <div class="mt-4 md:mt-6 flex items-center gap-3 md:gap-4">
                    <i class="fas fa-truck text-primary text-lg md:text-xl"></i>
                    <div>
                        <p class="font-medium text-sm md:text-base">Free Delivery</p>
                        <p class="text-xs md:text-sm text-gray-500">By {{ now()->addDays(3)->format('D, d M') }}</p>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mt-4 md:mt-6">
                    <label class="font-medium text-sm md:text-base">Quantity:</label>
                    <div class="flex items-center gap-2 md:gap-3 mt-2">
                        <button onclick="changeQty(-1)" class="w-7 h-7 md:w-8 md:h-8 border rounded flex items-center justify-center hover:bg-gray-100">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span id="qtyDisplay" class="w-10 md:w-12 text-center font-medium">1</span>
                        <button onclick="changeQty(1)" class="w-7 h-7 md:w-8 md:h-8 border rounded flex items-center justify-center hover:bg-gray-100">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                        @if($product->quantity <= 5 && $product->quantity > 0)
                            <span class="text-red-500 text-xs md:text-sm ml-2 md:ml-4">Only {{ $product->quantity }} left!</span>
                        @elseif($product->quantity == 0)
                            <span class="text-red-500 text-xs md:text-sm ml-2 md:ml-4">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Fixed on Mobile -->
            <div class="fixed md:relative bottom-0 left-0 right-0 md:bottom-auto bg-white md:bg-transparent p-3 md:p-0 border-t md:border-0 z-30 flex gap-2 md:gap-4 safe-bottom">
                @auth
                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="selectedQty" value="1">
                    <button type="submit" class="w-full bg-secondary hover:bg-orange-600 text-white py-3 md:py-4 rounded font-medium text-sm md:text-lg {{ $product->quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->quantity == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart mr-2"></i> ADD TO CART
                    </button>
                </form>
                <button onclick="buyNow()" class="flex-1 bg-secondary hover:bg-orange-600 text-white py-3 md:py-4 rounded font-medium text-sm md:text-lg {{ $product->quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->quantity == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-bolt mr-2"></i> BUY NOW
                </button>
                @else
                <a href="{{ route('login') }}" class="flex-1 bg-primary hover:bg-blue-700 text-white py-3 md:py-4 rounded font-medium text-sm md:text-lg text-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> LOGIN TO BUY
                </a>
                @endauth
            </div>
            <div class="md:hidden h-16"></div> <!-- Spacer for fixed buttons -->

            <!-- Description -->
            @if($product->description)
            <div class="bg-white rounded shadow p-4 md:p-6">
                <h3 class="font-medium text-sm md:text-base mb-2 md:mb-3">Description</h3>
                <p class="text-gray-600 text-xs md:text-sm leading-relaxed">{{ $product->description }}</p>
            </div>
            @endif

            <!-- Reviews -->
            <div class="bg-white rounded shadow p-4 md:p-6">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <h3 class="font-medium text-sm md:text-base">Ratings & Reviews</h3>
                    @auth
                    <button onclick="document.getElementById('reviewForm').classList.toggle('hidden')" class="text-primary text-xs md:text-sm font-medium">
                        Write Review
                    </button>
                    @endauth
                </div>

                @auth
                <form action="{{ route('reviews.store', $product) }}" method="POST" id="reviewForm" class="hidden mb-4 md:mb-6 p-3 md:p-4 bg-gray-50 rounded">
                    @csrf
                    <div class="mb-3 md:mb-4">
                        <label class="block text-xs md:text-sm font-medium mb-2">Rating</label>
                        <div class="flex gap-1 md:gap-2" id="starRating">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="text-xl md:text-2xl text-gray-300 hover:text-yellow-400 star-btn">
                                <i class="fas fa-star"></i>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="5">
                    </div>
                    <div class="mb-3 md:mb-4">
                        <input type="text" name="title" placeholder="Review Title" class="w-full border rounded px-3 py-2 text-xs md:text-sm">
                    </div>
                    <div class="mb-3 md:mb-4">
                        <textarea name="comment" rows="3" placeholder="Write your review..." class="w-full border rounded px-3 py-2 text-xs md:text-sm"></textarea>
                    </div>
                    <button type="submit" class="bg-primary text-white px-4 md:px-6 py-2 rounded text-xs md:text-sm font-medium">Submit</button>
                </form>
                @endauth

                <div class="space-y-3 md:space-y-4">
                    @forelse($product->reviews()->with('user')->latest()->take(5)->get() as $review)
                    <div class="border-b pb-3 md:pb-4">
                        <div class="flex items-center gap-2">
                            <span class="bg-green-600 text-white text-[10px] md:text-xs px-1.5 py-0.5 rounded flex items-center gap-1">
                                {{ $review->rating }} <i class="fas fa-star text-[8px]"></i>
                            </span>
                            @if($review->title)
                                <span class="font-medium text-xs md:text-sm">{{ $review->title }}</span>
                            @endif
                        </div>
                        @if($review->comment)
                            <p class="text-xs md:text-sm text-gray-600 mt-1 md:mt-2">{{ $review->comment }}</p>
                        @endif
                        <p class="text-[10px] md:text-xs text-gray-400 mt-1 md:mt-2">{{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}</p>
                    </div>
                    @empty
                    <p class="text-gray-500 text-xs md:text-sm">No reviews yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($related->count())
    <div class="mt-4 md:mt-8 bg-white rounded shadow p-3 md:p-6">
        <h2 class="text-base md:text-xl font-bold mb-3 md:mb-4">Similar Products</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 md:gap-4">
            @foreach($related as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
let qty = 1;
const maxQty = {{ $product->quantity }};

function changeQty(delta) {
    qty = Math.max(1, Math.min(maxQty, qty + delta));
    document.getElementById('qtyDisplay').textContent = qty;
    document.getElementById('selectedQty').value = qty;
}

function changeImage(src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail-btn').forEach(btn => btn.classList.remove('border-primary'));
    event.target.closest('.thumbnail-btn').classList.add('border-primary');
}

function setRating(rating) {
    document.getElementById('ratingInput').value = rating;
    document.querySelectorAll('.star-btn').forEach((btn, i) => {
        btn.classList.toggle('text-yellow-400', i < rating);
        btn.classList.toggle('text-gray-300', i >= rating);
    });
}

function buyNow() {
    document.querySelector('form[action="{{ route("cart.add") }}"]').submit();
    setTimeout(() => window.location.href = '{{ route("checkout.index") }}', 500);
}

setRating(5);
</script>
@endpush
@endsection
