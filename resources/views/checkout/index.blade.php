@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="px-2 md:px-4 lg:max-w-7xl lg:mx-auto py-3 md:py-6">
    <!-- Breadcrumb -->
    <div class="hidden md:flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('cart.index') }}" class="hover:text-primary">Cart</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-dark">Checkout</span>
    </div>

    <div class="grid lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Left Section -->
        <div class="lg:col-span-2 space-y-3 md:space-y-4">
            <!-- Delivery Address -->
            <div class="bg-white rounded shadow">
                <div class="flex items-center gap-2 md:gap-3 p-3 md:p-4 border-b bg-gray-50">
                    <span class="w-5 h-5 md:w-6 md:h-6 bg-gray-400 text-white rounded-sm flex items-center justify-center text-xs md:text-sm">1</span>
                    <span class="font-medium text-gray-500 text-xs md:text-sm">DELIVERY ADDRESS</span>
                </div>
                <div class="p-3 md:p-4">
                    @if($addresses->count())
                        <div class="space-y-2 md:space-y-3" id="addressList">
                            @foreach($addresses as $address)
                            <label class="flex items-start gap-2 md:gap-3 p-2 md:p-3 border rounded cursor-pointer hover:border-primary address-option {{ $address->is_default ? 'border-primary bg-blue-50' : '' }}">
                                <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1" {{ $address->is_default ? 'checked' : '' }}>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-1 md:gap-2">
                                        <span class="font-medium text-sm md:text-base">{{ $address->name }}</span>
                                        <span class="text-[10px] md:text-xs bg-gray-200 px-1.5 md:px-2 py-0.5 rounded uppercase">{{ $address->type }}</span>
                                        <span class="text-xs md:text-sm text-gray-500">{{ $address->phone }}</span>
                                    </div>
                                    <p class="text-xs md:text-sm text-gray-600 mt-1 line-clamp-2">{{ $address->full_address }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        <button onclick="showAddressForm()" class="mt-3 md:mt-4 text-primary font-medium text-xs md:text-sm">
                            <i class="fas fa-plus mr-1"></i> Add New Address
                        </button>
                    @else
                        <p class="text-gray-500 text-sm mb-4">No saved addresses. Please add one.</p>
                    @endif

                    <!-- Add Address Form -->
                    <div id="addressForm" class="{{ $addresses->count() ? 'hidden' : '' }} mt-3 md:mt-4 border-t pt-3 md:pt-4">
                        <h4 class="font-medium text-sm md:text-base mb-3 md:mb-4">Add New Address</h4>
                        <form action="{{ route('profile.address.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="redirect" value="checkout">
                            <div class="grid grid-cols-2 gap-2 md:gap-4">
                                <div>
                                    <input type="text" name="name" placeholder="Full Name" class="w-full border rounded px-2 md:px-3 py-2 text-xs md:text-sm" required>
                                </div>
                                <div>
                                    <input type="text" name="phone" placeholder="Phone Number" class="w-full border rounded px-2 md:px-3 py-2 text-xs md:text-sm" required>
                                </div>
                                <div class="col-span-2">
                                    <input type="text" name="address_line1" placeholder="Address (House No, Building, Street)" class="w-full border rounded px-2 md:px-3 py-2 text-xs md:text-sm" required>
                                </div>
                                <div>
                                    <input type="text" name="city" placeholder="City" class="w-full border rounded px-2 md:px-3 py-2 text-xs md:text-sm" required>
                                </div>
                                <div>
                                    <input type="text" name="state" placeholder="State" class="w-full border rounded px-2 md:px-3 py-2 text-xs md:text-sm" required>
                                </div>
                                <div>
                                    <input type="text" name="pincode" placeholder="Pincode" class="w-full border rounded px-2 md:px-3 py-2 text-xs md:text-sm" required>
                                </div>
                                <div>
                                    <select name="type" class="w-full border rounded px-2 md:px-3 py-2 text-xs md:text-sm">
                                        <option value="home">Home</option>
                                        <option value="work">Work</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="mt-3 md:mt-4 bg-secondary text-white px-4 md:px-6 py-2 rounded text-xs md:text-sm font-medium">
                                Save Address
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded shadow">
                <div class="flex items-center gap-2 md:gap-3 p-3 md:p-4 border-b bg-gray-50">
                    <span class="w-5 h-5 md:w-6 md:h-6 bg-gray-400 text-white rounded-sm flex items-center justify-center text-xs md:text-sm">2</span>
                    <span class="font-medium text-gray-500 text-xs md:text-sm">ORDER SUMMARY</span>
                </div>
                <div class="p-3 md:p-4">
                    @foreach($carts as $cart)
                    <div class="flex gap-2 md:gap-4 py-2 md:py-3 {{ !$loop->last ? 'border-b' : '' }}">
                        <img src="{{ $cart->product->image ? asset('storage/' . $cart->product->image) : '' }}" class="w-12 h-12 md:w-16 md:h-16 object-contain">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-xs md:text-sm line-clamp-2">{{ $cart->product->name }}</h4>
                            <p class="text-[10px] md:text-xs text-gray-500">Qty: {{ $cart->quantity }}</p>
                            <p class="font-medium text-sm md:text-base mt-1">₹{{ number_format($cart->total) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Options -->
            <div class="bg-white rounded shadow">
                <div class="flex items-center gap-2 md:gap-3 p-3 md:p-4 border-b bg-gray-50">
                    <span class="w-5 h-5 md:w-6 md:h-6 bg-gray-400 text-white rounded-sm flex items-center justify-center text-xs md:text-sm">3</span>
                    <span class="font-medium text-gray-500 text-xs md:text-sm">PAYMENT OPTIONS</span>
                </div>
                <div class="p-3 md:p-4">
                    <div class="space-y-2 md:space-y-3">
                        <label class="flex items-center gap-2 md:gap-3 p-2 md:p-3 border rounded cursor-pointer hover:border-primary">
                            <input type="radio" name="payment_method" value="razorpay" checked>
                            <div class="flex-1">
                                <span class="font-medium text-sm md:text-base">Pay Online</span>
                                <p class="text-[10px] md:text-xs text-gray-500">UPI, Cards, Net Banking</p>
                            </div>
                            <img src="https://razorpay.com/favicon.png" class="h-5 md:h-6">
                        </label>
                        @if($codAvailable)
                        <label class="flex items-center gap-2 md:gap-3 p-2 md:p-3 border rounded cursor-pointer hover:border-primary" id="codOption">
                            <input type="radio" name="payment_method" value="cod">
                            <div class="flex-1">
                                <span class="font-medium text-sm md:text-base">Cash on Delivery</span>
                                <p class="text-[10px] md:text-xs text-gray-500">Pay when you receive</p>
                                @if($codMinOrder > 0 || $codMaxOrder)
                                <p class="text-[10px] md:text-xs text-orange-500 mt-0.5">
                                    @if($codMinOrder > 0)Min: ₹{{ number_format($codMinOrder) }}@endif
                                    @if($codMinOrder > 0 && $codMaxOrder) | @endif
                                    @if($codMaxOrder)Max: ₹{{ number_format($codMaxOrder) }}@endif
                                </p>
                                @endif
                            </div>
                            <i class="fas fa-money-bill-wave text-green-600 text-lg md:text-xl"></i>
                        </label>
                        @else
                        <div class="flex items-center gap-2 md:gap-3 p-2 md:p-3 border rounded bg-gray-50 opacity-60">
                            <input type="radio" disabled>
                            <div class="flex-1">
                                <span class="font-medium text-gray-500 text-sm md:text-base">Cash on Delivery</span>
                                <p class="text-[10px] md:text-xs text-red-500">COD not available</p>
                            </div>
                            <i class="fas fa-money-bill-wave text-gray-400 text-lg md:text-xl"></i>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Price Details -->
        <div>
            <div class="bg-white rounded shadow sticky top-20">
                <div class="p-3 md:p-4 border-b">
                    <h3 class="font-medium text-gray-500 text-xs md:text-sm">PRICE DETAILS</h3>
                </div>
                <div class="p-3 md:p-4 space-y-2 md:space-y-3 text-xs md:text-sm">
                    <div class="flex justify-between">
                        <span>Price ({{ $carts->count() }} items)</span>
                        <span>₹{{ number_format($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Delivery</span>
                        <span class="{{ $shipping == 0 ? 'text-green-600' : '' }}">
                            {{ $shipping == 0 ? 'FREE' : '₹' . $shipping }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>GST</span>
                        <span>₹{{ number_format($tax) }}</span>
                    </div>
                    <div class="flex justify-between text-green-600 hidden" id="discountRow">
                        <span>Discount</span>
                        <span id="discountAmount">-₹0</span>
                    </div>
                    <hr>
                    <div class="flex justify-between font-bold text-base md:text-lg">
                        <span>Total</span>
                        <span id="totalAmount">₹{{ number_format($total) }}</span>
                    </div>
                </div>

                <!-- Coupon -->
                <div class="p-3 md:p-4 border-t">
                    <div class="flex gap-2">
                        <input type="text" id="couponCode" placeholder="Coupon code" class="flex-1 border rounded px-2 md:px-3 py-2 text-xs md:text-sm uppercase">
                        <button onclick="applyCoupon()" class="bg-primary text-white px-3 md:px-4 py-2 rounded text-xs md:text-sm font-medium">Apply</button>
                    </div>
                    <p id="couponMessage" class="text-xs md:text-sm mt-2 hidden"></p>
                </div>

                <div class="p-3 md:p-4 border-t">
                    <button onclick="placeOrder()" id="placeOrderBtn" class="w-full bg-secondary hover:bg-orange-600 text-white py-2.5 md:py-3 rounded font-medium text-sm md:text-base">
                        PLACE ORDER
                    </button>
                </div>

                <div class="p-3 md:p-4 border-t bg-gray-50">
                    <p class="text-[10px] md:text-xs text-gray-500 flex items-center gap-2">
                        <i class="fas fa-shield-alt text-gray-400"></i>
                        Safe and Secure Payments
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
let appliedCoupon = null;
let originalTotal = {{ $total }};
let currentTotal = originalTotal;

function showAddressForm() {
    document.getElementById('addressForm').classList.toggle('hidden');
}

function applyCoupon() {
    const code = document.getElementById('couponCode').value;
    if (!code) return;

    fetch('{{ route("checkout.coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code })
    })
    .then(r => r.json())
    .then(data => {
        const msg = document.getElementById('couponMessage');
        msg.classList.remove('hidden', 'text-green-600', 'text-red-600');
        
        if (data.success) {
            msg.classList.add('text-green-600');
            msg.textContent = data.message;
            appliedCoupon = data.coupon_code;
            
            document.getElementById('discountRow').classList.remove('hidden');
            document.getElementById('discountAmount').textContent = '-₹' + data.discount.toLocaleString();
            currentTotal = originalTotal - data.discount;
            document.getElementById('totalAmount').textContent = '₹' + currentTotal.toLocaleString();
        } else {
            msg.classList.add('text-red-600');
            msg.textContent = data.message;
        }
    });
}

function placeOrder() {
    const addressEl = document.querySelector('input[name="address_id"]:checked');
    const paymentEl = document.querySelector('input[name="payment_method"]:checked');

    if (!addressEl) {
        alert('Please select a delivery address');
        return;
    }

    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

    fetch('{{ route("checkout.order") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            address_id: addressEl.value,
            payment_method: paymentEl.value,
            coupon_code: appliedCoupon
        })
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
            btn.disabled = false;
            btn.innerHTML = 'PLACE ORDER';
            return;
        }

        if (data.payment_method === 'cod') {
            window.location.href = data.redirect;
            return;
        }

        const options = {
            key: data.key,
            amount: data.amount,
            currency: 'INR',
            name: data.name,
            order_id: data.razorpay_order_id,
            prefill: { email: data.email, contact: data.phone },
            handler: function(response) {
                verifyPayment(data.order_id, response);
            },
            modal: {
                ondismiss: function() {
                    btn.disabled = false;
                    btn.innerHTML = 'PLACE ORDER';
                }
            }
        };

        const rzp = new Razorpay(options);
        rzp.open();
    })
    .catch(err => {
        alert('Something went wrong');
        btn.disabled = false;
        btn.innerHTML = 'PLACE ORDER';
    });
}

function verifyPayment(orderId, response) {
    fetch('{{ route("checkout.verify") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            order_id: orderId,
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
            document.getElementById('placeOrderBtn').disabled = false;
            document.getElementById('placeOrderBtn').innerHTML = 'PLACE ORDER';
        }
    });
}
</script>
@endsection
