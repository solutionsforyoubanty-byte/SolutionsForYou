@include('admin.header')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Message Details</h1>
            <p class="mb-0 text-gray-600">From: {{ $contact->name }}</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Messages
        </a>
    </div>

    <div class="row">
        <!-- Message Content -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-envelope mr-2"></i>{{ $contact->subject ?? 'No Subject' }}
                    </h6>
                    {!! $contact->status_badge !!}
                </div>
                <div class="card-body">
                    <div class="message-content p-3 bg-light rounded mb-4">
                        <p class="mb-0" style="white-space: pre-wrap; line-height: 1.8;">{{ $contact->message }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Received On</small>
                            <p class="mb-0 font-weight-bold">{{ $contact->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Time Ago</small>
                            <p class="mb-0 font-weight-bold">{{ $contact->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.updateStatus', $contact->id) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control" style="max-width: 200px;">
                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user mr-2"></i>Contact Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="text-white font-weight-bold" style="font-size: 2rem;">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </span>
                        </div>
                        <h5 class="mb-1">{{ $contact->name }}</h5>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Email</small>
                        <p class="mb-0">
                            <a href="mailto:{{ $contact->email }}">
                                <i class="fas fa-envelope mr-2 text-primary"></i>{{ $contact->email }}
                            </a>
                        </p>
                    </div>

                    @if($contact->phone)
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Phone</small>
                        <p class="mb-0">
                            <a href="tel:{{ $contact->phone }}">
                                <i class="fas fa-phone mr-2 text-primary"></i>{{ $contact->phone }}
                            </a>
                        </p>
                    </div>
                    @endif

                    @if($contact->service)
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Interested Service</small>
                        <p class="mb-0">
                            <i class="fas fa-cog mr-2 text-primary"></i>{{ $contact->service->title }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-reply mr-2"></i>Reply via Email
                    </a>
                    @if($contact->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}?text=Hi {{ $contact->name }}, thank you for contacting us." 
                       class="btn btn-success btn-block mb-2" target="_blank">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                    </a>
                    <a href="tel:{{ $contact->phone }}" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-phone mr-2"></i>Call
                    </a>
                    @endif
                    <hr>
                    <a href="{{ route('admin.contacts.delete', $contact->id) }}" class="btn btn-outline-danger btn-block" onclick="return confirm('Are you sure you want to delete this message?')">
                        <i class="fas fa-trash mr-2"></i>Delete Message
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@include('admin.footer')
