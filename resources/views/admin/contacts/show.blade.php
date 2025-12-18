@extends('layouts.admin')
@section('title', 'View Message')
@section('header', 'View Message')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.contacts.index') }}" class="text-primary hover:underline mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Back to Messages
    </a>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-lg">{{ $contact->subject }}</h3>
                <p class="text-sm text-gray-500">From: {{ $contact->name }} ({{ $contact->email }})</p>
            </div>
            <form action="{{ route('admin.contacts.status', $contact) }}" method="POST" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <select name="status" class="border rounded px-3 py-1 text-sm">
                    <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>New</option>
                    <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                    <option value="closed" {{ $contact->status === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-sm">Update</button>
            </form>
        </div>
        <div class="p-6">
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-500 mb-2">{{ $contact->created_at->format('d M Y, h:i A') }}</p>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->message }}</p>
            </div>

            @if($contact->admin_reply)
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                <p class="text-sm text-green-600 mb-2">
                    <i class="fas fa-reply mr-1"></i> Your Reply ({{ $contact->replied_at->format('d M Y, h:i A') }})
                </p>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->admin_reply }}</p>
            </div>
            @endif

            <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                @csrf
                <label class="block font-medium mb-2">{{ $contact->admin_reply ? 'Update Reply' : 'Send Reply' }}</label>
                <textarea name="admin_reply" rows="4" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Type your reply...">{{ $contact->admin_reply }}</textarea>
                @error('admin_reply') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                <button class="mt-3 bg-primary hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-paper-plane mr-1"></i> Send Reply
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
