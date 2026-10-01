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
                Edit User: {{ $user->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Update user information and settings.
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Users
        </a>
    </div>

    {{-- Form --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">User Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-input @error('name') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-input @error('email') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-input @error('password') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="password" name="password" minlength="8">
                        @error('password')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password</p>
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-input @error('password_confirmation') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-input form-select @error('role') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                                id="role" name="role" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="school_id" class="form-label">School <span class="text-danger">*</span></label>
                        <select class="form-input form-select @error('school_id') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                                id="school_id" name="school_id" required>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id', $user->school_id) == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500"
                               id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection