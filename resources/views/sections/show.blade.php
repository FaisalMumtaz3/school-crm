@extends('layouts.app')

@section('content')

<div class="flex min-h-full w-full flex-col space-y-6">

{{-- Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">
            Section profile
        </p>

        <h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
            {{ $section->name }}
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            {{ $section->schoolClass->name ?? 'Class not assigned' }}
        </p>

    </div>


    <div class="flex items-center gap-3">

        {{-- Back --}}
        <a
            href="{{ route('sections.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 12H5m7 7-7-7 7-7"
                />
            </svg>

            Back
        </a>


        {{-- Edit --}}
        <a
            href="{{ route('sections.edit', $section) }}"
            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182l-9.32 9.32a4.5 4.5 0 0 1-1.897 1.13l-3.14.942.942-3.14a4.5 4.5 0 0 1 1.13-1.897l7.416-7.849Z"
                />
            </svg>

            Edit Section
        </a>

    </div>

</div>


{{-- Section Overview --}}
<section class="flex flex-none flex-col overflow-visible rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Profile Header --}}
    <div class="border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white px-6 py-8">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-indigo-100 text-2xl font-bold text-indigo-700">
                {{ strtoupper(substr($section->name, 0, 1)) }}
            </div>

            <div>

                <h3 class="text-2xl font-bold text-gray-900">
                    {{ $section->name }}
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $section->schoolClass->name ?? 'Class not assigned' }}
                </p>

                <span class="mt-3 inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                    Active Section
                </span>

            </div>

        </div>

    </div>


    {{-- Information --}}
    <div class="p-6">

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Section Name --}}
            <div class="rounded-xl bg-gray-50 p-4">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Section Name
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $section->name }}
                </p>

            </div>


            {{-- Class --}}
            <div class="rounded-xl bg-gray-50 p-4">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Class
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $section->schoolClass->name ?? 'Not assigned' }}
                </p>

            </div>


            {{-- Created Date --}}
            <div class="rounded-xl bg-gray-50 p-4">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Created Date
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $section->created_at?->format('d M Y') ?? 'Not available' }}
                </p>

            </div>


            {{-- Last Updated --}}
            <div class="rounded-xl bg-gray-50 p-4">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Last Updated
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    {{ $section->updated_at?->format('d M Y') ?? 'Not available' }}
                </p>

            </div>

        </div>

    </div>

</section>


{{-- Section Records --}}
<section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <div class="mb-5">

        <h3 class="font-semibold text-gray-900">
            Section Records
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Records related to this section will appear here as modules are added.
        </p>

    </div>


    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Students --}}
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">

            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-8a4 4 0 1 0-8 0 4 4 0 0 0 8 0Zm7-4a4 4 0 1 1-1.17 2.83M22 21v-2a4 4 0 0 0-3-3.87"
                    />
                </svg>
            </div>

            <h4 class="mt-4 font-semibold text-gray-900">
                Students
            </h4>

            <p class="mt-1 text-sm text-gray-500">
                Students in this section will appear here.
            </p>

        </div>


        {{-- Attendance --}}
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">

            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"
                    />
                </svg>
            </div>

            <h4 class="mt-4 font-semibold text-gray-900">
                Attendance
            </h4>

            <p class="mt-1 text-sm text-gray-500">
                Attendance records for this section will appear here.
            </p>

        </div>


        {{-- Academic --}}
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-5">

            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 14.25 4.5 10.5 12 6.75l7.5 3.75-7.5 3.75Zm0 0v5.25m-5.25-3 5.25 3 5.25-3M7.5 12v4.5"
                    />
                </svg>
            </div>

            <h4 class="mt-4 font-semibold text-gray-900">
                Academic Records
            </h4>

            <p class="mt-1 text-sm text-gray-500">
                Academic information for this section will appear here.
            </p>

        </div>

    </div>

</section>

</div>

@endsection
