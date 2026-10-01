@extends('layouts.app')

@section('content')

<div class="space-y-6">

{{-- Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-primary-600">
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
       class="btn btn-primary">

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

    <div class="flex items-center gap-3 rounded-xl border border-success-200 bg-success-50 px-4 py-3 text-sm font-medium text-success-800">
        {{ session('success') }}
    </div>

@endif


{{-- Filters --}}
<div class="card">

    <form method="GET"
        action="{{ route('attendances.index') }}"
        class="attendance-filters p-6">

        {{-- Search --}}
        <div class="attendance-filter-item">

            <label class="form-label">
                Search
            </label>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Student name..."
                class="form-input"
            >

        </div>


        {{-- Date --}}
        <div class="attendance-filter-item">

            <label class="form-label">
                Date
            </label>

            <input
                type="date"
                name="date"
                value="{{ request('date') }}"
                class="form-input"
            >

        </div>


        {{-- Class --}}
        <div class="attendance-filter-item">

            <label class="form-label">
                Class
            </label>

            <select
                name="class"
                class="form-input form-select"
            >

                <option value="">
                    All Classes
                </option>

                @foreach($classes as $class)

                    <option
                        value="{{ $class->id }}"
                        {{ (string) request('class') === (string) $class->id ? 'selected' : '' }}
                    >
                        {{ $class->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Section --}}
        <div class="attendance-filter-item">

            <label class="form-label">
                Section
            </label>

            <select
                name="section"
                class="form-input form-select"
            >

                <option value="">
                    All Sections
                </option>

                @foreach($sections as $section)

                    <option
                        value="{{ $section->id }}"
                        {{ (string) request('section') === (string) $section->id ? 'selected' : '' }}
                    >
                        {{ $section->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Status --}}
        <div class="attendance-filter-item">

            <label class="form-label">
                Status
            </label>

            <select
                name="status"
                class="form-input form-select"
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
                class="btn btn-primary"
            >
                Filter
            </button>

            <a
                href="{{ route('attendances.index') }}"
                class="btn btn-secondary"
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
<div class="card overflow-hidden">

    {{-- Table Header --}}
    <div class="card-header">

        <div>
            <h3 class="font-semibold text-gray-900">
                Attendance Records
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                {{ $attendances->total() }} attendance records
                {{ auth()->user()->isAdmin() ? 'across all schools' : '' }}
            </p>
        </div>

    </div>


    {{-- Table --}}
    <div class="table-container">

        <table class="table">

            <thead>

                <tr>

                    @if (auth()->user()->isAdmin())
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        School
                    </th>
                    @endif

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


            <tbody class="divide-y divide-gray-100">

                @forelse($attendances as $attendance)

                    <tr class="transition hover:bg-gray-50">

                        @if (auth()->user()->isAdmin())
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                            <span class="badge badge-success">{{ $attendance->school->name ?? 'N/A' }}</span>
                        </td>
                        @endif

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
                            {{ $attendance->student->schoolClass?->name ?? '-' }}
                        </td>


                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                            {{ $attendance->student->studentSection?->name ?? '-' }}
                        </td>


                        <td class="whitespace-nowrap px-5 py-4">

                            @if($attendance->status === 'present')

                                <span class="badge badge-success">
                                    Present
                                </span>

                            @elseif($attendance->status === 'absent')

                                <span class="badge badge-danger">
                                    Absent
                                </span>

                            @else

                                <span class="badge badge-warning">
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
                                class="text-sm font-semibold text-primary-600 transition hover:text-primary-800"
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
                                class="mt-4 btn btn-primary"
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

        <div class="card-footer">
            {{ $attendances->links() }}
        </div>

    @endif

</div>

</div>

@endsection