@extends('layouts.app')
@section('title', 'Returns & Refunds')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold font-display">Returns & Refunds</h1>
            <p class="mt-3 text-orange-100">Hassle-free returns within 7 days</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- How to Return -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-6">How to Return an Item</h2>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">1</div>
                    <div>
                        <h3 class="font-bold">Go to My Orders</h3>
                        <p class="text-sm text-gray-500">Select the order you want to return</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">2</div>
                    <div>
                        <h3 class="font-bold">Select Return Reason</h3>
                        <p class="text-sm text-gray-500">Choose why you want to return the item</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">3</div>
                    <div>
                        <h3 class="font-bold">Schedule Pickup</h3>
                        <p class="text-sm text-gray-500">Our delivery partner will collect the item</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">4</div>
                    <div>
                        <h3 class="font-bold">Get Refund</h3>
                        <p class="text-sm text-gray-500">Refund processed within 5-7 business days</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Refund Methods -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-4">Refund Methods</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium">Original Payment Method</span>
                    <span class="text-sm text-gray-500">5-7 business days</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium">E-Shop Wallet</span>
                    <span class="text-sm text-green-600">Instant</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium">Bank Account</span>
                    <span class="text-sm text-gray-500">3-5 business days</span>
                </div>
            </div>
        </div>

        <!-- Non-Returnable -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <h3 class="font-bold text-lg mb-3"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Non-Returnable Items</h3>
            <ul class="text-sm text-gray-600 space-y-2">
                <li>• Innerwear, lingerie, and swimwear</li>
                <li>• Beauty products and perfumes (if opened)</li>
                <li>• Customized/personalized products</li>
                <li>• Digital products and gift cards</li>
                <li>• Items marked as "Non-Returnable"</li>
            </ul>
        </div>
    </div>
</div>
@endsection
