@include('admin.header')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Subscribers</h1>
            <p class="mb-0 text-gray-600">Manage your newsletter subscribers</p>
        </div>
        <a href="{{ route('subscribers.export') }}" class="btn btn-sm btn-success shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Export CSV
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Subscribers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActive + $totalUnsubscribed }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActive }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Unsubscribed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUnsubscribed }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Subscribers</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($subscribers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Subscribed At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscribers as $index => $subscriber)
                                <tr>
                                    <td>{{ $subscribers->firstItem() + $index }}</td>
                                    <td>{{ $subscriber->email }}</td>
                                    <td>
                                        @if($subscriber->status === 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Unsubscribed</span>
                                        @endif
                                    </td>
                                    <td>{{ $subscriber->subscribed_at ? $subscriber->subscribed_at->format('d M Y, h:i A') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('subscribers.toggle', $subscriber->id) }}" 
                                           class="btn btn-sm btn-{{ $subscriber->status === 'active' ? 'warning' : 'success' }}"
                                           title="{{ $subscriber->status === 'active' ? 'Unsubscribe' : 'Reactivate' }}">
                                            <i class="fas fa-{{ $subscriber->status === 'active' ? 'ban' : 'check' }}"></i>
                                        </a>
                                        <a href="{{ route('subscribers.delete', $subscriber->id) }}" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this subscriber?')"
                                           title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $subscribers->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">No Subscribers Yet</h5>
                    <p class="text-gray-500">Subscribers will appear here when users subscribe from your website.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin.footer')
