@include('admin.header')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Services Management</h1>
            <p class="mb-0 text-gray-600">Manage all your services and their content</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('services.create') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Service
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        <div class="card shadow mb-4 w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Services List</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead class="table-dark">
                            <tr>
                                <th width="80">Image</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th width="120">Status</th>
                                <th width="150">Created</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($services as $service)
                                <tr>
                                    <td>
                                        <img src="{{ $service->image_url }}" 
                                             alt="{{ $service->title }}" 
                                             class="rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $service->title }}</div>
                                        <small class="text-muted">{{ Str::limit($service->short_description, 50) }}</small>
                                    </td>
                                    <td>
                                        <code>{{ $service->slug }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <small>{{ $service->created_at->format('M d, Y') }}</small><br>
                                        <small class="text-muted">{{ $service->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('service.show', $service->slug) }}" 
                                               target="_blank"
                                               class="btn btn-sm btn-info" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('services.edit', $service->id) }}"
                                               class="btn btn-sm btn-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('services.questionsPage', $service->id) }}"
                                               class="btn btn-sm btn-success" 
                                               title="Questions">
                                                <i class="fas fa-question"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete({{ $service->id }}, '{{ $service->title }}')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                        <h5 class="text-gray-600">No Services Found</h5>
                                        <p class="text-gray-500">Start by creating your first service.</p>
                                        <a href="{{ route('services.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create Service
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    @if($services->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $services->links('pagination::bootstrap-4') }}
                    </div>
                    @endif

                </div>
            </div>

        </div>

    </div>


</div>

@include('admin.footer')

<script>
function confirmDelete(serviceId, serviceTitle) {
    Swal.fire({
        title: 'Are you sure?',
        text: `You want to delete "${serviceTitle}"? This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the service.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect to delete route
            window.location.href = `/admin/services/delete/${serviceId}`;
        }
    });
}

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>