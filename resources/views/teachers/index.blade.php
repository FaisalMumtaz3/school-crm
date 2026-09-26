@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-primary-600">School Directory</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">Teachers</h1>
            <p class="mt-1 text-sm text-gray-500">Manage teaching staff, qualifications, and contracts.</p>
        </div>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Add Teacher
        </a>
    </div>
    @if (session('success'))
        <div
            class="flex items-center gap-3 rounded-xl border border-success-200 bg-success-50 px-4 py-3 text-sm font-medium text-success-800"
            role="status"
        >
            {{ session('success') }}
        </div>
    @endif
    @include('teachers.partials.TeacherDataTable')
</div>
@endsection