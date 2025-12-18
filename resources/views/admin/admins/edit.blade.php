@include('admin.header')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Admin</h1>
            <p class="mb-0 text-gray-600">Update admin account details</p>
        </div>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Admins
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Admin Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Leave blank to keep current password</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                                        <option value="co-admin" {{ old('role', $admin->role) == 'co-admin' ? 'selected' : '' }}>Co-Admin (Limited Access)</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="avatar">Profile Picture</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" 
                                       id="avatar" name="avatar" accept="image/*">
                                <label class="custom-file-label" for="avatar">Choose new file...</label>
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Leave empty to keep current avatar</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                       {{ $admin->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Account Active</label>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Update Admin
                        </button>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Avatar -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Current Profile</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $admin->avatar_url }}" alt="{{ $admin->name }}" 
                         class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    <h5 class="mb-1">{{ $admin->name }}</h5>
                    <p class="text-muted mb-2">{{ $admin->email }}</p>
                    {!! $admin->role_badge !!}
                    {!! $admin->status_badge !!}
                </div>
            </div>

            <!-- Account Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Info</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Created</small>
                        <p class="mb-0">{{ $admin->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Last Login</small>
                        <p class="mb-0">
                            @if($admin->last_login_at)
                                {{ $admin->last_login_at->format('d M Y, h:i A') }}
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <small class="text-muted">Last Updated</small>
                        <p class="mb-0">{{ $admin->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0]?.name || 'Choose new file...';
    e.target.nextElementSibling.textContent = fileName;
});
</script>

@include('admin.footer')
