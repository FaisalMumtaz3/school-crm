@extends('layouts.app')

@section('content')
<div class="flex h-full min-h-0 w-full flex-col space-y-6">
    <div class="flex shrink-0 flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">School directory</p>
            <h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">Teachers</h2>
            <p class="mt-2 text-sm text-gray-500">Manage teaching staff, qualifications, and contracts.</p>
        </div>
        <a href="{{ route('teachers.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Add teacher
        </a>
    </div>
    @if (session('success'))
        <div
            class="flex shrink-0 items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800"
            role="status"
        >
            {{ session('success') }}
        </div>
    @endif
    @include('teachers.partials.TeacherDataTable')
</div>
@endsection
