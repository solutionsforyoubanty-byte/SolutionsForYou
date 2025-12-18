@extends('layouts.admin')
@section('title', 'Edit Job Posting')
@section('header', 'Edit Job Posting')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.careers.index') }}" class="text-primary hover:underline mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Back
    </a>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.careers.update', $career) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Job Title *</label>
                    <input type="text" name="title" value="{{ old('title', $career->title) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" required>
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Department *</label>
                    <input type="text" name="department" value="{{ old('department', $career->department) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" required>
                    @error('department') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Location *</label>
                    <input type="text" name="location" value="{{ old('location', $career->location) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" required>
                    @error('location') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Job Type *</label>
                    <select name="type" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" required>
                        @foreach(['Full-time', 'Part-time', 'Contract', 'Internship'] as $type)
                            <option value="{{ $type }}" {{ $career->type === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Salary Range</label>
                    <input type="text" name="salary_range" value="{{ old('salary_range', $career->salary_range) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Job Description *</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" required>{{ old('description', $career->description) }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Requirements *</label>
                <textarea name="requirements" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" required>{{ old('requirements', $career->requirements) }}</textarea>
                @error('requirements') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $career->is_active ? 'checked' : '' }} class="rounded">
                    <span class="text-sm">Active (visible on website)</span>
                </label>
            </div>

            <button class="bg-primary hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-save mr-1"></i> Update Job Posting
            </button>
        </form>
    </div>
</div>
@endsection
