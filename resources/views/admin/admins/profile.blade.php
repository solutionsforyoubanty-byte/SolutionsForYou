@include('admin.header')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
            <p class="mb-0 text-gray-600">Manage your account settings</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img src="{{ $admin->avatar_url }}" alt="{{ $admin->name }}" 
                         class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #4e73df;">
                    <h4 class="mb-1">{{ $admin->name }}</h4>
                    <p class="text-muted mb-2">{{ $admin->email }}</p>
                    <div class="mb-3">
                        {!! $admin->role_badge !!}
                    </div>
                    @if($admin->phone)
                    <p class="mb-0"><i class="fas fa-phone mr-2 text-primary"></i>{{ $admin->phone }}</p>
                    @endif
                </div>
            </div>

            <!-- Account Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Role</small>
                        <p class="mb-0 font-weight-bold">{{ ucfirst($admin->role) }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Status</small>
                        <p class="mb-0">{!! $admin->status_badge !!}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Member Since</small>
                        <p class="mb-0">{{ $admin->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase">Last Login</small>
                        <p class="mb-0">
                            @if($admin->last_login_at)
                                {{ $admin->last_login_at->format('d M Y, h:i A') }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Update Profile Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <small class="text-muted">Max 2MB. Supported: JPEG, PNG, JPG, GIF</small>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Hidden fields to maintain profile data -->
                        <input type="hidden" name="name" value="{{ $admin->name }}">
                        <input type="hidden" name="email" value="{{ $admin->email }}">

                        <div class="form-group">
                            <label for="current_password">Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password">New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Minimum 8 characters</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirm New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="new_password_confirmation" name="new_password_confirmation">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key mr-2"></i>Change Password
                        </button>
                    </form>
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
