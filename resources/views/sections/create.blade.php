@extends('layouts.app')

@section('content')

<div class="flex min-h-full w-full flex-col space-y-6">

{{-- Header --}}
<div>
    <a
        href="{{ route('sections.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 transition hover:text-indigo-600"
    >
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 12H5m7 7-7-7 7-7"
            />
        </svg>

        Back to Sections
    </a>

    <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
        Create Section
    </h2>

    <p class="mt-2 text-sm text-gray-500">
        Add a reusable section such as A or B.
    </p>
</div>


{{-- Form --}}
<section class="rounded-2xl border border-gray-200 bg-white shadow-sm">

    <form
        method="POST"
        action="{{ route('sections.store') }}"
        class="p-6"
    >

        @csrf

        <div class="grid grid-cols-1 gap-6">

            {{-- Section Name --}}
            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Section Name
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Red, White, Blue"
                    class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >

                @error('name')
                    <p class="mt-2 text-sm font-medium text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>


        </div>


        {{-- Actions --}}
        <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6">

            <a
                href="{{ route('sections.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                Create Section
            </button>

        </div>

    </form>

</section>

</div>

@endsection
