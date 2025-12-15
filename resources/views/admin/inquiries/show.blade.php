@include('admin.header')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Inquiry Details #{{ $inquiry->id }}</h1>
            <p class="mb-0 text-gray-600">Received {{ $inquiry->created_at->diffForHumans() }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inquiries.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Back to Inquiries
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gradient-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user"></i> Customer Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Full Name</label>
                            <h5 class="mb-0">{{ $inquiry->name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Email Address</label>
                            <h5 class="mb-0">
                                <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">
                                    {{ $inquiry->email }}
                                </a>
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Phone Number</label>
                            <h5 class="mb-0">
                                @if($inquiry->phone)
                                    <a href="tel:{{ $inquiry->phone }}" class="text-decoration-none">
                                        {{ $inquiry->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Inquiry Date</label>
                            <h5 class="mb-0">{{ $inquiry->created_at->format('M d, Y h:i A') }}</h5>
                        </div>
                    </div>

                    @if($inquiry->timeline)
                        <div class="row">
                            <div class="col-12">
                                <label class="text-muted small">Project Timeline</label>
                                <h5 class="mb-0">{{ $inquiry->timeline }}</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Service Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-briefcase"></i> Service Requested
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img src="{{ $inquiry->service->image_url }}" 
                                 alt="{{ $inquiry->service->title }}"
                                 class="rounded"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col">
                            <h4 class="mb-2">{{ $inquiry->service->title }}</h4>
                            <p class="mb-2 text-muted">{{ $inquiry->service->short_description }}</p>
                            <a href="{{ route('service.show', $inquiry->service->slug) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> View Service
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions & Answers -->
            @if($inquiry->question_1 || $inquiry->question_2 || $inquiry->question_3)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-question-circle"></i> Questions & Answers
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($inquiry->question_1)
                            <div class="mb-4">
                                <label class="text-muted small">Question 1</label>
                                <div class="alert alert-light mb-2">
                                    <strong>Q:</strong> {{ $inquiry->getQuestionText(1) ?? 'Question 1' }}
                                </div>
                                <div class="pl-3">
                                    <strong>A:</strong> {{ $inquiry->question_1 }}
                                </div>
                            </div>
                        @endif

                        @if($inquiry->question_2)
                            <div class="mb-4">
                                <label class="text-muted small">Question 2</label>
                                <div class="alert alert-light mb-2">
                                    <strong>Q:</strong> {{ $inquiry->getQuestionText(2) ?? 'Question 2' }}
                                </div>
                                <div class="pl-3">
                                    <strong>A:</strong> {{ $inquiry->question_2 }}
                                </div>
                            </div>
                        @endif

                        @if($inquiry->question_3)
                            <div class="mb-0">
                                <label class="text-muted small">Question 3</label>
                                <div class="alert alert-light mb-2">
                                    <strong>Q:</strong> {{ $inquiry->getQuestionText(3) ?? 'Question 3' }}
                                </div>
                                <div class="pl-3">
                                    <strong>A:</strong> {{ $inquiry->question_3 }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Additional Message -->
            @if($inquiry->message)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-comment"></i> Additional Message
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $inquiry->message }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4 border-left-{{ $inquiry->status === 'pending' ? 'warning' : ($inquiry->status === 'in_progress' ? 'info' : 'success') }}">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-info-circle"></i> Inquiry Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @php
                            $statusBadge = match($inquiry->status) {
                                'pending' => 'warning',
                                'in_progress' => 'info',
                                'completed' => 'success',
                                default => 'secondary'
                            };
                        @endphp
                        <h3>
                            <span class="badge bg-{{ $statusBadge }}">
                                {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                            </span>
                        </h3>
                    </div>

                    <form action="{{ route('inquiries.updateStatus', $inquiry->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Update Status</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $inquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $inquiry->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <a href="mailto:{{ $inquiry->email }}" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-envelope"></i> Send Email
                    </a>
                    @if($inquiry->phone)
                        <a href="tel:{{ $inquiry->phone }}" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-phone"></i> Call Customer
                        </a>
                    @endif
                    <button type="button" 
                            class="btn btn-danger btn-block" 
                            onclick="deleteInquiry({{ $inquiry->id }})">
                        <i class="fas fa-trash"></i> Delete Inquiry
                    </button>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-history"></i> Timeline
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="fas fa-plus bg-primary"></i>
                            <div class="timeline-content">
                                <small class="text-muted">{{ $inquiry->created_at->format('M d, Y h:i A') }}</small>
                                <p class="mb-0">Inquiry received</p>
                            </div>
                        </div>
                        @if($inquiry->updated_at != $inquiry->created_at)
                            <div class="timeline-item">
                                <i class="fas fa-edit bg-warning"></i>
                                <div class="timeline-content">
                                    <small class="text-muted">{{ $inquiry->updated_at->format('M d, Y h:i A') }}</small>
                                    <p class="mb-0">Last updated</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('admin.footer')

<script>
function deleteInquiry(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Delete this inquiry? This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/admin/inquiries/delete/${id}`;
        }
    });
}

@if(session('success'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000
    });
@endif
</script>

<style>
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.bg-gradient-primary {
    background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
}
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    padding-bottom: 20px;
}
.timeline-item i {
    position: absolute;
    left: -30px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
}
.timeline-item:before {
    content: '';
    position: absolute;
    left: -21px;
    top: 20px;
    bottom: -20px;
    width: 2px;
    background: #e3e6f0;
}
.timeline-item:last-child:before {
    display: none;
}
</style>