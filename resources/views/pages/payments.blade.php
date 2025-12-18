@extends('layouts.app')
@section('title', 'Payments')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-green-600 to-teal-500 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold font-display">Payment Options</h1>
            <p class="mt-3 text-green-100">Multiple secure payment methods for your convenience</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Payment Methods -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-6">Accepted Payment Methods</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fab fa-cc-visa text-3xl text-blue-600"></i>
                        <i class="fab fa-cc-mastercard text-3xl text-orange-500"></i>
                        <i class="fab fa-cc-amex text-3xl text-blue-400"></i>
                    </div>
                    <h3 class="font-bold">Credit/Debit Cards</h3>
                    <p class="text-sm text-gray-500 mt-1">Visa, Mastercard, Amex, RuPay</p>
                </div>
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fab fa-google-pay text-3xl"></i>
                        <span class="text-2xl font-bold text-purple-600">PhonePe</span>
                    </div>
                    <h3 class="font-bold">UPI Payments</h3>
                    <p class="text-sm text-gray-500 mt-1">Google Pay, PhonePe, Paytm, BHIM</p>
                </div>
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-university text-3xl text-gray-600"></i>
                    </div>
                    <h3 class="font-bold">Net Banking</h3>
                    <p class="text-sm text-gray-500 mt-1">All major banks supported</p>
                </div>
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-money-bill-wave text-3xl text-green-600"></i>
                    </div>
                    <h3 class="font-bold">Cash on Delivery</h3>
                    <p class="text-sm text-gray-500 mt-1">Pay when you receive your order</p>
                </div>
            </div>
        </div>

        <!-- EMI Options -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold mb-4">EMI Options</h2>
            <p class="text-gray-600 mb-4">Convert your purchase into easy monthly installments</p>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> No Cost EMI available on select products</li>
                <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> EMI starting from ₹500/month</li>
                <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Tenure options: 3, 6, 9, 12 months</li>
                <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Available on HDFC, ICICI, SBI, Axis cards</li>
            </ul>
        </div>

        <!-- Security -->
        <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
            <i class="fas fa-shield-alt text-4xl text-green-600 mb-3"></i>
            <h3 class="font-bold text-lg">100% Secure Payments</h3>
            <p class="text-sm text-gray-600 mt-2">All transactions are encrypted with 256-bit SSL security. Your payment information is safe with us.</p>
        </div>
    </div>
</div>
@endsection
