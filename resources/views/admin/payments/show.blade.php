@include('admin.header')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Payment Details</h1>
            <p class="mb-0 text-gray-600">Order: <code>{{ $payment->order_id }}</code></p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Payments
        </a>
    </div>

    <div class="row">
        <!-- Payment Info -->
        <div class="col-xl-8">
            <!-- Transaction Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-receipt mr-2"></i>Transaction Details
                    </h6>
                    @if($payment->status == 'paid')
                        <span class="badge badge-success badge-lg"><i class="fas fa-check mr-1"></i> Payment Successful</span>
                    @elseif($payment->status == 'pending')
                        <span class="badge badge-warning badge-lg"><i class="fas fa-clock mr-1"></i> Payment Pending</span>
                    @else
                        <span class="badge badge-danger badge-lg"><i class="fas fa-times mr-1"></i> Payment Failed</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small text-uppercase">Order ID</label>
                            <p class="mb-0 font-weight-bold"><code>{{ $payment->order_id }}</code></p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small text-uppercase">Razorpay Order ID</label>
                            <p class="mb-0 font-weight-bold"><code>{{ $payment->razorpay_order_id }}</code></p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small text-uppercase">Razorpay Payment ID</label>
                            <p class="mb-0 font-weight-bold">
                                @if($payment->razorpay_payment_id)
                                    <code>{{ $payment->razorpay_payment_id }}</code>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small text-uppercase">Payment Method</label>
                            <p class="mb-0 font-weight-bold">{{ ucfirst($payment->payment_method ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small text-uppercase">Date & Time</label>
                            <p class="mb-0 font-weight-bold">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small text-uppercase">Last Updated</label>
                            <p class="mb-0 font-weight-bold">{{ $payment->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-box mr-2"></i>Service Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            @if($payment->service && $payment->service->image_url)
                                <img src="{{ $payment->service->image_url }}" alt="{{ $payment->service->title }}" class="img-fluid rounded" style="max-height: 80px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                    <i class="fas fa-box fa-2x text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">{{ $payment->service->title ?? 'Service Deleted' }}</h5>
                            <p class="text-muted mb-0">{{ $payment->service->short_description ?? '' }}</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge 
                                @if($payment->plan_type == 'basic') badge-secondary
                                @elseif($payment->plan_type == 'standard') badge-primary
                                @else badge-warning
                                @endif
                                px-3 py-2">
                                {{ ucfirst($payment->plan_type) }} Plan
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Amount</label>
                            <h3 class="text-success mb-0">₹{{ number_format($payment->amount, 0) }}</h3>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Currency</label>
                            <p class="mb-0 font-weight-bold">{{ $payment->currency }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info & Actions -->
        <div class="col-xl-4">
            <!-- Customer Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user mr-2"></i>Customer Details
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <span class="text-white font-weight-bold" style="font-size: 2rem;">
                                {{ strtoupper(substr($payment->customer_name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <h5 class="mb-1">{{ $payment->customer_name }}</h5>
                    <p class="text-muted mb-3">Customer</p>
                    
                    <div class="text-left">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase">Email</label>
                            <p class="mb-0">
                                <a href="mailto:{{ $payment->customer_email }}">
                                    <i class="fas fa-envelope mr-2 text-primary"></i>{{ $payment->customer_email }}
                                </a>
                            </p>
                        </div>
                        @if($payment->customer_phone)
                        <div class="mb-0">
                            <label class="text-muted small text-uppercase">Phone</label>
                            <p class="mb-0">
                                <a href="tel:{{ $payment->customer_phone }}">
                                    <i class="fas fa-phone mr-2 text-primary"></i>{{ $payment->customer_phone }}
                                </a>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <a href="mailto:{{ $payment->customer_email }}?subject=Regarding Order {{ $payment->order_id }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-envelope mr-2"></i>Send Email
                    </a>
                    @if($payment->customer_phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $payment->customer_phone) }}?text=Hi {{ $payment->customer_name }}, regarding your order {{ $payment->order_id }}" 
                       class="btn btn-success btn-block mb-2" target="_blank">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                    </a>
                    <a href="tel:{{ $payment->customer_phone }}" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-phone mr-2"></i>Call Customer
                    </a>
                    @endif
                    <hr>
                    <button class="btn btn-outline-secondary btn-block" onclick="window.print()">
                        <i class="fas fa-print mr-2"></i>Print Receipt
                    </button>
                </div>
            </div>

            <!-- Payment Timeline -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history mr-2"></i>Timeline
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline-sm">
                        <div class="timeline-item pb-3">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <span class="badge badge-success rounded-circle p-2">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                </div>
                                <div>
                                    <strong>Order Created</strong>
                                    <p class="text-muted small mb-0">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        @if($payment->status == 'paid')
                        <div class="timeline-item pb-3">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <span class="badge badge-success rounded-circle p-2">
                                        <i class="fas fa-check"></i>
                                    </span>
                                </div>
                                <div>
                                    <strong>Payment Received</strong>
                                    <p class="text-muted small mb-0">{{ $payment->updated_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        @elseif($payment->status == 'failed')
                        <div class="timeline-item pb-3">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <span class="badge badge-danger rounded-circle p-2">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                                <div>
                                    <strong>Payment Failed</strong>
                                    <p class="text-muted small mb-0">{{ $payment->updated_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
.timeline-sm .timeline-item:not(:last-child) {
    border-left: 2px solid #e3e6f0;
    margin-left: 11px;
    padding-left: 20px;
}
</style>

@include('admin.footer')
