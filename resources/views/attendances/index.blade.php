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
                Attendance
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage and review student attendance.
            </p>
        </div>

        <a href="{{ route('attendances.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">

            <svg class="h-5 w-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Take Attendance
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Filters --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <form method="GET"
            action="{{ route('attendances.index') }}"
            class="attendance-filters p-5">

            {{-- Search --}}
            <div class="attendance-filter-item">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Student name..."
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

            </div>


            {{-- Date --}}
            <div class="attendance-filter-item">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Date
                </label>

                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

            </div>


            {{-- Class --}}
            <div class="attendance-filter-item">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Class
                </label>

                <select
                    name="class"
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                    <option value="">
                        All Classes
                    </option>

                    @foreach($classes as $class)

                        <option
                            value="{{ $class }}"
                            {{ request('class') == $class ? 'selected' : '' }}
                        >
                            {{ $class }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Section --}}
            <div class="attendance-filter-item">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Section
                </label>

                <select
                    name="section"
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                    <option value="">
                        All Sections
                    </option>

                    @foreach($sections as $section)

                        <option
                            value="{{ $section }}"
                            {{ request('section') == $section ? 'selected' : '' }}
                        >
                            {{ $section }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Status --}}
            <div class="attendance-filter-item">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Status
                </label>

                <select
                    name="status"
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                    <option value="">
                        All Status
                    </option>

                    <option value="present"
                        {{ request('status') === 'present' ? 'selected' : '' }}>
                        Present
                    </option>

                    <option value="absent"
                        {{ request('status') === 'absent' ? 'selected' : '' }}>
                        Absent
                    </option>

                    <option value="leave"
                        {{ request('status') === 'leave' ? 'selected' : '' }}>
                        Leave
                    </option>

                </select>

            </div>


            {{-- Buttons --}}
            <div class="attendance-filter-actions">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                >
                    Filter
                </button>

                <a
                    href="{{ route('attendances.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Attendance filter layout --}}
    <style>
        .attendance-filters {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .attendance-filter-item {
            min-width: 0;
        }

        .attendance-filter-actions {
            display: flex;
            align-items: end;
            gap: 0.5rem;
        }

        @media (max-width: 1023px) {
            .attendance-filters {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .attendance-filters {
                grid-template-columns: 1fr;
            }
        }
    </style>



    {{-- DataTable --}}
    <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex shrink-0 items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6">

            <div>
                <h3 class="font-semibold text-gray-900">
                    Attendance Records
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $attendances->total() }} attendance records
                </p>
            </div>

        </div>


        {{-- Table --}}
        <div class="min-h-0 flex-1 overflow-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="sticky top-0 z-10 bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Date
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Roll No
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Student
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Class
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Section
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($attendances as $attendance)

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                {{ $attendance->date->format('d M Y') }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-900">
                                {{ $attendance->student->roll_number ?? '-' }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4">

                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $attendance->student->name }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ $attendance->student->father_name }}
                                </div>

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                {{ $attendance->student->class }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                {{ $attendance->student->section ?: '-' }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4">

                                @if($attendance->status === 'present')

                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Present
                                    </span>

                                @elseif($attendance->status === 'absent')

                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        Absent
                                    </span>

                                @else

                                    <span class="inline-flex items-center rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-semibold text-yellow-700">
                                        Leave
                                    </span>

                                @endif

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-right">

                                <a
                                    href="{{ route('attendances.create', [
                                        'date' => $attendance->date->format('Y-m-d'),
                                        'class' => $attendance->student->class,
                                        'section' => $attendance->student->section,
                                    ]) }}"
                                    class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-800"
                                >
                                    Edit
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">

                                <div class="text-sm font-semibold text-gray-900">
                                    No attendance records found
                                </div>

                                <p class="mt-1 text-sm text-gray-500">
                                    Start by taking attendance for a class.
                                </p>

                                <a
                                    href="{{ route('attendances.create') }}"
                                    class="mt-4 inline-flex rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                                >
                                    Take Attendance
                                </a>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($attendances->hasPages())

            <div class="shrink-0 border-t border-gray-100 px-5 py-4">
                {{ $attendances->links() }}
            </div>

        @endif

    </div>

</div>

@endsection