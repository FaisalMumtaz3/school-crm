@extends('layouts.app')

@section('content')

<div class="mx-auto flex min-h-full w-full max-w-7xl flex-col space-y-6">

{{-- Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

    <div>

        <p class="text-sm font-medium text-indigo-600">
            School Management
        </p>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
            Sections
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Manage school sections and their corresponding classes.
        </p>

    </div>


    <a
        href="{{ route('sections.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
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
                d="M12 4v16m8-8H4"
            />
        </svg>

        Add section

    </a>

</div>


{{-- Success message --}}
@if (session('success'))

    <div
        class="flex shrink-0 items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800"
        role="status"
    >

        <svg
            class="h-5 w-5 shrink-0 text-emerald-600"
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

        {{ session('success') }}

    </div>

@endif


{{-- Section DataTable --}}
@include('sections.partials.SectionDataTable')

</div>

@endsection
