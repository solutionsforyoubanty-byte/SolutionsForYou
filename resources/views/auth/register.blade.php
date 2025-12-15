@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-6 md:py-12 px-4">
    <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">
        <!-- Left Side - Image/Info (Hidden on mobile) -->
        <div class="hidden md:flex w-2/5 bg-primary p-8 flex-col justify-between">
            <div>
                <h2 class="text-white text-2xl font-bold">Looks like you're new here!</h2>
                <p class="text-blue-200 mt-2">Sign up with your email to get started</p>
            </div>
            <img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/login_img_c4a81e.png" class="w-full" onerror="this.style.display='none'">
        </div>

        <!-- Mobile Header -->
        <div class="md:hidden bg-primary p-6 text-center">
            <h2 class="text-white text-xl font-bold">Create Account</h2>
            <p class="text-blue-200 text-sm mt-1">Sign up to get started</p>
        </div>

        <!-- Right Side - Form -->
        <div class="flex-1 p-6 md:p-8">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4 md:mb-5">
                    <label class="block text-gray-600 text-sm mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="w-full border-b-2 border-gray-300 py-2 text-base focus:border-primary focus:outline-none @error('name') border-red-500 @enderror" 
                        placeholder="Enter your name" required autofocus>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4 md:mb-5">
                    <label class="block text-gray-600 text-sm mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full border-b-2 border-gray-300 py-2 text-base focus:border-primary focus:outline-none @error('email') border-red-500 @enderror" 
                        placeholder="Enter your email" required>
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="mb-4 md:mb-5">
                    <label class="block text-gray-600 text-sm mb-2">Password</label>
                    <input type="password" name="password" 
                        class="w-full border-b-2 border-gray-300 py-2 text-base focus:border-primary focus:outline-none @error('password') border-red-500 @enderror" 
                        placeholder="Create a password" required>
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4 md:mb-5">
                    <label class="block text-gray-600 text-sm mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full border-b-2 border-gray-300 py-2 text-base focus:border-primary focus:outline-none" 
                        placeholder="Confirm your password" required>
                </div>
                
                <p class="text-xs text-gray-500 mb-4 md:mb-6">
                    By continuing, you agree to E-Shop's Terms of Use and Privacy Policy.
                </p>
                
                <button type="submit" class="w-full bg-secondary hover:bg-orange-600 text-white py-3 rounded font-medium text-base transition-colors">
                    Create Account
                </button>
            </form>
            
            <div class="mt-6 md:mt-8 text-center">
                <p class="text-gray-600 text-sm md:text-base">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
