@extends('layouts.admin')
@section('title', 'Coupons')
@section('header', 'Coupons')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.coupons.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add Coupon</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">Code</th>
                <th class="px-6 py-3 text-left">Type</th>
                <th class="px-6 py-3 text-left">Value</th>
                <th class="px-6 py-3 text-left">Min Order</th>
                <th class="px-6 py-3 text-left">Usage</th>
                <th class="px-6 py-3 text-left">Valid Until</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($coupons as $coupon)
            <tr>
                <td class="px-6 py-4 font-mono font-bold">{{ $coupon->code }}</td>
                <td class="px-6 py-4">{{ ucfirst($coupon->type) }}</td>
                <td class="px-6 py-4">
                    {{ $coupon->type == 'percent' ? $coupon->value . '%' : '₹' . number_format($coupon->value) }}
                    @if($coupon->max_discount)
                        <span class="text-xs text-gray-500">(Max: ₹{{ number_format($coupon->max_discount) }})</span>
                    @endif
                </td>
                <td class="px-6 py-4">₹{{ number_format($coupon->min_order) }}</td>
                <td class="px-6 py-4">
                    {{ $coupon->used_count }}{{ $coupon->usage_limit ? '/' . $coupon->usage_limit : '' }}
                </td>
                <td class="px-6 py-4 text-sm">{{ $coupon->valid_until->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    @if($coupon->is_active && $coupon->valid_until >= now())
                        <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 py-1 rounded text-sm bg-red-100 text-red-800">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Delete this coupon?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">No coupons</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $coupons->links() }}</div>
@endsection
