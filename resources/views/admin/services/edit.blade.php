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

                        <hr class="my-4">
                        <h4><i class="fas fa-tags"></i> Pricing Plans</h4>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" name="show_pricing" value="1" class="form-check-input" id="showPricing" {{ $service->show_pricing ? 'checked' : '' }}>
                            <label class="form-check-label" for="showPricing">Show on Pricing Page</label>
                        </div>

                        <div class="row">
                            <!-- Basic Plan -->
                            <div class="col-md-4">
                                <div class="card border-primary mb-3">
                                    <div class="card-header bg-primary text-white">Basic Plan</div>
                                    <div class="card-body">
                                        <label>Price (₹)</label>
                                        <input type="number" name="basic_price" class="form-control" step="0.01" value="{{ $service->basic_price }}">
                                        
                                        <label class="mt-2">Delivery Time</label>
                                        <input type="text" name="basic_delivery" class="form-control" value="{{ $service->basic_delivery }}">
                                        
                                        <label class="mt-2">Features (one per line)</label>
                                        <textarea name="basic_features" class="form-control" rows="5">{{ $service->basic_features }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Standard Plan -->
                            <div class="col-md-4">
                                <div class="card border-success mb-3">
                                    <div class="card-header bg-success text-white">Standard Plan</div>
                                    <div class="card-body">
                                        <label>Price (₹)</label>
                                        <input type="number" name="standard_price" class="form-control" step="0.01" value="{{ $service->standard_price }}">
                                        
                                        <label class="mt-2">Delivery Time</label>
                                        <input type="text" name="standard_delivery" class="form-control" value="{{ $service->standard_delivery }}">
                                        
                                        <label class="mt-2">Features (one per line)</label>
                                        <textarea name="standard_features" class="form-control" rows="5">{{ $service->standard_features }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Premium Plan -->
                            <div class="col-md-4">
                                <div class="card border-warning mb-3">
                                    <div class="card-header bg-warning text-dark">Premium Plan</div>
                                    <div class="card-body">
                                        <label>Price (₹)</label>
                                        <input type="number" name="premium_price" class="form-control" step="0.01" value="{{ $service->premium_price }}">
                                        
                                        <label class="mt-2">Delivery Time</label>
                                        <input type="text" name="premium_delivery" class="form-control" value="{{ $service->premium_delivery }}">
                                        
                                        <label class="mt-2">Features (one per line)</label>
                                        <textarea name="premium_features" class="form-control" rows="5">{{ $service->premium_features }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-3">Update Service</button>
                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

@include('admin.footer')
