@include('admin.header')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Blog Management</h1>
            <p class="mb-0 text-gray-600">Manage all your blog posts</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('blogs.create') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Post
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        <div class="card shadow mb-4 w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Blog Posts</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th width="80">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th width="100">Status</th>
                                <th width="80">Views</th>
                                <th width="130">Published</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blogs as $blog)
                                <tr>
                                    <td>
                                        <img src="{{ $blog->image_url }}" 
                                             alt="{{ $blog->title }}" 
                                             class="rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($blog->title, 40) }}</div>
                                        <small class="text-muted">By {{ $blog->author }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $blog->category ?? 'Uncategorized' }}</span>
                                    </td>
                                    <td>
                                        @if($blog->status == 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-eye"></i> {{ $blog->views }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($blog->published_at)
                                            <small>{{ $blog->published_at->format('M d, Y') }}</small>
                                        @else
                                            <small class="text-muted">Not published</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user.blog.show', $blog->slug) }}" 
                                               target="_blank"
                                               class="btn btn-sm btn-info" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('blogs.edit', $blog->id) }}"
                                               class="btn btn-sm btn-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete({{ $blog->id }}, '{{ addslashes($blog->title) }}')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-newspaper fa-3x text-gray-300 mb-3"></i>
                                        <h5 class="text-gray-600">No Blog Posts Found</h5>
                                        <p class="text-gray-500">Start by creating your first blog post.</p>
                                        <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create Post
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($blogs->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $blogs->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
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

function confirmDelete(blogId, blogTitle) {
    Swal.fire({
        title: 'Are you sure?',
        text: `You want to delete "${blogTitle}"?`,
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
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            window.location.href = `/admin/blogs/delete/${blogId}`;
        }
    });
}
</script>
