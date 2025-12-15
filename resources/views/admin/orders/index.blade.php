@extends('layouts.admin')
@section('title', 'Orders')
@section('header', 'Orders')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">Order #</th>
                <th class="px-6 py-3 text-left">Customer</th>
                <th class="px-6 py-3 text-left">Total</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Payment</th>
                <th class="px-6 py-3 text-left">Date</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($orders as $order)
            <tr>
                <td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td>
                <td class="px-6 py-4">
                    <div>{{ $order->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                </td>
                <td class="px-6 py-4">₹{{ number_format($order->total, 2) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm 
                        @if($order->status == 'delivered') bg-green-100 text-green-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @elseif($order->status == 'shipped') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm 
                        @if($order->payment_status == 'paid') bg-green-100 text-green-800
                        @elseif($order->payment_status == 'failed') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No orders</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
