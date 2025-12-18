@extends('layouts.admin')
@section('title', 'View Application')
@section('header', 'View Application')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.careers.applications') }}" class="text-primary hover:underline mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Back to Applications
    </a>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Applicant Details</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500">Name</label>
                        <p class="font-medium">{{ $application->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <p class="font-medium">{{ $application->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Phone</label>
                        <p class="font-medium">{{ $application->phone }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Applied For</label>
                        <p class="font-medium">{{ $application->career->title ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($application->cover_letter)
                <div class="mt-6">
                    <label class="text-sm text-gray-500">Cover Letter</label>
                    <div class="mt-2 bg-gray-50 rounded-lg p-4 text-sm whitespace-pre-wrap">{{ $application->cover_letter }}</div>
                </div>
                @endif

                @if($application->resume)
                <div class="mt-6">
                    <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-file-pdf"></i> View Resume
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold mb-4">Update Status</h3>
                <form action="{{ route('admin.careers.applications.status', $application) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" class="w-full border rounded-lg px-4 py-2">
                            <option value="new" {{ $application->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="reviewing" {{ $application->status === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                            <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>Hired</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Admin Notes</label>
                        <textarea name="admin_notes" rows="3" class="w-full border rounded-lg px-4 py-2 text-sm">{{ $application->admin_notes }}</textarea>
                    </div>
                    <button class="w-full bg-primary hover:bg-blue-700 text-white py-2 rounded-lg">
                        Update
                    </button>
                </form>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mt-4 text-sm text-gray-500">
                <p><i class="fas fa-clock mr-1"></i> Applied: {{ $application->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
