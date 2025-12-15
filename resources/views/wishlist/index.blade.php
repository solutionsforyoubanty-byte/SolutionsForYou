@extends('layouts.app')
@section('title', 'My Wishlist')

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-6">
    <h1 class="text-lg md:text-2xl font-bold mb-4 md:mb-6">My Wishlist ({{ $wishlists->total() }})</h1>

    @if($wishlists->count())
    <div class="grid grid-cols-2 md:grid-cols-5 gap-2 md:gap-4">
        @foreach($wishlists as $wishlist)
        <div class="bg-white border rounded group hover:shadow-xl transition-all duration-300">
            <a href="{{ route('shop.show', $wishlist->product->slug) }}" class="block p-2 md:p-3">
                <div class="relative overflow-hidden">
                    @if($wishlist->product->image)
                        <img src="{{ asset('storage/' . $wishlist->product->image) }}" 
                            class="w-full h-28 md:h-44 object-contain group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-full h-28 md:h-44 bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-image text-2xl md:text-4xl text-gray-300"></i>
                        </div>
                    @endif
                    
                    @if($wishlist->product->discount_percent > 0)
                        <span class="absolute top-0 left-0 bg-green-600 text-white text-[10px] md:text-xs px-1.5 md:px-2 py-0.5">
                            {{ $wishlist->product->discount_percent }}% off
                        </span>
                    @endif
                </div>
                
                <div class="mt-2 md:mt-3">
                    <p class="text-[10px] md:text-xs text-gray-500 uppercase truncate">{{ $wishlist->product->category->name ?? '' }}</p>
                    <h3 class="text-xs md:text-sm font-medium text-dark mt-0.5 md:mt-1 line-clamp-2 h-8 md:h-10">{{ $wishlist->product->name }}</h3>
                    
                    <div class="mt-1 md:mt-2 flex flex-wrap items-baseline gap-1">
                        <span class="text-sm md:text-lg font-bold text-dark">₹{{ number_format($wishlist->product->current_price) }}</span>
                        @if($wishlist->product->is_on_sale)
                            <span class="text-[10px] md:text-sm text-gray-400 line-through">₹{{ number_format($wishlist->product->price) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            
            <div class="px-2 pb-2 md:px-3 md:pb-3 space-y-1.5 md:space-y-2">
                <form action="{{ route('wishlist.move', $wishlist) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-secondary hover:bg-orange-600 text-white py-1.5 md:py-2 rounded text-[10px] md:text-sm font-medium transition">
                        <i class="fas fa-shopping-cart mr-1"></i> Move to Cart
                    </button>
                </form>
                <form action="{{ route('wishlist.toggle') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                    <button type="submit" class="w-full border border-gray-300 hover:border-red-500 hover:text-red-500 text-gray-600 py-1.5 md:py-2 rounded text-[10px] md:text-sm font-medium transition">
                        <i class="fas fa-trash mr-1"></i> Remove
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 md:mt-6">{{ $wishlists->links() }}</div>
    @else
    <div class="bg-white rounded shadow p-8 md:p-12 text-center">
        <i class="fas fa-heart text-4xl md:text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-lg md:text-xl font-medium text-gray-600">Your wishlist is empty!</h3>
        <p class="text-sm text-gray-500 mt-2">Save items you like.</p>
        <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-primary text-white px-6 md:px-8 py-2.5 md:py-3 rounded font-medium text-sm md:text-base">Explore</a>
    </div>
    @endif
</div>
@endsection
