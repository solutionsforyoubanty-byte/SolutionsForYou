@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-6">
    <h1 class="text-lg md:text-2xl font-bold mb-4 md:mb-6">My Orders</h1>

    @if($orders->count())
    <div class="space-y-3 md:space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded shadow">
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
                    <a href="{{ route('orders.show', $order) }}" class="text-primary text-xs md:text-sm font-medium hover:underline">View</a>
                </div>
            </div>
            <div class="p-3 md:p-4">
                @foreach($order->items->take(2) as $item)
                <div class="flex gap-3 md:gap-4 {{ !$loop->last ? 'mb-3 md:mb-4 pb-3 md:pb-4 border-b' : '' }}">
                    @if($item->product && $item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 md:w-20 md:h-20 object-contain">
                    @else
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 flex items-center justify-center">
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
            <div class="p-3 md:p-4 border-t bg-gray-50 flex justify-between items-center">
                <div>
                    <span class="text-xs md:text-sm text-gray-500">Total:</span>
                    <span class="font-bold text-sm md:text-lg ml-1 md:ml-2">₹{{ number_format($order->total) }}</span>
                </div>
                @if($order->status == 'pending' || $order->status == 'processing')
                <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Cancel this order?')">
                    @csrf
                    <button class="text-red-600 text-xs md:text-sm font-medium hover:underline">Cancel</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 md:mt-6">{{ $orders->links() }}</div>
    @else
    <div class="bg-white rounded shadow p-8 md:p-12 text-center">
        <i class="fas fa-box-open text-4xl md:text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-lg md:text-xl font-medium text-gray-600">No orders yet!</h3>
        <p class="text-sm text-gray-500 mt-2">Start shopping now.</p>
        <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-primary text-white px-6 md:px-8 py-2.5 md:py-3 rounded font-medium text-sm md:text-base">Shop Now</a>
    </div>
    @endif
</div>
@endsection
