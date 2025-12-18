@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero -->
    <div class="bg-gradient-to-r from-primary to-blue-600 text-white py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold font-display">Contact Us</h1>
            <p class="mt-3 text-blue-100">We're here to help you 24/7</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <!-- Call -->
            <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone text-2xl text-primary"></i>
                </div>
                <h3 class="font-bold text-lg">Call Us</h3>
                <p class="text-gray-500 mt-2">1800-123-4567</p>
                <p class="text-sm text-gray-400">Mon-Sun: 9AM - 9PM</p>
            </div>
            <!-- Email -->
            <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-green-600"></i>
                </div>
                <h3 class="font-bold text-lg">Email Us</h3>
                <p class="text-gray-500 mt-2">support@eshop.com</p>
                <p class="text-sm text-gray-400">Response within 24 hours</p>
            </div>
            <!-- Chat -->
            <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-comments text-2xl text-purple-600"></i>
                </div>
                <h3 class="font-bold text-lg">Live Chat</h3>
                <p class="text-gray-500 mt-2">Chat with our team</p>
                <p class="text-sm text-gray-400">Available 24/7</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
                <h2 class="text-xl font-bold mb-6">Send us a Message</h2>
                <form>
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <input type="text" placeholder="Your Name" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:border-primary focus:outline-none">
                        <input type="email" placeholder="Your Email" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:border-primary focus:outline-none">
                    </div>
                    <input type="text" placeholder="Subject" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 mb-4 focus:border-primary focus:outline-none">
                    <textarea rows="5" placeholder="Your Message" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 mb-4 focus:border-primary focus:outline-none resize-none"></textarea>
                    <button class="w-full bg-primary hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition">
                        <i class="fas fa-paper-plane mr-2"></i> Send Message
                    </button>
                </form>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
                <h2 class="text-xl font-bold mb-6">Our Office</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                        <div>
                            <h4 class="font-medium">Address</h4>
                            <p class="text-gray-500 text-sm">123 E-Commerce Street, Tech Park, Bangalore - 560001, India</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fas fa-clock text-primary mt-1"></i>
                        <div>
                            <h4 class="font-medium">Business Hours</h4>
                            <p class="text-gray-500 text-sm">Monday - Saturday: 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400"><i class="fas fa-map text-4xl"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
