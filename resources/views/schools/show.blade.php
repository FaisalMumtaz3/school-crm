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
                {{ $school->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                School code: {{ $school->code }} • {{ $school->status === 'active' ? 'Active' : 'Inactive' }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-secondary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <a href="{{ route('admin.schools.permissions', $school) }}" class="btn btn-primary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg>
                Permissions
            </a>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Schools
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-success-200 bg-success-50 px-4 py-3 text-sm font-medium text-success-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- School Details & Stats --}}
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 flex items-center gap-2">
                    <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    School Details
                </h5>
            </div>
            <div class="card-body">
                <dl class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-gray-900 font-medium">{{ $school->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Code</dt>
                            <dd class="mt-1 text-gray-900 font-mono font-medium">{{ $school->code }}</dd>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-gray-900">{{ $school->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-gray-900">{{ $school->phone ?? '<span class="text-gray-400">Not provided</span>' }}</dd>
                        </div>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $school->address ?? '<span class="text-gray-400">Not provided</span>' }}</dd>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $school->status === 'active' ? 'bg-success-100 text-success-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($school->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-gray-900">{{ $school->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 flex items-center gap-2">
                    <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 rounded-xl bg-gray-50">
                        <p class="text-3xl font-bold text-gray-900">{{ $school->students_count }}</p>
                        <p class="text-sm text-gray-500">Students</p>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-gray-50">
                        <p class="text-3xl font-bold text-gray-900">{{ $school->teachers_count }}</p>
                        <p class="text-sm text-gray-500">Teachers</p>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-gray-50">
                        <p class="text-3xl font-bold text-gray-900">{{ $school->users_count }}</p>
                        <p class="text-sm text-gray-500">Users</p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="text-center p-4 rounded-xl bg-primary-50">
                        <p class="text-xl font-bold text-primary-700">{{ $school->classes_count ?? 0 }}</p>
                        <p class="text-sm text-primary-600">Classes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Users --}}
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h5 class="card-title mb-0 flex items-center gap-2">
                <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users ({{ $school->users->count() }})
            </h5>
            <a href="{{ route('admin.schools.create') }}" class="btn btn-sm btn-primary hidden">Add User</a>
        </div>
        <div class="card-body p-0">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">User</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Role</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Created</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($school->users as $user)
                            <tr class="transition hover:bg-gray-50">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100 text-sm font-bold text-primary-700">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    @php
                                        $roleClass = match($user->role) {
                                            'admin' => 'bg-danger-100 text-danger-800',
                                            'school_admin' => 'bg-primary-100 text-primary-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $roleClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $user->is_active ? 'bg-success-100 text-success-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>

                                <td class="relative whitespace-nowrap px-5 py-4 text-right">
                                    <details class="user-actions relative inline-block">
                                        <summary aria-label="Open actions for {{ $user->name }}"
                                               class="flex h-9 w-9 cursor-pointer list-none items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 [&::-webkit-details-marker]:hidden">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M12 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>
                                            </svg>
                                        </summary>

                                        <div class="absolute right-0 top-full z-[9999] mt-2 w-40 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 text-left shadow-xl">
                                            <a href="{{ route('admin.users.edit', $user) ?? '#' }}"
                                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary-700">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user) ?? '#' }}" method="POST" class="delete-user-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-danger-600 hover:bg-danger-50"
                                                        data-user-name="{{ $user->name }}">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </details>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 mb-3">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900">No users found</p>
                                    <p class="mt-1 text-sm text-gray-500">Users are created when a school is created or by the school admin.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Permissions Overview --}}
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h5 class="card-title mb-0 flex items-center gap-2">
                <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg>
                Permissions
            </h5>
            <a href="{{ route('admin.schools.permissions', $school) }}" class="btn btn-sm btn-primary">Manage Permissions</a>
        </div>
        <div class="card-body">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($school->permissions as $permission)
                    <div class="flex items-center gap-3 p-4 rounded-xl
                        {{ $permission->enabled ? 'bg-success-50 border border-success-200' : 'bg-gray-50 border border-gray-200' }}">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg
                            {{ $permission->enabled ? 'bg-success-100 text-success-600' : 'bg-gray-100 text-gray-400' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg>
                        </span>
                        <div>
                            <p class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $permission->feature)) }}</p>
                            <p class="text-xs
                                {{ $permission->enabled ? 'text-success-600' : 'text-gray-500' }}">
                                {{ $permission->enabled ? 'Enabled' : 'Disabled' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    /* Close action menus when clicking outside */
    document.addEventListener('click', function (event) {
        if (event.target.closest('.user-actions') || event.target.closest('.school-actions')) return;
        document.querySelectorAll('.user-actions[open], .school-actions[open]').forEach(function (menu) {
            menu.removeAttribute('open');
        });
    });

    /* Close action menu with Escape */
    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') return;
        document.querySelectorAll('.user-actions[open], .school-actions[open]').forEach(function (menu) {
            menu.removeAttribute('open');
        });
    });

    /* Delete confirmation */
    document.addEventListener('submit', function (event) {
        const form = event.target.closest('.delete-user-form');
        if (!form) return;
        const name = form.dataset.userName;
        if (!confirm('Delete "' + name + '"? This action cannot be undone.')) {
            event.preventDefault();
        }
    });
});
</script>
@endsection