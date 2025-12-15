@include('admin.header')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('services.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-right-arrow fa-sm text-white-50"></i> Back</a>
    </div>

    <div class="row">
        <div class="card shadow mb-4 w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Service</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <label>Service Title</label>
                        <input type="text" name="title" class="form-control" required>

                        <label>Image</label>
                        <input type="file" name="image" class="form-control" required>

                        <label>Short Description</label>
                        <textarea name="short_description" class="form-control"></textarea>

                        <label>Description</label>
                        <textarea id="editor" name="description">{{ old('description', $service->description ?? '') }}</textarea>


                        <h4>SEO Fields</h4>

                        <label>Meta Title</label>
                        <input type="text" name="meta_title" class="form-control">

                        <label>Meta Description</label>
                        <textarea name="meta_description" class="form-control"></textarea>

                        <label>Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control">

                        <button class="btn btn-primary mt-3">Save Service</button>
                    </form>

                </div>
            </div>

        </div>

    </div>


</div>

@include('admin.footer')
