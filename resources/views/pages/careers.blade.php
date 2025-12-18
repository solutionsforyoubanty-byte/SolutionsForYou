@extends('layouts.app')
@section('title', 'Careers')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-purple-600 to-pink-500 text-white py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold font-display">Join Our Team</h1>
            <p class="mt-4 text-xl text-purple-100">Build the future of e-commerce with us</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Why Work at E-Shop?</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-chart-line text-xl text-primary"></i>
                    </div>
                    <h3 class="font-bold text-sm">Growth</h3>
                    <p class="text-gray-500 text-xs mt-1">Fast-track your career</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-users text-xl text-green-600"></i>
                    </div>
                    <h3 class="font-bold text-sm">Culture</h3>
                    <p class="text-gray-500 text-xs mt-1">Inclusive workplace</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-gift text-xl text-orange-600"></i>
                    </div>
                    <h3 class="font-bold text-sm">Benefits</h3>
                    <p class="text-gray-500 text-xs mt-1">Competitive packages</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-laptop-house text-xl text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-sm">Flexibility</h3>
                    <p class="text-gray-500 text-xs mt-1">Hybrid work model</p>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-6">Open Positions</h2>
        
        @if($careers->count() > 0)
        <div class="space-y-4">
            @foreach($careers as $career)
            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-lg">{{ $career->title }}</h3>
                    <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-500">
                        <span><i class="fas fa-building mr-1"></i> {{ $career->department }}</span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i> {{ $career->location }}</span>
                        <span><i class="fas fa-clock mr-1"></i> {{ $career->type }}</span>
                        @if($career->salary_range)
                        <span><i class="fas fa-rupee-sign mr-1"></i> {{ $career->salary_range }}</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('pages.careers.show', $career) }}" class="bg-primary hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition text-center">
                    View & Apply
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="fas fa-briefcase text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-500">No Open Positions</h3>
            <p class="text-gray-400 mt-2">Check back later for new opportunities</p>
        </div>
        @endif

        <div class="mt-12 bg-gray-100 rounded-xl p-8 text-center">
            <h3 class="text-xl font-bold mb-2">Don't see a role that fits?</h3>
            <p class="text-gray-500 mb-4">Send us your resume and we'll keep you in mind for future opportunities</p>
            <a href="{{ route('pages.contact') }}" class="inline-block bg-dark hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-medium transition">
                <i class="fas fa-envelope mr-2"></i> Contact Us
            </a>
        </div>
    </div>
</div>
@endsection
