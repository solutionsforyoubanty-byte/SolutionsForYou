@include('admin.header')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Projects Management</h1>
            <p class="mb-0 text-gray-600">Manage all your portfolio projects</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('projects.create') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Project
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dashboard
            </a>
        </div>
    </div>



    <div class="row">
        <div class="card shadow mb-4 w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Projects List</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th width="80">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th width="100">Status</th>
                                <th width="100">Featured</th>
                                <th width="130">Created</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                <tr>
                                    <td>
                                        <img src="{{ $project->image_url }}" 
                                             alt="{{ $project->title }}" 
                                             class="rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $project->title }}</div>
                                        <small class="text-muted">{{ Str::limit($project->short_description, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $project->category ?? 'Uncategorized' }}</span>
                                    </td>
                                    <td>
                                        @if($project->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->is_featured)
                                            <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> Featured</span>
                                        @else
                                            <span class="badge bg-light text-dark">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $project->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user.project.show', $project->slug) }}" 
                                               target="_blank"
                                               class="btn btn-sm btn-info" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('projects.edit', $project->id) }}"
                                               class="btn btn-sm btn-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete({{ $project->id }}, '{{ $project->title }}')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                        <h5 class="text-gray-600">No Projects Found</h5>
                                        <p class="text-gray-500">Start by creating your first project.</p>
                                        <a href="{{ route('projects.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create Project
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($projects->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $projects->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
// Toast notifications
@if(session('toast_success'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('toast_success') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
@endif

@if(session('toast_error'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('toast_error') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
@endif

function confirmDelete(projectId, projectTitle) {
    Swal.fire({
        title: 'Are you sure?',
        text: `You want to delete "${projectTitle}"? This action cannot be undone!`,
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
                text: 'Please wait while we delete the project.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            window.location.href = `/admin/projects/delete/${projectId}`;
        }
    });
}
</script>
