@include('admin.header')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Payments</h1>
            <p class="mb-0 text-gray-600">Manage all payment transactions</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.export') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    @php
        $totalRevenue = \App\Models\Payment::where('status', 'paid')->sum('amount');
        $todayRevenue = \App\Models\Payment::where('status', 'paid')->whereDate('created_at', today())->sum('amount');
        $monthRevenue = \App\Models\Payment::where('status', 'paid')->whereMonth('created_at', now()->month)->sum('amount');
        $paidCount = \App\Models\Payment::where('status', 'paid')->count();
        $pendingCount = \App\Models\Payment::where('status', 'pending')->count();
        $failedCount = \App\Models\Payment::where('status', 'failed')->count();
    @endphp
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2" style="border-left-color: #10b981 !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #10b981;">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($totalRevenue, 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($monthRevenue, 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Successful</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paidCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Payments</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.payments.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Plan Type</label>
                    <select name="plan" class="form-control">
                        <option value="">All Plans</option>
                        <option value="basic" {{ request('plan') == 'basic' ? 'selected' : '' }}>Basic</option>
                        <option value="standard" {{ request('plan') == 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="premium" {{ request('plan') == 'premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Payments</h6>
            <span class="badge badge-primary">{{ $payments->total() }} Total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>
                                <code class="text-primary">{{ $payment->order_id }}</code>
                                @if($payment->razorpay_payment_id)
                                <br><small class="text-muted">{{ Str::limit($payment->razorpay_payment_id, 20) }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $payment->customer_name }}</strong>
                                <br><small class="text-muted">{{ $payment->customer_email }}</small>
                                @if($payment->customer_phone)
                                <br><small class="text-muted"><i class="fas fa-phone"></i> {{ $payment->customer_phone }}</small>
                                @endif
                            </td>
                            <td>{{ $payment->service->title ?? 'N/A' }}</td>
                            <td>
                                @if($payment->plan_type == 'basic')
                                    <span class="badge badge-secondary">Basic</span>
                                @elseif($payment->plan_type == 'standard')
                                    <span class="badge badge-primary">Standard</span>
                                @else
                                    <span class="badge badge-warning text-dark">Premium</span>
                                @endif
                            </td>
                            <td><strong class="text-success">₹{{ number_format($payment->amount, 0) }}</strong></td>
                            <td>
                                @if($payment->status == 'paid')
                                    <span class="badge badge-success"><i class="fas fa-check"></i> Paid</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                @else
                                    <span class="badge badge-danger"><i class="fas fa-times"></i> Failed</span>
                                @endif
                            </td>
                            <td>
                                {{ $payment->created_at->format('d M Y') }}
                                <br><small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="mailto:{{ $payment->customer_email }}" class="btn btn-sm btn-primary" title="Send Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                @if($payment->customer_phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $payment->customer_phone) }}" class="btn btn-sm btn-success" target="_blank" title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-credit-card fa-3x text-gray-300 mb-3"></i>
                                <h5 class="text-gray-600">No Payments Found</h5>
                                <p class="text-gray-500">Payments will appear here when customers make purchases.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <!-- Recent Payments Chart -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Overview (Last 7 Days)</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Status</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Paid ({{ $paidCount }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Pending ({{ $pendingCount }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Failed ({{ $failedCount }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@include('admin.footer')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
        datasets: [{
            label: 'Revenue (₹)',
            data: {!! json_encode($chartData ?? [0, 0, 0, 0, 0, 0, 0]) !!},
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Status Pie Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Paid', 'Pending', 'Failed'],
        datasets: [{
            data: [{{ $paidCount }}, {{ $pendingCount }}, {{ $failedCount }}],
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endpush
