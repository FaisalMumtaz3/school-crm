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
                Edit School: {{ $school->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Update school information and settings.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.schools.permissions', $school) }}" class="btn btn-secondary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg>
                Permissions
            </a>
            <a href="{{ route('admin.schools.show', $school) }}" class="btn btn-secondary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                View
            </a>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back
            </a>
        </div>
    </div>

    {{-- Form --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">School Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schools.update', $school) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Row 1: Name & Code --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="form-label">School Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-input @error('name') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="name" name="name" value="{{ old('name', $school->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="code" class="form-label">School Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-input @error('code') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="code" name="code" value="{{ old('code', $school->code) }}" required maxlength="50">
                        @error('code')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 2: Email & Phone --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-input @error('email') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="email" name="email" value="{{ old('email', $school->email) }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-input @error('phone') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="phone" name="phone" value="{{ old('phone', $school->phone) }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 3: Address --}}
                <div>
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-input @error('address') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                              id="address" name="address" rows="3">{{ old('address', $school->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row 4: Status --}}
                <div>
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-input form-select @error('status') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                            id="status" name="status" required>
                        <option value="active" {{ old('status', $school->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $school->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Inactive schools cannot be accessed by their users.</p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Update School
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection