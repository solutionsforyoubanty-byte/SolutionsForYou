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

                        <hr class="my-4">
                        <h4><i class="fas fa-tags"></i> Pricing Plans</h4>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" name="show_pricing" value="1" class="form-check-input" id="showPricing" checked>
                            <label class="form-check-label" for="showPricing">Show on Pricing Page</label>
                        </div>

                        <div class="row">
                            <!-- Basic Plan -->
                            <div class="col-md-4">
                                <div class="card border-primary mb-3">
                                    <div class="card-header bg-primary text-white">Basic Plan</div>
                                    <div class="card-body">
                                        <label>Price (₹)</label>
                                        <input type="number" name="basic_price" class="form-control" step="0.01" placeholder="e.g., 4999">
                                        
                                        <label class="mt-2">Delivery Time</label>
                                        <input type="text" name="basic_delivery" class="form-control" placeholder="e.g., 3-5 Days">
                                        
                                        <label class="mt-2">Features (one per line)</label>
                                        <textarea name="basic_features" class="form-control" rows="5" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Standard Plan -->
                            <div class="col-md-4">
                                <div class="card border-success mb-3">
                                    <div class="card-header bg-success text-white">Standard Plan</div>
                                    <div class="card-body">
                                        <label>Price (₹)</label>
                                        <input type="number" name="standard_price" class="form-control" step="0.01" placeholder="e.g., 9999">
                                        
                                        <label class="mt-2">Delivery Time</label>
                                        <input type="text" name="standard_delivery" class="form-control" placeholder="e.g., 5-7 Days">
                                        
                                        <label class="mt-2">Features (one per line)</label>
                                        <textarea name="standard_features" class="form-control" rows="5" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Premium Plan -->
                            <div class="col-md-4">
                                <div class="card border-warning mb-3">
                                    <div class="card-header bg-warning text-dark">Premium Plan</div>
                                    <div class="card-body">
                                        <label>Price (₹)</label>
                                        <input type="number" name="premium_price" class="form-control" step="0.01" placeholder="e.g., 19999">
                                        
                                        <label class="mt-2">Delivery Time</label>
                                        <input type="text" name="premium_delivery" class="form-control" placeholder="e.g., 7-10 Days">
                                        
                                        <label class="mt-2">Features (one per line)</label>
                                        <textarea name="premium_features" class="form-control" rows="5" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-3">Save Service</button>
                    </form>

                </div>
            </div>

        </div>

    </div>


</div>

@include('admin.footer')
