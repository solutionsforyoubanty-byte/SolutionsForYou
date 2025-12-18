@extends('layouts.app')
@section('title', 'Terms of Use')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold font-display">Terms of Use</h1>
            <p class="mt-3 text-gray-300">Last updated: {{ date('F Y') }}</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-sm p-8 space-y-8">
            <!-- Introduction -->
            <section>
                <h2 class="text-xl font-bold mb-3">1. Introduction</h2>
                <p class="text-gray-600">Welcome to E-Shop. By accessing and using our website, you agree to be bound by these Terms of Use. Please read them carefully before using our services.</p>
            </section>

            <!-- Account -->
            <section>
                <h2 class="text-xl font-bold mb-3">2. Account Registration</h2>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> You must be at least 18 years old to create an account</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> You are responsible for maintaining the confidentiality of your account</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> You agree to provide accurate and complete information</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> One account per person is allowed</li>
                </ul>
            </section>

            <!-- Orders -->
            <section>
                <h2 class="text-xl font-bold mb-3">3. Orders & Payments</h2>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> All prices are in Indian Rupees (INR) and inclusive of applicable taxes</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> We reserve the right to cancel orders due to pricing errors</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> Payment must be made through approved payment methods</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle text-xs text-primary mt-2"></i> Order confirmation is subject to product availability</li>
                </ul>
            </section>

            <!-- Product Info -->
            <section>
                <h2 class="text-xl font-bold mb-3">4. Product Information</h2>
                <p class="text-gray-600">We strive to display accurate product information including descriptions, images, and prices. However, we do not warrant that product descriptions or other content is accurate, complete, or error-free.</p>
            </section>

            <!-- User Conduct -->
            <section>
                <h2 class="text-xl font-bold mb-3">5. User Conduct</h2>
                <p class="text-gray-600 mb-3">You agree not to:</p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2"><i class="fas fa-times text-red-400 mt-1"></i> Use the website for any unlawful purpose</li>
                    <li class="flex items-start gap-2"><i class="fas fa-times text-red-400 mt-1"></i> Attempt to gain unauthorized access to our systems</li>
                    <li class="flex items-start gap-2"><i class="fas fa-times text-red-400 mt-1"></i> Post false, misleading, or defamatory content</li>
                    <li class="flex items-start gap-2"><i class="fas fa-times text-red-400 mt-1"></i> Interfere with the proper working of the website</li>
                </ul>
            </section>

            <!-- Intellectual Property -->
            <section>
                <h2 class="text-xl font-bold mb-3">6. Intellectual Property</h2>
                <p class="text-gray-600">All content on this website, including text, graphics, logos, images, and software, is the property of E-Shop and is protected by intellectual property laws.</p>
            </section>

            <!-- Limitation -->
            <section>
                <h2 class="text-xl font-bold mb-3">7. Limitation of Liability</h2>
                <p class="text-gray-600">E-Shop shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of our services.</p>
            </section>

            <!-- Changes -->
            <section>
                <h2 class="text-xl font-bold mb-3">8. Changes to Terms</h2>
                <p class="text-gray-600">We reserve the right to modify these terms at any time. Continued use of the website after changes constitutes acceptance of the new terms.</p>
            </section>

            <!-- Contact -->
            <section class="bg-gray-50 rounded-lg p-6">
                <h2 class="text-xl font-bold mb-3">9. Contact Us</h2>
                <p class="text-gray-600">If you have any questions about these Terms of Use, please contact us:</p>
                <div class="mt-3 space-y-1 text-gray-600">
                    <p><i class="fas fa-envelope text-primary mr-2"></i> legal@eshop.com</p>
                    <p><i class="fas fa-phone text-primary mr-2"></i> 1800-XXX-XXXX</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
