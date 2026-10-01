@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-primary-600">
                Administration
            </p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                Schools Management
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Manage schools, administrators, and access permissions.
            </p>
        </div>

        <a href="{{ route('admin.schools.create') }}"
           class="btn btn-primary">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add School
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-success-200 bg-success-50 px-4 py-3 text-sm font-medium text-success-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Schools Table --}}
    <div class="card overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">School</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Code</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Phone</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 hidden md:table-cell">Stats</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Created</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($schools as $school)
                        <tr class="transition hover:bg-gray-50">
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100 text-sm font-bold text-primary-700">
                                        {{ strtoupper(substr($school->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $school->name }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">{{ $school->address ?? 'No address' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 font-mono">{{ $school->code }}</td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $school->email }}</td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $school->phone ?? '-' }}</td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $school->status === 'active' ? 'bg-success-100 text-success-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($school->status) }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 hidden md:table-cell">
                                <div class="flex items-center gap-4">
                                    <div class="text-center">
                                        <p class="font-semibold text-gray-900">{{ $school->students_count }}</p>
                                        <p class="text-xs text-gray-500">Students</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="font-semibold text-gray-900">{{ $school->teachers_count }}</p>
                                        <p class="text-xs text-gray-500">Teachers</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="font-semibold text-gray-900">{{ $school->users_count }}</p>
                                        <p class="text-xs text-gray-500">Users</p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $school->created_at->format('M d, Y') }}</td>

                            <td class="whitespace-nowrap px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.schools.show', $school) }}"
                                       class="btn btn-sm btn-ghost text-gray-500 hover:text-primary-600 hover:bg-primary-50"
                                       title="View Details">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.schools.edit', $school) }}"
                                       class="btn btn-sm btn-ghost text-gray-500 hover:text-primary-600 hover:bg-primary-50"
                                       title="Edit">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.schools.permissions', $school) }}"
                                       class="btn btn-sm btn-ghost text-gray-500 hover:text-info-600 hover:bg-info-50"
                                       title="Permissions">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.schools.destroy', $school) }}" method="POST" class="delete-school-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-ghost text-gray-500 hover:text-danger-600 hover:bg-danger-50"
                                                data-school-name="{{ $school->name }}"
                                                title="Delete">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-16 text-center">
                                <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 mb-4">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-900">No schools found</p>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating your first school.</p>
                                <a href="{{ route('admin.schools.create') }}" class="mt-4 inline-flex items-center gap-2 btn btn-primary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add School
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($schools->hasPages())
            <div class="card-footer flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-500">Showing {{ $schools->firstItem() }} to {{ $schools->lastItem() }} of {{ $schools->total() }} results</p>
                <div class="flex items-center gap-2">
                    {{ $schools->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<script>
/* Delete confirmation */
document.addEventListener('submit', function (event) {
    const form = event.target.closest('.delete-school-form');
    if (!form) return;
    const name = form.dataset.schoolName;
    if (!confirm('Delete "' + name + '"? This will also delete all associated data (students, teachers, fees, attendance). This action cannot be undone.')) {
        event.preventDefault();
    }
});
</script>
@endsection