@extends('layouts.app')

@php
    use App\Models\SchoolPermission;
@endphp

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-primary-600">
                Administration
            </p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                Permissions: {{ $school->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Control feature access and action permissions for this school.
            </p>
        </div>

        <a href="{{ route('admin.schools.show', $school) }}" class="btn btn-secondary">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to School
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-success-200 bg-success-50 px-4 py-3 text-sm font-medium text-success-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Permissions Form --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0 flex items-center gap-2">
                <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg>
                Feature Access Control
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schools.permissions.update', $school) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Feature-level toggles --}}
                <div class="border-b border-gray-200 pb-6">
                    <h6 class="text-sm font-semibold text-gray-900 mb-4">Features (Master Toggle)</h6>
                    <p class="text-xs text-gray-500 mb-4">Disable a feature to hide it completely from navigation and block all access.</p>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($features as $feature => $label)
                            <div class="p-4 rounded-xl border
                                {{ ($school->permissions->firstWhere('feature', $feature)?->enabled ?? true) ? 'bg-success-50 border-success-200' : 'bg-gray-50 border-gray-200' }}
                                transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg
                                        {{ ($school->permissions->firstWhere('feature', $feature)?->enabled ?? true) ? 'bg-success-100 text-success-600' : 'bg-gray-100 text-gray-400' }}
                                        flex-shrink-0">
                                        @include('schools._feature_icon', ['feature' => $feature])
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox"
                                                   name="permissions[{{ $feature }}]"
                                                   value="1"
                                                   class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500 feature-toggle"
                                                   data-feature="{{ $feature }}"
                                                   {{ ($school->permissions->firstWhere('feature', $feature)?->enabled ?? true) ? 'checked' : '' }}>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $label }}</p>
                                                <p class="text-xs text-gray-500">{{ $feature }} management</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action-level permissions --}}
                <div>
                    <h6 class="text-sm font-semibold text-gray-900 mb-4">Actions (Granular Control)</h6>
                    <p class="text-xs text-gray-500 mb-4">Fine-tune what each role can do within enabled features. Requires feature to be enabled above.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-4 py-2 text-left font-semibold text-gray-500">Feature</th>
                                    @foreach (SchoolPermission::availableActions() as $actionKey => $actionLabel)
                                        <th class="px-4 py-2 text-center font-semibold text-gray-500">{{ $actionLabel }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($features as $feature => $label)
                                    @php
                                        $permission = $school->permissions->firstWhere('feature', $feature);
                                        $enabled = $permission->enabled ?? true;
                                        $actions = $permission->getActions() ?? [];
                                    @endphp
                                    <tr class="{{ !$enabled ? 'opacity-50 bg-gray-50' : '' }}">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-8 w-8 items-center justify-center rounded-lg
                                                    {{ $enabled ? 'bg-primary-100 text-primary-600' : 'bg-gray-100 text-gray-400' }}">
                                                    @include('schools._feature_icon', ['feature' => $feature])
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $label }}</p>
                                                    <p class="text-xs text-gray-500">{{ $feature }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach (SchoolPermission::availableActions() as $actionKey => $actionLabel)
                                            <td class="px-4 py-3 text-center">
                                                <label class="inline-flex items-center justify-center cursor-pointer {{ !$enabled ? 'pointer-events-none opacity-50' : '' }}">
                                                    <input type="checkbox"
                                                           name="actions[{{ $feature }}][{{ $actionKey }}]"
                                                           value="1"
                                                           class="form-checkbox h-4 w-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500 action-checkbox"
                                                           data-feature="{{ $feature }}"
                                                           {{ ($enabled && ($actions[$actionKey] ?? true)) ? 'checked' : '' }}
                                                           {{ !$enabled ? 'disabled' : '' }}>
                                                </label>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.schools.show', $school) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Save Permissions
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Help Info --}}
    <div class="card bg-blue-50 border-blue-200">
        <div class="card-body">
            <div class="flex gap-3">
                <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="font-medium text-blue-800">How Permissions Work</p>
                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                        <li>• <strong>Feature Toggle (top):</strong> Master on/off. If disabled, feature is hidden and all actions blocked.</li>
                        <li>• <strong>Action Toggles (table):</strong> Granular control per feature. Only works when feature is enabled.</li>
                        <li>• <strong>Actions:</strong> View = list/show, Create = add new, Edit = modify existing, Delete = remove records.</li>
                        <li>• <strong>School Admin:</strong> Can only access features/actions enabled for their school.</li>
                        <li>• <strong>Super Admin:</strong> Always has full access to all features and actions.</li>
                        <li>• <strong>Immediate effect:</strong> Changes apply on next page load.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Feature toggle controls action checkboxes
    document.querySelectorAll('.feature-toggle').forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            const feature = this.dataset.feature;
            const enabled = this.checked;

            // Enable/disable action checkboxes for this feature
            document.querySelectorAll('.action-checkbox[data-feature="' + feature + '"]').forEach(function (checkbox) {
                checkbox.disabled = !enabled;
                if (!enabled) {
                    checkbox.checked = false;
                }
            });

            // Visual feedback for the feature row
            const row = document.querySelector('tr[data-feature="' + feature + '"]');
            if (row) {
                row.classList.toggle('opacity-50', !enabled);
                row.classList.toggle('bg-gray-50', !enabled);
            }
        });
    });

    // Add data-feature to table rows for JS targeting
    document.querySelectorAll('tbody tr').forEach(function (row) {
        const checkbox = row.querySelector('.action-checkbox');
        if (checkbox) {
            row.dataset.feature = checkbox.dataset.feature;
        }
    });
});
</script>
@endpush
@endsection