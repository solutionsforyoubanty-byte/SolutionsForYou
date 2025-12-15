<div class="bg-white border rounded group hover:shadow-xl transition-all duration-300">
    <a href="{{ route('shop.show', $product->slug) }}" class="block p-2 md:p-3">
        <div class="relative overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                    class="w-full h-28 md:h-44 object-contain group-hover:scale-110 transition-transform duration-300">
            @else
                <div class="w-full h-28 md:h-44 bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-image text-2xl md:text-4xl text-gray-300"></i>
                </div>
            @endif
            
            @if($product->discount_percent > 0)
                <span class="absolute top-0 left-0 bg-green-600 text-white text-[10px] md:text-xs px-1.5 md:px-2 py-0.5">
                    {{ $product->discount_percent }}% off
                </span>
            @endif

            @auth
                <button onclick="event.preventDefault(); toggleWishlist({{ $product->id }})" 
                    class="absolute top-0 right-0 w-6 h-6 md:w-8 md:h-8 flex items-center justify-center text-gray-400 hover:text-red-500 wishlist-btn-{{ $product->id }} {{ $product->isWishlisted() ? 'text-red-500' : '' }}">
                    <i class="fas fa-heart text-sm md:text-base"></i>
                </button>
            @endauth
        </div>
        
        <div class="mt-2 md:mt-3">
            <p class="text-[10px] md:text-xs text-gray-500 uppercase truncate">{{ $product->category->name ?? '' }}</p>
            <h3 class="text-xs md:text-sm font-medium text-dark mt-0.5 md:mt-1 line-clamp-2 h-8 md:h-10">{{ $product->name }}</h3>
            
            <div class="flex items-center gap-1 mt-1 md:mt-2">
                <span class="bg-green-600 text-white text-[10px] md:text-xs px-1 md:px-1.5 py-0.5 rounded flex items-center gap-0.5">
                    {{ number_format($product->avg_rating, 1) }} <i class="fas fa-star text-[6px] md:text-[8px]"></i>
                </span>
                <span class="text-[10px] md:text-xs text-gray-500">({{ $product->reviews_count }})</span>
            </div>
            
            <div class="mt-1 md:mt-2 flex flex-wrap items-baseline gap-1">
                <span class="text-sm md:text-lg font-bold text-dark">₹{{ number_format($product->current_price) }}</span>
                @if($product->is_on_sale)
                    <span class="text-[10px] md:text-sm text-gray-400 line-through">₹{{ number_format($product->price) }}</span>
                @endif
            </div>

            @if($product->quantity <= 5 && $product->quantity > 0)
                <p class="text-[10px] md:text-xs text-red-500 mt-0.5 md:mt-1"><i class="fas fa-fire"></i> Only {{ $product->quantity }} left!</p>
            @endif
        </div>
    </a>
    
    @auth
    <div class="px-2 pb-2 md:px-3 md:pb-3">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="w-full bg-secondary hover:bg-orange-600 text-white py-1.5 md:py-2 rounded text-[10px] md:text-sm font-medium transition {{ $product->quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->quantity == 0 ? 'disabled' : '' }}>
                <i class="fas fa-shopping-cart mr-1"></i> 
                {{ $product->quantity == 0 ? 'Out of Stock' : 'Add to Cart' }}
            </button>
        </form>
    </div>
    @else
    <div class="px-2 pb-2 md:px-3 md:pb-3">
        <a href="{{ route('login') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-1.5 md:py-2 rounded text-[10px] md:text-sm font-medium text-center transition">
            Login to Buy
        </a>
    </div>
    @endauth
</div>
