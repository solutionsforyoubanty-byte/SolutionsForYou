@extends('layouts.admin')
@section('title', 'Settings')
@section('header', 'Store Settings')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf @method('PATCH')

        <!-- Payment Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-bold flex items-center gap-2">
                    <i class="fas fa-credit-card text-gray-500"></i> Payment Settings
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <!-- COD Toggle -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h4 class="font-medium">Cash on Delivery (COD)</h4>
                        <p class="text-sm text-gray-500">Allow customers to pay when they receive the order</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="cod_enabled" value="1" class="sr-only peer" {{ $settings['cod_enabled'] == '1' ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-500"></div>
                    </label>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm mb-2">COD Minimum Order (₹)</label>
                        <input type="number" name="cod_min_order" value="{{ $settings['cod_min_order'] }}" step="0.01" class="w-full border rounded px-3 py-2" placeholder="0 for no minimum">
                        <p class="text-xs text-gray-500 mt-1">Minimum order amount for COD</p>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm mb-2">COD Maximum Order (₹)</label>
                        <input type="number" name="cod_max_order" value="{{ $settings['cod_max_order'] }}" step="0.01" class="w-full border rounded px-3 py-2" placeholder="Leave empty for no limit">
                        <p class="text-xs text-gray-500 mt-1">Maximum order amount for COD</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-bold flex items-center gap-2">
                    <i class="fas fa-truck text-gray-500"></i> Shipping Settings
                </h3>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm mb-2">Free Shipping Above (₹)</label>
                        <input type="number" name="free_shipping_min" value="{{ $settings['free_shipping_min'] }}" step="0.01" class="w-full border rounded px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Orders above this amount get free shipping</p>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm mb-2">Shipping Charge (₹)</label>
                        <input type="number" name="shipping_charge" value="{{ $settings['shipping_charge'] }}" step="0.01" class="w-full border rounded px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Charge for orders below free shipping limit</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tax Settings -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-bold flex items-center gap-2">
                    <i class="fas fa-percent text-gray-500"></i> Tax Settings
                </h3>
            </div>
            <div class="p-6">
                <div class="max-w-xs">
                    <label class="block text-gray-700 text-sm mb-2">Tax Rate (%)</label>
                    <input type="number" name="tax_percent" value="{{ $settings['tax_percent'] }}" step="0.01" class="w-full border rounded px-3 py-2">
                    <p class="text-xs text-gray-500 mt-1">GST percentage applied on orders</p>
                </div>
            </div>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-indigo-700">
            <i class="fas fa-save mr-2"></i> Save Settings
        </button>
    </form>
</div>
@endsection
