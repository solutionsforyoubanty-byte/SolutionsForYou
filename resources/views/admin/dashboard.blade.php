@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Products</p>
                <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-box text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Categories</p>
                <p class="text-2xl font-bold">{{ $stats['total_categories'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-tags text-green-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Orders</p>
                <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-bag text-purple-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Users</p>
                <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-indigo-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-emerald-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Revenue</p>
                <p class="text-2xl font-bold text-emerald-600">₹{{ number_format($stats['total_revenue']) }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-rupee-sign text-emerald-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="font-bold">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-primary text-sm hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($recent_orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary hover:underline text-sm">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $order->user->name }}</td>
                        <td class="px-4 py-3 text-sm font-medium">₹{{ number_format($order->total) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @elseif($order->status == 'shipped') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No orders yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 p-4 border rounded-lg hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-plus text-blue-500"></i>
                    </div>
                    <span class="font-medium">Add Product</span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-3 p-4 border rounded-lg hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-folder-plus text-green-500"></i>
                    </div>
                    <span class="font-medium">Add Category</span>
                </a>
                <a href="{{ route('admin.coupons.create') }}" class="flex items-center gap-3 p-4 border rounded-lg hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-purple-500"></i>
                    </div>
                    <span class="font-medium">Add Coupon</span>
                </a>
                <a href="{{ route('admin.orders.index') }}?status=pending" class="flex items-center gap-3 p-4 border rounded-lg hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-500"></i>
                    </div>
                    <span class="font-medium">Pending Orders</span>
                </a>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @php $lowStock = \App\Models\Product::where('quantity', '<=', 5)->where('quantity', '>', 0)->take(5)->get(); @endphp
        @if($lowStock->count())
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-yellow-500"></i> Low Stock Alert
            </h3>
            <div class="space-y-3">
                @foreach($lowStock as $product)
                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded">
                    <span class="text-sm">{{ $product->name }}</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $product->quantity }} left</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
