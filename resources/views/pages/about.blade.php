@extends('layouts.app')
@section('title', 'About Us')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero -->
    <div class="bg-gradient-to-r from-primary to-blue-600 text-white py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold font-display">About E-Shop</h1>
            <p class="mt-4 text-xl text-blue-100 max-w-2xl mx-auto">India's most trusted online shopping destination</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Story -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-2xl font-bold mb-4">Our Story</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Founded in 2020, E-Shop started with a simple mission: to make quality products accessible to everyone across India. What began as a small startup has now grown into one of the country's leading e-commerce platforms.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Today, we serve millions of customers with a catalog of over 10 million products across categories including electronics, fashion, home & living, and more. Our commitment to customer satisfaction, competitive pricing, and fast delivery has made us a household name.
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary">10M+</div>
                <p class="text-gray-500 mt-1">Products</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary">50M+</div>
                <p class="text-gray-500 mt-1">Customers</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary">19000+</div>
                <p class="text-gray-500 mt-1">Pin Codes</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary">5000+</div>
                <p class="text-gray-500 mt-1">Sellers</p>
            </div>
        </div>

        <!-- Values -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6">Our Values</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-primary"></i>
                    </div>
                    <h3 class="font-bold">Customer First</h3>
                    <p class="text-gray-500 text-sm mt-2">Every decision we make starts with our customers in mind</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-bold">Trust & Safety</h3>
                    <p class="text-gray-500 text-sm mt-2">100% genuine products with secure transactions</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-rocket text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="font-bold">Innovation</h3>
                    <p class="text-gray-500 text-sm mt-2">Constantly improving to serve you better</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-gradient-to-r from-secondary to-orange-500 rounded-xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-2">Start Shopping Today!</h2>
            <p class="text-orange-100 mb-4">Discover amazing deals on millions of products</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-white text-secondary px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                Shop Now <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
@endsection
