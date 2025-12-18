@extends('layouts.admin')
@section('title', 'Contact Messages')
@section('header', 'Contact Messages')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="font-semibold">All Messages</h3>
        <div class="flex gap-2 text-sm">
            @php $newCount = \App\Models\Contact::where('status', 'new')->count(); @endphp
            @if($newCount > 0)
                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full">{{ $newCount }} New</span>
            @endif
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($contacts as $contact)
                <tr class="{{ $contact->status === 'new' ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4">
                        <span class="font-medium {{ $contact->status === 'new' ? 'text-primary' : '' }}">{{ $contact->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->email }}</td>
                    <td class="px-6 py-4 text-sm">{{ Str::limit($contact->subject, 30) }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'new' => 'bg-blue-100 text-blue-700',
                                'read' => 'bg-gray-100 text-gray-700',
                                'replied' => 'bg-green-100 text-green-700',
                                'closed' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$contact->status] }}">
                            {{ ucfirst($contact->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="text-primary hover:text-blue-700">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No messages yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $contacts->links() }}</div>
</div>
@endsection
