@extends('layouts.app')
@section('title', $career->title . ' - Careers')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-purple-600 to-pink-500 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <a href="{{ route('pages.careers') }}" class="text-purple-200 hover:text-white mb-4 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Back to Careers
            </a>
            <h1 class="text-3xl md:text-4xl font-bold font-display">{{ $career->title }}</h1>
            <div class="flex flex-wrap gap-4 mt-4 text-purple-100">
                <span><i class="fas fa-building mr-1"></i> {{ $career->department }}</span>
                <span><i class="fas fa-map-marker-alt mr-1"></i> {{ $career->location }}</span>
                <span><i class="fas fa-clock mr-1"></i> {{ $career->type }}</span>
                @if($career->salary_range)
                <span><i class="fas fa-rupee-sign mr-1"></i> {{ $career->salary_range }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">Job Description</h2>
                    <div class="text-gray-600 whitespace-pre-wrap">{{ $career->description }}</div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">Requirements</h2>
                    <div class="text-gray-600 whitespace-pre-wrap">{{ $career->requirements }}</div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-4">Apply for this Position</h2>
                    
                    @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('pages.careers.apply', $career) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Phone *</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Resume (PDF, DOC)</label>
                                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full border rounded-lg px-4 py-2 text-sm">
                                @error('resume') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Cover Letter</label>
                                <textarea name="cover_letter" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Tell us why you're a great fit...">{{ old('cover_letter') }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-medium transition">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
