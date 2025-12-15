@include('admin.header')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Service Inquiries</h1>
            <p class="mb-0 text-gray-600">Manage all customer inquiries and requests</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                In Progress</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['in_progress'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('inquiries.index') }}">
                        All ({{ $stats['total'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}" href="{{ route('inquiries.index', ['status' => 'pending']) }}">
                        Pending ({{ $stats['pending'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'in_progress' ? 'active' : '' }}" href="{{ route('inquiries.index', ['status' => 'in_progress']) }}">
                        In Progress ({{ $stats['in_progress'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'completed' ? 'active' : '' }}" href="{{ route('inquiries.index', ['status' => 'completed']) }}">
                        Completed ({{ $stats['completed'] }})
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th width="80">#ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Contact</th>
                            <th width="120">Status</th>
                            <th width="150">Date</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                            <tr class="{{ $inquiry->status === 'pending' ? 'table-warning' : '' }}">
                                <td>
                                    <strong>#{{ $inquiry->id }}</strong>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $inquiry->name }}</div>
                                    <small class="text-muted">{{ $inquiry->email }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('service.show', $inquiry->service->slug) }}" target="_blank" class="text-decoration-none">
                                        {{ $inquiry->service->title ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>
                                    <small>
                                        <i class="fas fa-envelope"></i> {{ $inquiry->email }}<br>
                                        @if($inquiry->phone)
                                            <i class="fas fa-phone"></i> {{ $inquiry->phone }}
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @php
                                        $statusBadge = match($inquiry->status) {
                                            'pending' => 'warning',
                                            'in_progress' => 'info',
                                            'completed' => 'success',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusBadge }}">
                                        {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        {{ $inquiry->created_at->format('M d, Y') }}<br>
                                        <span class="text-muted">{{ $inquiry->created_at->diffForHumans() }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('inquiries.show', $inquiry->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-warning" 
                                                onclick="updateStatus({{ $inquiry->id }})"
                                                title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="deleteInquiry({{ $inquiry->id }}, '{{ $inquiry->name }}')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-600">No Inquiries Found</h5>
                                    <p class="text-gray-500">No customer inquiries yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($inquiries->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $inquiries->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Update Inquiry Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Status</label>
                        <select name="status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
function updateStatus(id) {
    document.getElementById('updateStatusForm').action = `/admin/inquiries/update-status/${id}`;
    $('#updateStatusModal').modal('show');
}

function deleteInquiry(id, name) {
    Swal.fire({
        title: 'Are you sure?',
        html: `Delete inquiry from <strong>${name}</strong>?<br>This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            window.location.href = `/admin/inquiries/delete/${id}`;
        }
    });
}

@if(session('success'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000
    });
@endif
</script>