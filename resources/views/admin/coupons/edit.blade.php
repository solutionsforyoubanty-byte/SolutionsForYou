@extends('layouts.admin')
@section('title', 'Edit Coupon')
@section('header', 'Edit Coupon')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2">Coupon Code</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="w-full border rounded px-3 py-2 uppercase @error('code') border-red-500 @enderror" required>
                    @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Discount Type</label>
                    <select name="type" class="w-full border rounded px-3 py-2">
                        <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Discount Value</label>
                    <input type="number" name="value" value="{{ old('value', $coupon->value) }}" step="0.01" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Max Discount (for %)</label>
                    <input type="number" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}" step="0.01" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Minimum Order Amount</label>
                    <input type="number" name="min_order" value="{{ old('min_order', $coupon->min_order) }}" step="0.01" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" class="w-full border rounded px-3 py-2">
                    <p class="text-xs text-gray-500 mt-1">Used: {{ $coupon->used_count }} times</p>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Valid From</label>
                    <input type="date" name="valid_from" value="{{ old('valid_from', $coupon->valid_from->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Valid Until</label>
                    <input type="date" name="valid_until" value="{{ old('valid_until', $coupon->valid_until->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" {{ $coupon->is_active ? 'checked' : '' }} class="mr-2">
                        <span>Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-4 mt-6">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update</button>
                <a href="{{ route('admin.coupons.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
