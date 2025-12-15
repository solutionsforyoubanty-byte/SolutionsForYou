@extends('layouts.admin')
@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Price (₹)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" class="w-full border rounded px-3 py-2 @error('price') border-red-500 @enderror" required>
                    @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Sale Price (₹)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="w-full border rounded px-3 py-2 @error('quantity') border-red-500 @enderror" required>
                @error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Image</label>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded mb-2">
                @endif
                <input type="file" name="image" class="w-full border rounded px-3 py-2" accept="image/*">
            </div>

            <div class="mb-4 flex gap-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" {{ $product->is_active ? 'checked' : '' }} class="mr-2">
                    <span>Active</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" {{ $product->is_featured ? 'checked' : '' }} class="mr-2">
                    <span>Featured</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update</button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
