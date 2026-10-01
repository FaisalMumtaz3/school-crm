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
                Create New School
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Set up a new school with admin account and default permissions.
            </p>
        </div>

        <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Schools
        </a>
    </div>

    {{-- Form --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">School Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schools.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Row 1: Name & Code --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="form-label">School Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-input @error('name') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="code" class="form-label">School Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-input @error('code') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="code" name="code" value="{{ old('code') }}" required maxlength="50"
                               placeholder="e.g., SCH001">
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
                               id="email" name="email" value="{{ old('email') }}" required
                               placeholder="school@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-input @error('phone') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                               id="phone" name="phone" value="{{ old('phone') }}"
                               placeholder="+92 300 1234567">
                        @error('phone')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 3: Address --}}
                <div>
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-input @error('address') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                              id="address" name="address" rows="3"
                              placeholder="Complete address of the school"></textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row 4: Status --}}
                <div>
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-input form-select @error('status') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                            id="status" name="status" required>
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Inactive schools cannot be accessed by their users.</p>
                </div>

                <hr class="border-gray-200">

                {{-- School Admin Account --}}
                <div class="pt-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">School Admin Account</h3>
                    <p class="text-sm text-gray-500 mb-4">Create the initial school administrator account. Credentials will be shared with the school.</p>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="admin_name" class="form-label">Admin Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-input @error('admin_name') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                                   id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required>
                            @error('admin_name')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="admin_email" class="form-label">Admin Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-input @error('admin_email') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                                   id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required
                                   placeholder="admin@school.com">
                            @error('admin_email')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="admin_password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-input @error('admin_password') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                                   id="admin_password" name="admin_password" required minlength="8">
                            @error('admin_password')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                        </div>
                        <div>
                            <label for="admin_password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-input @error('admin_password_confirmation') border-danger-500 focus:border-danger-500 focus:ring-danger-500 @enderror"
                                   id="admin_password_confirmation" name="admin_password_confirmation" required>
                            @error('admin_password_confirmation')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Create School
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection