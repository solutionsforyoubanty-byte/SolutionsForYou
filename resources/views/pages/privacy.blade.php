@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold font-display">Privacy Policy</h1>
            <p class="mt-3 text-purple-100">Your privacy is important to us</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Quick Summary -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h2 class="text-lg font-bold mb-4"><i class="fas fa-shield-alt text-green-500 mr-2"></i>Privacy at a Glance</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                    <i class="fas fa-lock text-green-500 text-xl"></i>
                    <span class="text-sm">Data Encrypted</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-user-shield text-blue-500 text-xl"></i>
                    <span class="text-sm">No Data Selling</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-lg">
                    <i class="fas fa-eye-slash text-purple-500 text-xl"></i>
                    <span class="text-sm">Your Control</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-8 space-y-8">
            <!-- Information We Collect -->
            <section>
                <h2 class="text-xl font-bold mb-3">1. Information We Collect</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Personal Information</h3>
                        <ul class="space-y-1 text-gray-600 text-sm">
                            <li>• Name, email address, phone number</li>
                            <li>• Shipping and billing addresses</li>
                            <li>• Payment information (processed securely)</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Usage Information</h3>
                        <ul class="space-y-1 text-gray-600 text-sm">
                            <li>• Browsing history on our website</li>
                            <li>• Device information and IP address</li>
                            <li>• Cookies and similar technologies</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- How We Use -->
            <section>
                <h2 class="text-xl font-bold mb-3">2. How We Use Your Information</h2>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Process and fulfill your orders</li>
                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Send order updates and delivery notifications</li>
                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Provide customer support</li>
                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Personalize your shopping experience</li>
                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Send promotional offers (with your consent)</li>
                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Improve our services and website</li>
                </ul>
            </section>

            <!-- Data Sharing -->
            <section>
                <h2 class="text-xl font-bold mb-3">3. Information Sharing</h2>
                <p class="text-gray-600 mb-3">We may share your information with:</p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2"><i class="fas fa-truck text-primary mt-1"></i> Delivery partners (for order fulfillment)</li>
                    <li class="flex items-start gap-2"><i class="fas fa-credit-card text-primary mt-1"></i> Payment processors (for secure transactions)</li>
                    <li class="flex items-start gap-2"><i class="fas fa-gavel text-primary mt-1"></i> Legal authorities (when required by law)</li>
                </ul>
                <div class="mt-4 p-4 bg-green-50 rounded-lg">
                    <p class="text-green-700 font-medium"><i class="fas fa-shield-alt mr-2"></i>We never sell your personal data to third parties.</p>
                </div>
            </section>

            <!-- Data Security -->
            <section>
                <h2 class="text-xl font-bold mb-3">4. Data Security</h2>
                <p class="text-gray-600 mb-3">We implement industry-standard security measures:</p>
                <div class="grid md:grid-cols-2 gap-3">
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-lock text-primary"></i>
                        <span class="text-sm">SSL/TLS Encryption</span>
                    </div>
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-server text-primary"></i>
                        <span class="text-sm">Secure Servers</span>
                    </div>
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-key text-primary"></i>
                        <span class="text-sm">Password Protection</span>
                    </div>
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-shield-alt text-primary"></i>
                        <span class="text-sm">Regular Audits</span>
                    </div>
                </div>
            </section>

            <!-- Cookies -->
            <section>
                <h2 class="text-xl font-bold mb-3">5. Cookies</h2>
                <p class="text-gray-600">We use cookies to enhance your browsing experience, remember your preferences, and analyze website traffic. You can manage cookie preferences through your browser settings.</p>
            </section>

            <!-- Your Rights -->
            <section>
                <h2 class="text-xl font-bold mb-3">6. Your Rights</h2>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2"><i class="fas fa-eye text-primary mt-1"></i> Access your personal data</li>
                    <li class="flex items-start gap-2"><i class="fas fa-edit text-primary mt-1"></i> Correct inaccurate information</li>
                    <li class="flex items-start gap-2"><i class="fas fa-trash text-primary mt-1"></i> Request deletion of your data</li>
                    <li class="flex items-start gap-2"><i class="fas fa-ban text-primary mt-1"></i> Opt-out of marketing communications</li>
                </ul>
            </section>

            <!-- Contact -->
            <section class="bg-purple-50 rounded-lg p-6">
                <h2 class="text-xl font-bold mb-3">7. Contact Us</h2>
                <p class="text-gray-600 mb-3">For privacy-related inquiries:</p>
                <div class="space-y-1 text-gray-600">
                    <p><i class="fas fa-envelope text-purple-500 mr-2"></i> privacy@eshop.com</p>
                    <p><i class="fas fa-phone text-purple-500 mr-2"></i> 1800-XXX-XXXX</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
