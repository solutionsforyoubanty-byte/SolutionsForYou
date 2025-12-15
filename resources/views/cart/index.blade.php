@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-6">
    <h1 class="text-lg md:text-2xl font-bold mb-4 md:mb-6">Shopping Cart</h1>

    @if($carts->count())
    <div class="grid lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded shadow">
                @foreach($carts as $cart)
                <div class="p-3 md:p-4 {{ !$loop->last ? 'border-b' : '' }}">
                    <div class="flex gap-3 md:gap-4">
                        <a href="{{ route('shop.show', $cart->product->slug) }}" class="flex-shrink-0">
                            @if($cart->product->image)
                                <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-20 h-20 md:w-24 md:h-24 object-contain">
                            @else
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-image text-xl md:text-2xl text-gray-300"></i>
                                </div>
                            @endif
                        </a>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('shop.show', $cart->product->slug) }}" class="font-medium text-sm md:text-base hover:text-primary line-clamp-2">
                                {{ $cart->product->name }}
                            </a>
                            <p class="text-xs md:text-sm text-gray-500">{{ $cart->product->category->name ?? '' }}</p>
                            
                            <div class="flex flex-wrap items-baseline gap-1 md:gap-2 mt-1 md:mt-2">
                                <span class="text-base md:text-lg font-bold">₹{{ number_format($cart->product->current_price) }}</span>
                                @if($cart->product->is_on_sale)
                                    <span class="text-xs md:text-sm text-gray-400 line-through">₹{{ number_format($cart->product->price) }}</span>
                                    <span class="text-xs md:text-sm text-green-600">{{ $cart->product->discount_percent }}% off</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 md:gap-4 mt-2 md:mt-3">
                                <form action="{{ route('cart.update', $cart) }}" method="POST" class="flex items-center gap-1 md:gap-2">
                                    @csrf @method('PATCH')
                                    <button type="button" onclick="updateQty(this, -1)" class="w-6 h-6 md:w-7 md:h-7 border rounded flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-minus text-[10px] md:text-xs"></i>
                                    </button>
                                    <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->quantity }}" 
                                        class="w-10 md:w-12 text-center border rounded py-1 text-xs md:text-sm qty-input" onchange="this.form.submit()">
                                    <button type="button" onclick="updateQty(this, 1)" class="w-6 h-6 md:w-7 md:h-7 border rounded flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-plus text-[10px] md:text-xs"></i>
                                    </button>
                                </form>

                                <form action="{{ route('cart.remove', $cart) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-500 hover:text-red-600 text-xs md:text-sm font-medium">REMOVE</button>
                                </form>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-bold text-sm md:text-lg">₹{{ number_format($cart->total) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="bg-white rounded shadow mt-3 md:mt-4 p-3 md:p-4 flex justify-between items-center">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline text-xs md:text-sm">
                        <i class="fas fa-trash mr-1"></i> Clear Cart
                    </button>
                </form>
                <a href="{{ route('shop.index') }}" class="text-primary hover:underline text-xs md:text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Continue Shopping
                </a>
            </div>
        </div>

        <!-- Price Details -->
        <div>
            <div class="bg-white rounded shadow sticky top-20">
                <div class="p-3 md:p-4 border-b">
                    <h3 class="font-medium text-gray-500 text-xs md:text-sm">PRICE DETAILS</h3>
                </div>
                <div class="p-3 md:p-4 space-y-2 md:space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span>Price ({{ $carts->count() }} items)</span>
                        <span>₹{{ number_format($total) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Delivery</span>
                        <span class="{{ $total >= 499 ? 'text-green-600' : '' }}">
                            {{ $total >= 499 ? 'FREE' : '₹40' }}
                        </span>
                    </div>
                    <hr>
                    <div class="flex justify-between font-bold text-base md:text-lg">
                        <span>Total</span>
                        <span>₹{{ number_format($total + ($total >= 499 ? 0 : 40)) }}</span>
                    </div>
                </div>
                <div class="p-3 md:p-4 border-t">
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-secondary hover:bg-orange-600 text-white py-2.5 md:py-3 rounded font-medium text-center text-sm md:text-base">
                        PLACE ORDER
                    </a>
                </div>
                <div class="p-3 md:p-4 border-t bg-gray-50">
                    <p class="text-[10px] md:text-xs text-gray-500 flex items-center gap-2">
                        <i class="fas fa-shield-alt text-gray-400"></i>
                        Safe and Secure Payments
                    </p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded shadow p-8 md:p-12 text-center">
        <i class="fas fa-shopping-cart text-4xl md:text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-lg md:text-xl font-medium text-gray-600">Your cart is empty!</h3>
        <p class="text-sm text-gray-500 mt-2">Add items to it now.</p>
        <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-primary text-white px-6 md:px-8 py-2.5 md:py-3 rounded font-medium text-sm md:text-base">Shop Now</a>
    </div>
    @endif
</div>

@push('scripts')
<script>
function updateQty(btn, delta) {
    const input = btn.parentElement.querySelector('.qty-input');
    const newVal = parseInt(input.value) + delta;
    if (newVal >= 1 && newVal <= parseInt(input.max)) {
        input.value = newVal;
        input.form.submit();
    }
}
</script>
@endpush
@endsection
