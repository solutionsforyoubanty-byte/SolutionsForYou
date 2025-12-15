@extends('layouts.admin')
@section('title', 'Products')
@section('header', 'Products')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add Product</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">Image</th>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Category</th>
                <th class="px-6 py-3 text-left">Price</th>
                <th class="px-6 py-3 text-left">Stock</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($products as $product)
            <tr>
                <td class="px-6 py-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded">
                    @else
                        <div class="w-12 h-12 bg-gray-200 rounded"></div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="font-semibold">{{ $product->name }}</span>
                    @if($product->is_featured)<span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Featured</span>@endif
                </td>
                <td class="px-6 py-4">{{ $product->category->name }}</td>
                <td class="px-6 py-4">
                    @if($product->sale_price)
                        <span class="text-red-600">₹{{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-gray-400 line-through text-sm">₹{{ number_format($product->price, 2) }}</span>
                    @else
                        ₹{{ number_format($product->price, 2) }}
                    @endif
                </td>
                <td class="px-6 py-4">{{ $product->quantity }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No products</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
