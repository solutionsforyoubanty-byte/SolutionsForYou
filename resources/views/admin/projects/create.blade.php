@include('admin.header')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Project</h1>
        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Projects
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Project Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Project Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Web Development">Web Development</option>
                                    <option value="Mobile App">Mobile App</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="UI/UX Design">UI/UX Design</option>
                                    <option value="CRM/ERP">CRM/ERP</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Name</label>
                                <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: 800x600px, Max 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea id="editor" name="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project URL</label>
                                <input type="url" name="project_url" class="form-control" placeholder="https://" value="{{ old('project_url') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Completion Date</label>
                                <input type="date" name="completion_date" class="form-control" value="{{ old('completion_date') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Technologies Used</label>
                            <input type="text" name="technologies" class="form-control" placeholder="Laravel, React, MySQL (comma separated)" value="{{ old('technologies') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                                    <label class="form-check-label" for="is_featured">Mark as Featured Project</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">SEO Settings</h5>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Project
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Use high-quality images for better presentation</li>
                        <li>Write detailed descriptions for SEO</li>
                        <li>Add relevant technologies used</li>
                        <li>Featured projects appear on homepage</li>
                    </ul>
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
