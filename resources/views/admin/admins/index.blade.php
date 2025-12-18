@include('admin.header')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Admin Management</h1>
            <p class="mb-0 text-gray-600">Manage admin users and their roles</p>
        </div>
        @if(Auth::guard('admin')->user()->isAdmin())
        <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Admin
        </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Admins</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Admin::where('role', 'admin')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-crown fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Co-Admins</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Admin::where('role', 'co-admin')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Admin::where('is_active', true)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Inactive</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Admin::where('is_active', false)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ban fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Admins</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="60">Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Created</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                        <tr class="{{ $admin->id === Auth::guard('admin')->user()->id ? 'table-primary' : '' }}">
                            <td class="text-center">
                                <img src="{{ $admin->avatar_url }}" alt="{{ $admin->name }}" 
                                     class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>{{ $admin->name }}</strong>
                                @if($admin->id === Auth::guard('admin')->user()->id)
                                    <span class="badge badge-primary ml-1">You</span>
                                @endif
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>{!! $admin->role_badge !!}</td>
                            <td>{!! $admin->status_badge !!}</td>
                            <td>
                                @if($admin->last_login_at)
                                    {{ $admin->last_login_at->diffForHumans() }}
                                @else
                                    <span class="text-muted">Never</span>
                                @endif
                            </td>
                            <td>{{ $admin->created_at->format('d M Y') }}</td>
                            <td>
                                @if($admin->id !== Auth::guard('admin')->user()->id)
                                    @if(Auth::guard('admin')->user()->isAdmin() || !$admin->isAdmin())
                                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.admins.toggle', $admin->id) }}" 
                                           class="btn btn-sm {{ $admin->is_active ? 'btn-warning' : 'btn-success' }}" 
                                           title="{{ $admin->is_active ? 'Deactivate' : 'Activate' }}"
                                           onclick="return confirm('Are you sure?')">
                                            <i class="fas {{ $admin->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                        </a>
                                        @if(Auth::guard('admin')->user()->isAdmin())
                                        <a href="{{ route('admin.admins.delete', $admin->id) }}" 
                                           class="btn btn-sm btn-danger" title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this admin?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    @else
                                        <span class="text-muted">No access</span>
                                    @endif
                                @else
                                    <a href="{{ route('admin.profile') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-user-edit"></i> Edit Profile
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">No admins found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $admins->links() }}
            </div>
        </div>
    </div>

    <!-- Role Permissions Info -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role Permissions</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-left-danger mb-3">
                        <div class="card-body">
                            <h5><i class="fas fa-crown text-danger mr-2"></i>Admin</h5>
                            <ul class="mb-0 pl-3">
                                <li>Full access to all features</li>
                                <li>Can create, edit, delete all admins</li>
                                <li>Can manage all settings</li>
                                <li>Can view all payments & reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-left-info mb-3">
                        <div class="card-body">
                            <h5><i class="fas fa-user-shield text-info mr-2"></i>Co-Admin</h5>
                            <ul class="mb-0 pl-3">
                                <li>Can manage services, projects, blogs</li>
                                <li>Can view and respond to inquiries</li>
                                <li>Can manage subscribers</li>
                                <li>Cannot edit Admin accounts</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@include('admin.footer')
