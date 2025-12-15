@include('admin.header')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Project</h1>
        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Projects
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Project Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Project Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required value="{{ $project->title }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Web Development" {{ $project->category == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Mobile App" {{ $project->category == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                                    <option value="E-Commerce" {{ $project->category == 'E-Commerce' ? 'selected' : '' }}>E-Commerce</option>
                                    <option value="UI/UX Design" {{ $project->category == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                                    <option value="CRM/ERP" {{ $project->category == 'CRM/ERP' ? 'selected' : '' }}>CRM/ERP</option>
                                    <option value="Other" {{ $project->category == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Name</label>
                                <input type="text" name="client_name" class="form-control" value="{{ $project->client_name }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if($project->image)
                                <div class="mt-2">
                                    <img src="{{ $project->image_url }}" class="rounded" width="150">
                                    <small class="d-block text-muted mt-1">Current image</small>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="2">{{ $project->short_description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea id="editor" name="description">{{ $project->description }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project URL</label>
                                <input type="url" name="project_url" class="form-control" value="{{ $project->project_url }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Completion Date</label>
                                <input type="date" name="completion_date" class="form-control" value="{{ $project->completion_date?->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Technologies Used</label>
                            <input type="text" name="technologies" class="form-control" value="{{ $project->technologies }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $project->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ $project->is_featured ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Mark as Featured Project</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">SEO Settings</h5>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ $project->meta_title }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ $project->meta_description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ $project->meta_keywords }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Project
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Project Info</h6>
                </div>
                <div class="card-body">
                    <p><strong>Created:</strong> {{ $project->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $project->updated_at->format('M d, Y') }}</p>
                    <p><strong>Slug:</strong> <code>{{ $project->slug }}</code></p>
                    <hr>
                    <a href="{{ route('user.project.show', $project->slug) }}" target="_blank" class="btn btn-info btn-sm w-100">
                        <i class="fas fa-external-link-alt"></i> View Live
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
@if($errors->any())
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: 'Please fix the errors',
        html: '{!! implode("<br>", $errors->all()) !!}',
        showConfirmButton: true,
        confirmButtonText: 'OK'
    });
@endif
</script>
