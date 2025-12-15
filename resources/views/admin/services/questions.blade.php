@include('admin.header')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Service Questions</h1>
            <p class="mb-0 text-gray-600">
                <i class="fas fa-briefcase"></i> 
                <strong>{{ $service->title }}</strong> - Manage inquiry questions
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('service.show', $service->slug) }}" 
               target="_blank"
               class="btn btn-sm btn-info shadow-sm">
                <i class="fas fa-eye fa-sm text-white-50"></i> Preview Service
            </a>
            <a href="{{ route('services.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Services
            </a>
        </div>
    </div>

    <!-- Service Info Card -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img src="{{ $service->image_url }}" 
                                 alt="{{ $service->title }}"
                                 class="rounded"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <div class="col">
                            <h5 class="mb-1">{{ $service->title }}</h5>
                            <p class="mb-0 text-muted">{{ $service->short_description }}</p>
                        </div>
                        <div class="col-auto">
                            <div class="text-center">
                                <h2 class="mb-0 text-primary">{{ $questions->count() }}</h2>
                                <small class="text-muted">Total Questions</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Add New Question Form -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-gradient-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-plus-circle"></i> Add New Question
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.questions.add') }}" method="POST" id="addQuestionForm">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        
                        <div class="mb-3">
                            <label for="question" class="form-label fw-bold">Question Text</label>
                            <textarea 
                                name="question" 
                                id="question"
                                class="form-control @error('question') is-invalid @enderror" 
                                placeholder="Enter your question here... (e.g., What is your budget range?)"
                                rows="4"
                                required></textarea>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                This question will appear when users request a quote for this service
                            </small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card shadow mt-4 border-left-info">
                <div class="card-body">
                    <h6 class="text-info mb-3">
                        <i class="fas fa-lightbulb"></i> Question Tips
                    </h6>
                    <ul class="small mb-0 text-muted">
                        <li class="mb-2">Keep questions clear and specific</li>
                        <li class="mb-2">Ask about budget, timeline, or project scope</li>
                        <li class="mb-2">Limit to 3-5 essential questions</li>
                        <li>Questions help qualify leads better</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Existing Questions List -->
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list"></i> Existing Questions ({{ $questions->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    
                    @if($questions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60">#</th>
                                        <th>Question</th>
                                        <th width="150">Added On</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $index => $q)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ $index + 1 }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-gray-800">{{ $q->question }}</div>
                                                <small class="text-muted">ID: {{ $q->id }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $q->created_at->format('M d, Y') }}<br>
                                                    {{ $q->created_at->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-warning"
                                                            onclick="editQuestion({{ $q->id }}, '{{ addslashes($q->question) }}')"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger"
                                                            onclick="deleteQuestion({{ $q->id }}, '{{ addslashes($q->question) }}')"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-question-circle fa-4x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-600">No Questions Yet</h5>
                            <p class="text-gray-500 mb-4">
                                Add your first question to start collecting information from potential clients.
                            </p>
                            <button class="btn btn-primary" onclick="document.getElementById('question').focus()">
                                <i class="fas fa-plus"></i> Add First Question
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

</div>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Edit Question
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editQuestionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_question" class="form-label fw-bold">Question Text</label>
                        <textarea 
                            name="question" 
                            id="edit_question"
                            class="form-control" 
                            rows="4"
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
// Edit question function
function editQuestion(id, question) {
    document.getElementById('edit_question').value = question;
    document.getElementById('editQuestionForm').action = `/admin/service-questions/update/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('editQuestionModal'));
    modal.show();
}

// Delete question function
function deleteQuestion(id, question) {
    Swal.fire({
        title: 'Are you sure?',
        html: `You want to delete this question?<br><br><em>"${question}"</em>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            window.location.href = `/admin/service-questions/delete/${id}`;
        }
    });
}

// Show success message if present
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

@if(session('error'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 3000
    });
@endif

// Form validation
document.getElementById('addQuestionForm').addEventListener('submit', function(e) {
    const question = document.getElementById('question').value.trim();
    
    if(question.length < 10) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Question too short',
            text: 'Please enter a question with at least 10 characters.'
        });
        return false;
    }
});
</script>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.bg-gradient-primary {
    background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
}

.card {
    border: none;
}
</style>