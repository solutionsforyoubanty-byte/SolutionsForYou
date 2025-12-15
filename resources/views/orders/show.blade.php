@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 md:py-6 pb-20 md:pb-6">
    <!-- Back Button -->
    <div class="mb-4 md:mb-6">
        <a href="{{ route('orders.index') }}" class="text-primary hover:underline inline-flex items-center text-sm md:text-base">
            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow p-4 md:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                    <h2 class="font-bold text-base md:text-lg">Order #{{ $order->order_number }}</h2>
                    <span class="px-3 py-1 rounded text-xs md:text-sm font-medium self-start sm:self-auto
                        @if($order->status == 'delivered') bg-green-100 text-green-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @elseif($order->status == 'shipped') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Order Timeline -->
                <div class="flex items-center justify-between relative overflow-x-auto pb-2">
                    <div class="absolute top-4 left-0 right-0 h-1 bg-gray-200 -z-10"></div>
                    @php
                        $steps = ['pending' => 'Placed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
                        $currentStep = array_search($order->status, array_keys($steps));
                        if ($order->status == 'cancelled') $currentStep = -1;
                    @endphp
                    @foreach($steps as $key => $label)
                    @php $stepIndex = array_search($key, array_keys($steps)); @endphp
                    <div class="flex flex-col items-center min-w-[60px] md:min-w-[80px]">
                        <div class="w-6 h-6 md:w-8 md:h-8 rounded-full flex items-center justify-center text-xs md:text-sm font-medium
                            {{ $stepIndex <= $currentStep ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if($stepIndex < $currentStep)
                                <i class="fas fa-check text-xs"></i>
                            @else
                                {{ $stepIndex + 1 }}
                            @endif
                        </div>
                        <span class="text-[10px] md:text-xs mt-1 md:mt-2 text-center {{ $stepIndex <= $currentStep ? 'text-green-600 font-medium' : 'text-gray-500' }}">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-3 md:p-4 border-b">
                    <h3 class="font-medium text-sm md:text-base">Order Items ({{ $order->items->count() }})</h3>
                </div>
                @foreach($order->items as $item)
                <div class="p-3 md:p-4 {{ !$loop->last ? 'border-b' : '' }}">
                    <div class="flex gap-3 md:gap-4">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 md:w-20 md:h-20 object-contain flex-shrink-0">
                        @else
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 flex items-center justify-center flex-shrink-0 rounded">
                                <i class="fas fa-image text-xl md:text-2xl text-gray-300"></i>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-sm md:text-base line-clamp-2">{{ $item->product_name }}</h4>
                            <p class="text-xs md:text-sm text-gray-500 mt-1">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price) }}</p>
                            <p class="font-bold text-sm md:text-base mt-1">₹{{ number_format($item->total) }}</p>
                        </div>
                    </div>
                    @if($order->status == 'delivered' && $item->product)
                        <a href="{{ route('shop.show', $item->product->slug) }}#reviewForm" class="text-primary text-xs md:text-sm hover:underline mt-2 inline-block">
                            <i class="fas fa-star mr-1"></i> Write Review
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-4">
            <!-- Price Details -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-3 md:p-4 border-b">
                    <h3 class="font-medium text-gray-500 text-xs md:text-sm">PRICE DETAILS</h3>
                </div>
                <div class="p-3 md:p-4 space-y-2 md:space-y-3 text-xs md:text-sm">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span class="{{ $order->shipping_charge == 0 ? 'text-green-600' : '' }}">
                            {{ $order->shipping_charge == 0 ? 'FREE' : '₹' . number_format($order->shipping_charge) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>₹{{ number_format($order->tax) }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount {{ $order->coupon_code ? '(' . $order->coupon_code . ')' : '' }}</span>
                        <span>-₹{{ number_format($order->discount) }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="flex justify-between font-bold text-base md:text-lg">
                        <span>Total</span>
                        <span>₹{{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-lg shadow p-3 md:p-4">
                <h3 class="font-medium text-gray-500 text-xs md:text-sm mb-2 md:mb-3">PAYMENT</h3>
                <div class="flex items-center justify-between">
                    <span class="text-xs md:text-sm">{{ strtoupper($order->payment_method) }}</span>
                    <span class="px-2 py-1 rounded text-[10px] md:text-xs font-medium
                        @if($order->payment_status == 'paid') bg-green-100 text-green-800
                        @elseif($order->payment_status == 'failed') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                @if($order->razorpay_payment_id)
                    <p class="text-[10px] md:text-xs text-gray-500 mt-2 break-all">Payment ID: {{ $order->razorpay_payment_id }}</p>
                @endif
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow p-3 md:p-4">
                <h3 class="font-medium text-gray-500 text-xs md:text-sm mb-2 md:mb-3">DELIVERY ADDRESS</h3>
                <p class="font-medium text-sm md:text-base">{{ $order->name }}</p>
                <p class="text-xs md:text-sm text-gray-600 mt-1">{{ $order->address }}</p>
                <p class="text-xs md:text-sm text-gray-600">{{ $order->city }}, {{ $order->state }} - {{ $order->zip_code }}</p>
                <p class="text-xs md:text-sm text-gray-600 mt-2">
                    <i class="fas fa-phone mr-1"></i> {{ $order->phone }}
                </p>
            </div>

            <!-- Cancel Button (Desktop) -->
            @if($order->status == 'pending' || $order->status == 'processing')
            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')" class="hidden md:block">
                @csrf
                <button class="w-full border border-red-500 text-red-500 hover:bg-red-50 py-3 rounded font-medium transition-colors">
                    Cancel Order
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

<!-- Fixed Bottom Cancel Button (Mobile) -->
@if($order->status == 'pending' || $order->status == 'processing')
<div class="fixed bottom-16 left-0 right-0 bg-white border-t p-3 md:hidden z-40">
    <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
        @csrf
        <button class="w-full border border-red-500 text-red-500 hover:bg-red-50 py-3 rounded font-medium">
            <i class="fas fa-times mr-2"></i> Cancel Order
        </button>
    </form>
</div>
@endif
@endsection
