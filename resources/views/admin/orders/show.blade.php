@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('header', 'Order Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:underline">&larr; Back to Orders</a>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <!-- Order Items -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Order Items</h2>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Qty</th>
                        <th class="px-4 py-2 text-left">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->product_name }}</td>
                        <td class="px-4 py-3">₹{{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3">₹{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 text-right">
                <p>Subtotal: ₹{{ number_format($order->subtotal, 2) }}</p>
                <p>Tax: ₹{{ number_format($order->tax, 2) }}</p>
                <p class="text-xl font-bold">Total: ₹{{ number_format($order->total, 2) }}</p>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
            <div class="text-gray-600">
                <p class="font-semibold text-gray-800">{{ $order->name }}</p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}, {{ $order->state }} - {{ $order->zip_code }}</p>
                <p>Phone: {{ $order->phone }}</p>
                <p>Email: {{ $order->email }}</p>
                @if($order->notes)
                    <p class="mt-2 text-sm"><strong>Notes:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Info & Actions -->
    <div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Order #{{ $order->order_number }}</h2>
            <div class="space-y-2 text-sm">
                <p><span class="text-gray-500">Date:</span> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                <p><span class="text-gray-500">Customer:</span> {{ $order->user->name }}</p>
                <p><span class="text-gray-500">Payment Method:</span> {{ strtoupper($order->payment_method) }}</p>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold mb-4">Update Order Status</h3>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" class="w-full border rounded px-3 py-2 mb-3">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Update Status</button>
            </form>
        </div>

        <!-- Update Payment -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4">Update Payment Status</h3>
            <form action="{{ route('admin.orders.payment', $order) }}" method="POST">
                @csrf @method('PATCH')
                <select name="payment_status" class="w-full border rounded px-3 py-2 mb-3">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Update Payment</button>
            </form>
        </div>
    </div>
</div>
@endsection
