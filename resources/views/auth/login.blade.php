@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-6 md:py-12 px-3 md:px-4">
    <div class="w-full max-w-4xl bg-white rounded shadow-lg overflow-hidden flex">
        <!-- Left Side - Hidden on Mobile -->
        <div class="hidden md:flex w-2/5 bg-primary p-8 flex-col justify-between">
            <div>
                <h2 class="text-white text-2xl font-bold">Login</h2>
                <p class="text-blue-200 mt-2">Get access to your Orders, Wishlist and Recommendations</p>
            </div>
            <img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/login_img_c4a81e.png" class="w-full" onerror="this.style.display='none'">
        </div>

        <!-- Right Side - Form -->
        <div class="flex-1 p-6 md:p-8">
            <h2 class="md:hidden text-xl font-bold text-center mb-6">Login to E-Shop</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-5 md:mb-6">
                    <label class="block text-gray-600 text-xs md:text-sm mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full border-b-2 border-gray-300 py-2 focus:border-primary focus:outline-none text-sm md:text-base @error('email') border-red-500 @enderror" 
                        placeholder="Enter your email" required autofocus>
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="mb-5 md:mb-6">
                    <label class="block text-gray-600 text-xs md:text-sm mb-2">Password</label>
                    <input type="password" name="password" 
                        class="w-full border-b-2 border-gray-300 py-2 focus:border-primary focus:outline-none text-sm md:text-base" 
                        placeholder="Enter your password" required>
                </div>

                <div class="mb-5 md:mb-6">
                    <label class="flex items-center text-xs md:text-sm">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-gray-600">Remember me</span>
                    </label>
                </div>
                
                <p class="text-[10px] md:text-xs text-gray-500 mb-4 md:mb-6">
                    By continuing, you agree to E-Shop's Terms of Use and Privacy Policy.
                </p>
                
                <button type="submit" class="w-full bg-secondary hover:bg-orange-600 text-white py-2.5 md:py-3 rounded font-medium text-sm md:text-base">
                    Login
                </button>
            </form>
            
            <div class="mt-6 md:mt-8 text-center">
                <p class="text-gray-600 text-sm">
                    New to E-Shop? 
                    <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Create an account</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
