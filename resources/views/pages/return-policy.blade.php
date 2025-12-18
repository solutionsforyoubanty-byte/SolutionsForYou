@extends('layouts.app')
@section('title', 'Return Policy')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold font-display">Return Policy</h1>
            <p class="mt-3 text-blue-100">Our commitment to your satisfaction</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Policy Overview -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-4">Return Policy Overview</h2>
            <p class="text-gray-600 mb-4">At E-Shop, we want you to be completely satisfied with your purchase. If you're not happy with your order, we offer a hassle-free return policy.</p>
            <div class="grid md:grid-cols-3 gap-4 mt-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <i class="fas fa-calendar-alt text-3xl text-blue-500 mb-2"></i>
                    <h3 class="font-bold">7 Days</h3>
                    <p class="text-sm text-gray-500">Return Window</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <i class="fas fa-truck text-3xl text-green-500 mb-2"></i>
                    <h3 class="font-bold">Free Pickup</h3>
                    <p class="text-sm text-gray-500">We collect from you</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <i class="fas fa-money-bill-wave text-3xl text-purple-500 mb-2"></i>
                    <h3 class="font-bold">Quick Refund</h3>
                    <p class="text-sm text-gray-500">Within 5-7 days</p>
                </div>
            </div>
        </div>

        <!-- Eligibility -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-4"><i class="fas fa-check-circle text-green-500 mr-2"></i>Eligible for Return</h2>
            <ul class="space-y-3 text-gray-600">
                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Product received is damaged or defective</li>
                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Wrong product delivered</li>
                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Product doesn't match description</li>
                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Missing parts or accessories</li>
                <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Size/fit issues (for applicable products)</li>
            </ul>
        </div>

        <!-- Conditions -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-4"><i class="fas fa-clipboard-list text-blue-500 mr-2"></i>Return Conditions</h2>
            <ul class="space-y-3 text-gray-600">
                <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-gray-400 mt-2"></i> Product must be unused and in original condition</li>
                <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-gray-400 mt-2"></i> Original packaging, tags, and accessories must be intact</li>
                <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-gray-400 mt-2"></i> Return request must be raised within 7 days of delivery</li>
                <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-gray-400 mt-2"></i> Product should not be damaged due to misuse</li>
            </ul>
        </div>

        <!-- Non-Returnable -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-8">
            <h3 class="font-bold text-lg mb-3"><i class="fas fa-times-circle text-red-500 mr-2"></i>Non-Returnable Items</h3>
            <div class="grid md:grid-cols-2 gap-3 text-sm text-gray-600">
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Innerwear & lingerie</div>
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Swimwear</div>
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Beauty products (if opened)</div>
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Perfumes & deodorants</div>
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Customized products</div>
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Digital products</div>
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Gift cards</div>
                <div class="flex items-center gap-2"><i class="fas fa-times text-red-400"></i> Grocery items</div>
            </div>
        </div>

        <!-- Contact -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl p-6 text-white text-center">
            <h3 class="font-bold text-lg mb-2">Need Help with Returns?</h3>
            <p class="text-blue-100 mb-4">Our support team is here to assist you</p>
            <a href="{{ route('pages.contact') }}" class="inline-block bg-white text-blue-600 px-6 py-2 rounded-lg font-medium hover:bg-blue-50 transition">Contact Support</a>
        </div>
    </div>
</div>
@endsection
