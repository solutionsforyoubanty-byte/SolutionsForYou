@include('admin.header')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Blog Post</h1>
        <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Blogs
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Post Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Post Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required value="{{ $blog->title }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Technology" {{ $blog->category == 'Technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="Web Development" {{ $blog->category == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Design" {{ $blog->category == 'Design' ? 'selected' : '' }}>Design</option>
                                    <option value="Business" {{ $blog->category == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Tutorial" {{ $blog->category == 'Tutorial' ? 'selected' : '' }}>Tutorial</option>
                                    <option value="News" {{ $blog->category == 'News' ? 'selected' : '' }}>News</option>
                                    <option value="Other" {{ $blog->category == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" name="author" class="form-control" value="{{ $blog->author }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if($blog->image)
                                <div class="mt-2">
                                    <img src="{{ $blog->image_url }}" class="rounded" width="150">
                                    <small class="d-block text-muted mt-1">Current image</small>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Excerpt</label>
                            <textarea name="excerpt" class="form-control" rows="2">{{ $blog->excerpt }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea id="editor" name="content">{{ $blog->content }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tags</label>
                            <input type="text" name="tags" class="form-control" value="{{ $blog->tags }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="draft" {{ $blog->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $blog->status == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ $blog->is_featured ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Mark as Featured Post</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">SEO Settings</h5>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ $blog->meta_title }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ $blog->meta_description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ $blog->meta_keywords }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Post
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Post Info</h6>
                </div>
                <div class="card-body">
                    <p><strong>Created:</strong> {{ $blog->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $blog->updated_at->format('M d, Y') }}</p>
                    <p><strong>Views:</strong> {{ $blog->views }}</p>
                    <p><strong>Slug:</strong> <code>{{ $blog->slug }}</code></p>
                    @if($blog->published_at)
                        <p><strong>Published:</strong> {{ $blog->published_at->format('M d, Y H:i') }}</p>
                    @endif
                    <hr>
                    <a href="{{ route('user.blog.show', $blog->slug) }}" target="_blank" class="btn btn-info btn-sm w-100">
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
