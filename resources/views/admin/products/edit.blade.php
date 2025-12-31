@extends('layouts.admin')
@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full border rounded px-3 py-2" placeholder="e.g. Samsung, Nike">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Category *</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border rounded px-3 py-2" placeholder="Product SKU">
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Price (₹) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" class="w-full border rounded px-3 py-2 @error('price') border-red-500 @enderror" required>
                    @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Sale Price (₹)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="w-full border rounded px-3 py-2 @error('quantity') border-red-500 @enderror" required>
                    @error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Main Image</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded border">
                    </div>
                @endif
                <input type="file" name="image" class="w-full border rounded px-3 py-2" accept="image/*">
                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Additional Images (Thumbnails)</label>
                @if($product->images && count($product->images) > 0)
                    <div class="flex gap-2 mb-2 flex-wrap">
                        @foreach($product->images as $index => $img)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $img) }}" class="w-20 h-20 object-cover rounded border">
                                <label class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer text-xs">
                                    <input type="checkbox" name="remove_images[]" value="{{ $index }}" class="hidden">
                                    <i class="fas fa-times"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mb-2">Click X to mark images for removal</p>
                @endif
                <input type="file" name="images[]" multiple class="w-full border rounded px-3 py-2" accept="image/*">
                <p class="text-xs text-gray-500 mt-1">Select multiple images to add to gallery (max 5 total)</p>
            </div>

            <div class="mb-4 flex gap-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="mr-2">
                    <span>Active</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="mr-2">
                    <span>Featured</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    <i class="fas fa-save mr-1"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
