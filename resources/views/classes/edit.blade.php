@extends('layouts.app')

@section('content')

<div class="student-form-page flex min-h-full w-full flex-col">

{{-- Header --}}
<div class="mb-8">

    <a
        href="{{ route('classes.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 transition hover:text-indigo-600"
    >
        <svg
            class="h-4 w-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m15 18-6-6 6-6"
            />
        </svg>

        Back to classes
    </a>

    <p class="mt-6 text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">
        School directory
    </p>

    <h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
        Edit class
    </h2>

    <p class="mt-2 text-sm text-gray-500">
        Update the information for {{ $schoolClass->name }}.
    </p>

</div>


{{-- Validation Errors --}}
@if ($errors->any())

    <div
        class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
        role="alert"
    >
        <p class="font-semibold">
            Please correct the highlighted fields.
        </p>

        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif


{{-- Form Card --}}
<section
    class="student-form-card flex flex-1 flex-col overflow-visible rounded-2xl border border-gray-200 bg-white shadow-sm"
>

    <form
        action="{{ route('classes.update', $schoolClass) }}"
        method="POST"
        class="student-form flex flex-1 flex-col px-6 py-6 sm:px-8 sm:py-8"
    >

        @csrf
        @method('PUT')

        <div class="grid gap-6 sm:grid-cols-2">

            {{-- Class Name --}}
            <div>

                <label
                    for="name"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Class
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $schoolClass->name) }}"
                    required
                    autofocus
                    maxlength="255"
                    class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror"
                >

                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>


        {{-- Form Actions --}}
        <div
            class="student-form-actions mt-auto flex flex-col-reverse gap-3 border-t border-gray-100 pt-8 sm:flex-row sm:justify-end"
        >

            <a
                href="{{ route('classes.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m5 12 4 4L19 6"
                    />
                </svg>

                Save changes
            </button>

        </div>

    </form>

</section>

</div>

@endsection
