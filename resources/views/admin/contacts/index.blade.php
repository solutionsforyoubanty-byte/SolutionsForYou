@include('admin.header')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Contact Messages</h1>
            <p class="mb-0 text-gray-600">Manage contact form submissions</p>
        </div>
    </div>

    <!-- Stats Cards -->
    @php
        $newCount = \App\Models\Contact::where('status', 'new')->count();
        $readCount = \App\Models\Contact::where('status', 'read')->count();
        $repliedCount = \App\Models\Contact::where('status', 'replied')->count();
        $totalCount = \App\Models\Contact::count();
    @endphp
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">New Messages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Read</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $readCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Replied</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $repliedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-reply fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Messages</h6>
            <span class="badge badge-primary">{{ $contacts->total() }} Total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr class="{{ $contact->status === 'new' ? 'table-primary' : '' }}">
                            <td>{{ $contact->id }}</td>
                            <td>
                                <strong>{{ $contact->name }}</strong>
                                @if($contact->status === 'new')
                                    <span class="badge badge-danger ml-1">New</span>
                                @endif
                                @if($contact->phone)
                                <br><small class="text-muted"><i class="fas fa-phone"></i> {{ $contact->phone }}</small>
                                @endif
                            </td>
                            <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                            <td>{{ Str::limit($contact->subject ?? 'No Subject', 30) }}</td>
                            <td>
                                @if($contact->service)
                                    <span class="badge badge-info">{{ $contact->service->title }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{!! $contact->status_badge !!}</td>
                            <td>
                                {{ $contact->created_at->format('d M Y') }}
                                <br><small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-sm btn-primary" title="Reply">
                                    <i class="fas fa-reply"></i>
                                </a>
                                <a href="{{ route('admin.contacts.delete', $contact->id) }}" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                <h5 class="text-gray-600">No Messages Yet</h5>
                                <p class="text-gray-500">Contact form submissions will appear here.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@include('admin.footer')
