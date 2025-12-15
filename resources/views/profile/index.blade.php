@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-6">
    <div class="grid lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Sidebar - Hidden on Mobile -->
        <div class="hidden lg:block lg:col-span-1">
            <div class="bg-white rounded shadow">
                <div class="p-4 border-b flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center text-xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Hello,</p>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>
                </div>
                <nav class="p-2">
                    <a href="#profile" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-100 text-primary">
                        <i class="fas fa-user w-5"></i> Profile
                    </a>
                    <a href="#addresses" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-100">
                        <i class="fas fa-map-marker-alt w-5"></i> Addresses
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-100">
                        <i class="fas fa-box w-5"></i> Orders
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-100">
                        <i class="fas fa-heart w-5"></i> Wishlist
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-4 md:space-y-6">
            <!-- Mobile Header -->
            <div class="lg:hidden bg-white rounded shadow p-4 flex items-center gap-3">
                <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center text-xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-medium">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="bg-white rounded shadow" id="profile">
                <div class="p-3 md:p-4 border-b">
                    <h2 class="font-medium text-sm md:text-base">Personal Information</h2>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" class="p-3 md:p-4">
                    @csrf @method('PATCH')
                    <div class="grid md:grid-cols-2 gap-3 md:gap-4">
                        <div>
                            <label class="block text-xs md:text-sm text-gray-600 mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs md:text-sm text-gray-600 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border rounded px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs md:text-sm text-gray-600 mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" class="w-full border rounded px-3 py-2 text-sm bg-gray-100" disabled>
                        </div>
                    </div>
                    <button type="submit" class="mt-3 md:mt-4 bg-primary text-white px-4 md:px-6 py-2 rounded text-xs md:text-sm font-medium">Save</button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded shadow">
                <div class="p-3 md:p-4 border-b">
                    <h2 class="font-medium text-sm md:text-base">Change Password</h2>
                </div>
                <form action="{{ route('profile.password') }}" method="POST" class="p-3 md:p-4">
                    @csrf @method('PATCH')
                    <div class="grid md:grid-cols-3 gap-3 md:gap-4">
                        <div>
                            <label class="block text-xs md:text-sm text-gray-600 mb-1">Current Password</label>
                            <input type="password" name="current_password" class="w-full border rounded px-3 py-2 text-sm" required>
                            @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs md:text-sm text-gray-600 mb-1">New Password</label>
                            <input type="password" name="password" class="w-full border rounded px-3 py-2 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs md:text-sm text-gray-600 mb-1">Confirm</label>
                            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2 text-sm" required>
                        </div>
                    </div>
                    <button type="submit" class="mt-3 md:mt-4 bg-primary text-white px-4 md:px-6 py-2 rounded text-xs md:text-sm font-medium">Update</button>
                </form>
            </div>

            <!-- Addresses -->
            <div class="bg-white rounded shadow" id="addresses">
                <div class="p-3 md:p-4 border-b flex justify-between items-center">
                    <h2 class="font-medium text-sm md:text-base">Manage Addresses</h2>
                    <button onclick="document.getElementById('newAddressForm').classList.toggle('hidden')" class="text-primary text-xs md:text-sm font-medium">
                        <i class="fas fa-plus mr-1"></i> Add
                    </button>
                </div>

                <!-- New Address Form -->
                <div id="newAddressForm" class="hidden p-3 md:p-4 border-b bg-gray-50">
                    <form action="{{ route('profile.address.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-2 md:gap-4">
                            <input type="text" name="name" placeholder="Full Name" class="border rounded px-3 py-2 text-xs md:text-sm" required>
                            <input type="text" name="phone" placeholder="Phone" class="border rounded px-3 py-2 text-xs md:text-sm" required>
                            <input type="text" name="address_line1" placeholder="Address" class="border rounded px-3 py-2 text-xs md:text-sm col-span-2" required>
                            <input type="text" name="city" placeholder="City" class="border rounded px-3 py-2 text-xs md:text-sm" required>
                            <input type="text" name="state" placeholder="State" class="border rounded px-3 py-2 text-xs md:text-sm" required>
                            <input type="text" name="pincode" placeholder="Pincode" class="border rounded px-3 py-2 text-xs md:text-sm" required>
                            <select name="type" class="border rounded px-3 py-2 text-xs md:text-sm">
                                <option value="home">Home</option>
                                <option value="work">Work</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-3 bg-secondary text-white px-4 md:px-6 py-2 rounded text-xs md:text-sm font-medium">Save</button>
                    </form>
                </div>

                <!-- Address List -->
                <div class="p-3 md:p-4">
                    @forelse($addresses as $address)
                    <div class="border rounded p-3 md:p-4 mb-2 md:mb-3 {{ $address->is_default ? 'border-primary bg-blue-50' : '' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1 md:gap-2">
                                    <span class="font-medium text-sm md:text-base">{{ $address->name }}</span>
                                    <span class="text-[10px] md:text-xs bg-gray-200 px-1.5 md:px-2 py-0.5 rounded uppercase">{{ $address->type }}</span>
                                    @if($address->is_default)
                                        <span class="text-[10px] md:text-xs bg-primary text-white px-1.5 md:px-2 py-0.5 rounded">Default</span>
                                    @endif
                                </div>
                                <p class="text-xs md:text-sm text-gray-600 mt-1">{{ $address->full_address }}</p>
                                <p class="text-xs md:text-sm text-gray-600">Phone: {{ $address->phone }}</p>
                            </div>
                            <form action="{{ route('profile.address.delete', $address) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 text-xs md:text-sm hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4 text-sm">No saved addresses</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
