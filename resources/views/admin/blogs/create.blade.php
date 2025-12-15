@include('admin.header')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Blog Post</h1>
        <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Blogs
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Post Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Web Development">Web Development</option>
                                    <option value="Design">Design</option>
                                    <option value="Business">Business</option>
                                    <option value="Tutorial">Tutorial</option>
                                    <option value="News">News</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" name="author" class="form-control" value="{{ old('author', 'Admin') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: 1200x630px, Max 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Excerpt (Short Description)</label>
                            <textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt') }}</textarea>
                            <small class="text-muted">Brief summary shown in blog listings</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea id="editor" name="content">{{ old('content') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tags</label>
                            <input type="text" name="tags" class="form-control" placeholder="laravel, php, web (comma separated)" value="{{ old('tags') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                                    <label class="form-check-label" for="is_featured">Mark as Featured Post</label>
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
                            <i class="fas fa-save"></i> Save Post
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
                        <li>Use engaging titles for better CTR</li>
                        <li>Add featured image for social sharing</li>
                        <li>Write SEO-friendly excerpts</li>
                        <li>Use relevant tags for discoverability</li>
                        <li>Featured posts appear on homepage</li>
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
