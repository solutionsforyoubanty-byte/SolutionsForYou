@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-6">
    <h1 class="text-lg md:text-2xl font-bold mb-4 md:mb-6">My Orders</h1>

    @if($orders->count())
    <div class="space-y-3 md:space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-lg shadow">
            <!-- Order Header -->
            <div class="p-3 md:p-4 border-b bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-2">
                <div class="flex flex-wrap items-center gap-2 md:gap-4 text-xs md:text-sm">
                    <span class="text-gray-500">#{{ $order->order_number }}</span>
                    <span class="text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex items-center gap-2 md:gap-3">
                    <span class="px-2 py-1 rounded text-[10px] md:text-sm font-medium
                        @if($order->status == 'delivered') bg-green-100 text-green-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @elseif($order->status == 'shipped') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    <a href="{{ route('orders.show', $order) }}" class="text-primary text-xs md:text-sm font-medium hover:underline">View Details</a>
                </div>
            </div>

            <!-- Delivery Date Banner -->
            @if($order->status != 'cancelled' && $order->status != 'delivered')
            <div class="px-3 md:px-4 py-2 bg-green-50 border-b border-green-100 flex items-center gap-2">
                <i class="fas fa-truck text-green-600 text-sm"></i>
                <span class="text-xs md:text-sm text-green-700">
                    @php
                        $deliveryDays = $order->status == 'shipped' ? 2 : ($order->status == 'processing' ? 4 : 5);
                        $deliveryDate = $order->created_at->addDays($deliveryDays);
                    @endphp
                    Expected by <span class="font-semibold">{{ $deliveryDate->format('D, d M') }}</span>
                    @if($order->status == 'shipped')
                        - On the way!
                    @endif
                </span>
            </div>
            @elseif($order->status == 'delivered')
            <div class="px-3 md:px-4 py-2 bg-green-50 border-b border-green-100 flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                <span class="text-xs md:text-sm text-green-700">Delivered on <span class="font-semibold">{{ $order->updated_at->format('D, d M Y') }}</span></span>
            </div>
            @elseif($order->status == 'cancelled')
            <div class="px-3 md:px-4 py-2 bg-red-50 border-b border-red-100 flex items-center gap-2">
                <i class="fas fa-times-circle text-red-600 text-sm"></i>
                <span class="text-xs md:text-sm text-red-700">Order cancelled - Refund in 5-7 days</span>
            </div>
            @endif

            <!-- Order Items -->
            <div class="p-3 md:p-4">
                @foreach($order->items->take(2) as $item)
                <div class="flex gap-3 md:gap-4 {{ !$loop->last ? 'mb-3 md:mb-4 pb-3 md:pb-4 border-b' : '' }}">
                    @if($item->product && $item->product->image)
                        <a href="{{ route('shop.show', $item->product->slug) }}">
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 md:w-20 md:h-20 object-cover rounded">
                        </a>
                    @else
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 flex items-center justify-center rounded">
                            <i class="fas fa-image text-xl md:text-2xl text-gray-300"></i>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium text-xs md:text-base line-clamp-2">{{ $item->product_name }}</h4>
                        <p class="text-[10px] md:text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                        <p class="font-medium text-sm md:text-base mt-1">₹{{ number_format($item->total) }}</p>
                    </div>
                </div>
                @endforeach
                @if($order->items->count() > 2)
                    <p class="text-xs md:text-sm text-gray-500 mt-2">+ {{ $order->items->count() - 2 }} more items</p>
                @endif
            </div>

            <!-- Order Footer with Actions -->
            <div class="p-3 md:p-4 border-t bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <div>
                    <span class="text-xs md:text-sm text-gray-500">Total:</span>
                    <span class="font-bold text-sm md:text-lg ml-1 md:ml-2">₹{{ number_format($order->total) }}</span>
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <!-- Help Button -->
                    <a href="{{ route('pages.contact') }}" class="text-gray-600 text-xs md:text-sm hover:text-primary flex items-center gap-1">
                        <i class="fas fa-headset"></i> <span class="hidden md:inline">Help</span>
                    </a>
                    
                    @if($order->status == 'delivered')
                        <!-- Return/Exchange for delivered orders -->
                        <a href="{{ route('pages.returns') }}" class="text-orange-600 text-xs md:text-sm font-medium hover:underline flex items-center gap-1">
                            <i class="fas fa-undo"></i> Return
                        </a>
                    @endif

                    @if($order->status == 'pending' || $order->status == 'processing')
                        <!-- Cancel Order -->
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')" class="ml-auto md:ml-0">
                            @csrf
                            <button class="text-red-600 text-xs md:text-sm font-medium hover:underline flex items-center gap-1">
                                <i class="fas fa-times-circle"></i> Cancel
                            </button>
                        </form>
                    @endif

                    <!-- View Details -->
                    <a href="{{ route('orders.show', $order) }}" class="bg-primary text-white px-3 md:px-4 py-1.5 md:py-2 rounded text-xs md:text-sm font-medium hover:bg-blue-700 ml-auto md:ml-0">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 md:mt-6">{{ $orders->links() }}</div>
    @else
    <div class="bg-white rounded-lg shadow p-8 md:p-12 text-center">
        <i class="fas fa-box-open text-4xl md:text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-lg md:text-xl font-medium text-gray-600">No orders yet!</h3>
        <p class="text-sm text-gray-500 mt-2">Start shopping now.</p>
        <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-primary text-white px-6 md:px-8 py-2.5 md:py-3 rounded-lg font-medium text-sm md:text-base hover:bg-blue-700 transition">
            <i class="fas fa-shopping-bag mr-2"></i> Shop Now
        </a>
    </div>
    @endif
</div>
@endsection
