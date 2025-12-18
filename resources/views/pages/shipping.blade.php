@extends('layouts.app')
@section('title', 'Shipping Information')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold font-display">Shipping Information</h1>
            <p class="mt-3 text-blue-100">Fast & reliable delivery across India</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Delivery Options -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-6">Delivery Options</h2>
            <div class="space-y-4">
                <div class="border rounded-lg p-4 flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-truck text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">Standard Delivery</h3>
                        <p class="text-sm text-gray-500">3-5 business days</p>
                        <p class="text-sm text-green-600 mt-1">FREE on orders above ₹499</p>
                    </div>
                </div>
                <div class="border rounded-lg p-4 flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shipping-fast text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">Express Delivery</h3>
                        <p class="text-sm text-gray-500">1-2 business days</p>
                        <p class="text-sm text-gray-600 mt-1">₹99 extra (select pin codes)</p>
                    </div>
                </div>
                <div class="border rounded-lg p-4 flex items-start gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-bolt text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">Same Day Delivery</h3>
                        <p class="text-sm text-gray-500">Order before 12 PM</p>
                        <p class="text-sm text-gray-600 mt-1">Available in select cities</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coverage -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-4">Delivery Coverage</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">19000+</div>
                    <p class="text-sm text-gray-500">Pin Codes</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">28</div>
                    <p class="text-sm text-gray-500">States</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">500+</div>
                    <p class="text-sm text-gray-500">Cities</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-primary">99%</div>
                    <p class="text-sm text-gray-500">On-time</p>
                </div>
            </div>
        </div>

        <!-- Tracking -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h3 class="font-bold text-lg mb-2"><i class="fas fa-map-marker-alt text-primary mr-2"></i> Track Your Order</h3>
            <p class="text-sm text-gray-600 mb-4">Get real-time updates on your order status via SMS, Email, and in-app notifications.</p>
            <a href="{{ route('orders.index') }}" class="inline-block bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                Track Order
            </a>
        </div>
    </div>
</div>
@endsection
