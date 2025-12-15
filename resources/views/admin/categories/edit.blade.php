@extends('layouts.admin')
@section('title', 'Edit Category')
@section('header', 'Edit Category')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Image</label>
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" class="w-24 h-24 object-cover rounded mb-2">
                @endif
                <input type="file" name="image" class="w-full border rounded px-3 py-2" accept="image/*">
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" {{ $category->is_active ? 'checked' : '' }} class="mr-2">
                    <span>Active</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update</button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
