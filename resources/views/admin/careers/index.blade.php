@extends('layouts.admin')
@section('title', 'Manage Careers')
@section('header', 'Manage Careers')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="flex gap-3">
        <a href="{{ route('admin.careers.create') }}" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-1"></i> Add Job
        </a>
        <a href="{{ route('admin.careers.applications') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-users mr-1"></i> Applications
            @php $newApps = \App\Models\JobApplication::where('status', 'new')->count(); @endphp
            @if($newApps > 0)
                <span class="bg-white text-green-600 px-2 py-0.5 rounded-full text-xs ml-1">{{ $newApps }}</span>
            @endif
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applications</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($careers as $career)
                <tr>
                    <td class="px-6 py-4 font-medium">{{ $career->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $career->department }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $career->location }}</td>
                    <td class="px-6 py-4 text-sm">{{ $career->type }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">{{ $career->applications_count }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $career->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $career->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.careers.edit', $career) }}" class="text-primary hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.careers.destroy', $career) }}" method="POST" onsubmit="return confirm('Delete this job?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No job postings yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $careers->links() }}</div>
</div>
@endsection
