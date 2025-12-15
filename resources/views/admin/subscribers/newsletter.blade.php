@include('admin.header')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Send Newsletter</h1>
            <p class="mb-0 text-gray-600">Send email to all active subscribers</p>
        </div>
        <a href="{{ route('subscribers.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Subscribers
        </a>
    </div>

    <!-- Info Card -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Recipients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActive }} Active Subscribers</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-envelope-open-text"></i> Compose Newsletter
            </h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($totalActive > 0)
                <form action="{{ route('subscribers.newsletter.send') }}" method="POST" id="newsletterForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="subject" class="font-weight-bold">
                            <i class="fas fa-heading"></i> Email Subject <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="subject" 
                               id="subject" 
                               class="form-control @error('subject') is-invalid @enderror" 
                               placeholder="Enter email subject..."
                               value="{{ old('subject') }}"
                               required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message" class="font-weight-bold">
                            <i class="fas fa-align-left"></i> Email Content <span class="text-danger">*</span>
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  class="form-control @error('message') is-invalid @enderror" 
                                  rows="12" 
                                  placeholder="Write your newsletter content here... (HTML supported)"
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">You can use HTML tags for formatting.</small>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning:</strong> This will send email to <strong>{{ $totalActive }}</strong> subscribers. 
                        Make sure your email content is correct before sending.
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg" id="sendBtn">
                            <i class="fas fa-paper-plane"></i> Send Newsletter
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="previewEmail()">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users-slash fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">No Active Subscribers</h5>
                    <p class="text-gray-500">You need active subscribers to send a newsletter.</p>
                    <a href="{{ route('subscribers.index') }}" class="btn btn-primary">
                        <i class="fas fa-users"></i> View Subscribers
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Tips Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fas fa-lightbulb"></i> Newsletter Tips
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6><i class="fas fa-check text-success"></i> Keep it Short</h6>
                    <p class="small text-muted">People prefer concise emails. Get to the point quickly.</p>
                </div>
                <div class="col-md-4">
                    <h6><i class="fas fa-check text-success"></i> Clear Subject</h6>
                    <p class="small text-muted">Use a compelling subject line that tells what's inside.</p>
                </div>
                <div class="col-md-4">
                    <h6><i class="fas fa-check text-success"></i> Call to Action</h6>
                    <p class="small text-muted">Include a clear CTA button or link for engagement.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Email Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Subject:</strong> <span id="previewSubject"></span></p>
                <hr>
                <div id="previewContent" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function previewEmail() {
    const subject = document.getElementById('subject').value || 'No Subject';
    const message = document.getElementById('message').value || 'No Content';
    
    document.getElementById('previewSubject').textContent = subject;
    document.getElementById('previewContent').innerHTML = message;
    
    $('#previewModal').modal('show');
}

document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('sendBtn');
    if (!confirm('Are you sure you want to send this newsletter to all subscribers?')) {
        e.preventDefault();
        return;
    }
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
});
</script>

@include('admin.footer')
