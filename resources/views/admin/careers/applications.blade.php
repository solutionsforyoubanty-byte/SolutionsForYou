@extends('layouts.admin')
@section('title', 'Job Applications')
@section('header', 'Job Applications')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.careers.index') }}" class="text-primary hover:underline">
        <i class="fas fa-arrow-left mr-1"></i> Back to Jobs
    </a>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($applications as $app)
                <tr class="{{ $app->status === 'new' ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4">
                        <span class="font-medium">{{ $app->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $app->career->title ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div>{{ $app->email }}</div>
                        <div class="text-gray-400">{{ $app->phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'new' => 'bg-blue-100 text-blue-700',
                                'reviewing' => 'bg-yellow-100 text-yellow-700',
                                'shortlisted' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'hired' => 'bg-purple-100 text-purple-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$app->status] }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $app->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.careers.applications.show', $app) }}" class="text-primary hover:text-blue-700">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.careers.applications.destroy', $app) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No applications yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $applications->links() }}</div>
</div>
@endsection
