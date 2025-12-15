@include('admin.header')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Service</h1>
        <a href="{{ route('services.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-right-arrow fa-sm text-white-50"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="card shadow mb-4 w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Service</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Service Title -->
                        <label>Service Title</label>
                        <input type="text" name="title" value="{{ $service->title }}" class="form-control" required>

                        <!-- Image -->
                        <label class="mt-2">Image</label>
                        <input type="file" name="image" class="form-control">

                        @if($service->image)
                            <img src="{{ asset('uploads/services/'.$service->image) }}" class="mt-2" width="120">
                        @endif <br>

                        <!-- Short Description -->
                        <label class="mt-3">Short Description</label>
                        <textarea name="short_description" class="form-control">{{ $service->short_description }}</textarea>

                        <!-- Full Description -->
                        <label class="mt-3">Description</label>
                        <textarea id="editor" name="description">{{ $service->description }}</textarea>

                        <!-- SEO Section -->
                        <h4 class="mt-4">SEO Fields</h4>

                        <label>Meta Title</label>
                        <input type="text" name="meta_title" value="{{ $service->meta_title }}" class="form-control">

                        <label class="mt-2">Meta Description</label>
                        <textarea name="meta_description" class="form-control">{{ $service->meta_description }}</textarea>

                        <label class="mt-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ $service->meta_keywords }}" class="form-control">

                        <button class="btn btn-primary mt-3">Update Service</button>
                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

@include('admin.footer')
