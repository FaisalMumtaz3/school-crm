@extends('layouts.app')

@section('content')

<div class="mx-auto flex min-h-full w-full max-w-7xl flex-col space-y-6">

{{-- Header --}}
<div>

    <a
        href="{{ route('attendances.index') }}"
        class="mb-4 inline-flex items-center gap-2 text-sm font-semibold text-gray-500 transition hover:text-indigo-600"
    >
        <svg class="h-4 w-4"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>

        Back to Attendance
    </a>

    <h1 class="text-2xl font-bold tracking-tight text-gray-900">
        Take Attendance
    </h1>

    <p class="mt-1 text-sm text-gray-500">
        Select a date, class and section to mark student attendance.
    </p>

</div>


{{-- Date / Class / Section Selection --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm">

    <form
        method="GET"
        action="{{ route('attendances.create') }}"
        class="grid grid-cols-1 gap-4 p-5 md:grid-cols-2 lg:grid-cols-4"
    >

        {{-- Date --}}
        <div>

            <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                Attendance Date
            </label>

            <input
                type="date"
                name="date"
                value="{{ $date }}"
                required
                class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >

        </div>


        {{-- Class --}}
        <div>

            <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                Class
            </label>

            <select
                name="class"
                required
                onchange="this.form.submit()"
                class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >

                <option value="">
                    Select Class
                </option>

                @foreach($classes as $class)

                    <option
                        value="{{ $class }}"
                        {{ $selectedClass == $class ? 'selected' : '' }}
                    >
                        {{ $class }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Section --}}
        <div>

            <label class="mb-1.5 block text-sm font-semibold text-gray-700">
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
                        value="{{ $section->id }}"
                        {{ (string) $selectedSection === (string) $section->id ? 'selected' : '' }}
                    >
                        {{ $section->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Load Button --}}
        <div class="flex items-end">

            <button
                type="submit"
                class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
            >
                Load Students
            </button>

        </div>

    </form>

</div>


@if($selectedClass && $students->count())

    <form
        method="POST"
        action="{{ route('attendances.store') }}"
        class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
    >

        @csrf

        <input type="hidden" name="date" value="{{ $date }}">

        <input type="hidden" name="class" value="{{ $selectedClass }}">

        <input type="hidden" name="section" value="{{ $selectedSection }}">


        {{-- Attendance Header --}}
        <div class="shrink-0 border-b border-gray-100 px-5 py-4 sm:px-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="font-semibold text-gray-900">

                        {{ $selectedClass }}

                        @if($selectedSection)

                            -
                            Section
                            {{ optional($sections->firstWhere('id', $selectedSection))->name }}

                        @endif

                    </h2>

                    <p class="mt-1 text-sm text-gray-500">

                        {{ \Carbon\Carbon::parse($date)->format('d M Y') }}

                        ·

                        {{ $students->count() }} students

                    </p>

                </div>


                {{-- Summary --}}
                <div class="flex flex-wrap gap-2 text-xs font-semibold">

                    <span class="rounded-full bg-green-50 px-3 py-1.5 text-green-700">
                        Present:
                        <span id="presentCount">0</span>
                    </span>

                    <span class="rounded-full bg-red-50 px-3 py-1.5 text-red-700">
                        Absent:
                        <span id="absentCount">0</span>
                    </span>

                    <span class="rounded-full bg-yellow-50 px-3 py-1.5 text-yellow-700">
                        Leave:
                        <span id="leaveCount">0</span>
                    </span>

                </div>

            </div>

        </div>


        {{-- Student Table --}}
        <div class="min-h-0 flex-1 overflow-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="sticky top-0 z-10 bg-gray-50">

                    <tr>

                        <th class="w-16 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            #
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Roll No
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Student
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Remarks
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach($students as $index => $student)

                        @php
                            $status = $student->attendance_status ?? 'present';
                        @endphp

                        <tr class="attendance-row transition hover:bg-gray-50">

                            <td class="px-5 py-4 text-sm text-gray-500">
                                {{ $index + 1 }}
                            </td>


                            <td class="px-5 py-4 text-sm font-semibold text-gray-900">
                                {{ $student->roll_number ?? '-' }}
                            </td>


                            <td class="px-5 py-4">

                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $student->name }}
                                </div>

                                <div class="mt-0.5 text-xs text-gray-500">
                                    {{ $student->father_name }}
                                </div>

                            </td>

                            {{-- Attendance Status --}}
                            <td class="px-5 py-4">

                                <div class="flex flex-wrap gap-2">

                                    {{-- Present --}}
                                    <label class="cursor-pointer">

                                        <input
                                            type="radio"
                                            name="attendance[{{ $student->id }}][status]"
                                            value="present"
                                            class="attendance-radio sr-only"
                                            data-status="present"
                                            {{ $status === 'present' ? 'checked' : '' }}
                                        >

                                        <span class="attendance-button inline-flex min-w-[82px] items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm transition-all duration-150 hover:border-green-400 hover:bg-green-50">
                                            Present
                                        </span>

                                    </label>


                                    {{-- Absent --}}
                                    <label class="cursor-pointer">

                                        <input
                                            type="radio"
                                            name="attendance[{{ $student->id }}][status]"
                                            value="absent"
                                            class="attendance-radio sr-only"
                                            data-status="absent"
                                            {{ $status === 'absent' ? 'checked' : '' }}
                                        >

                                        <span class="attendance-button inline-flex min-w-[82px] items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm transition-all duration-150 hover:border-red-400 hover:bg-red-50">
                                            Absent
                                        </span>

                                    </label>


                                    {{-- Leave --}}
                                    <label class="cursor-pointer">

                                        <input
                                            type="radio"
                                            name="attendance[{{ $student->id }}][status]"
                                            value="leave"
                                            class="attendance-radio sr-only"
                                            data-status="leave"
                                            {{ $status === 'leave' ? 'checked' : '' }}
                                        >

                                        <span class="attendance-button inline-flex min-w-[82px] items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm transition-all duration-150 hover:border-yellow-400 hover:bg-yellow-50">
                                            Leave
                                        </span>

                                    </label>

                                </div>

                            </td>


                            {{-- Remarks --}}
                            <td class="px-5 py-4">

                                <input
                                    type="text"
                                    name="attendance[{{ $student->id }}][remarks]"
                                    value="{{ $student->attendance_remarks }}"
                                    placeholder="Optional"
                                    class="w-full min-w-[150px] rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Bottom --}}
        <div class="shrink-0 border-t border-gray-100 bg-white px-5 py-4 sm:px-6">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-xs text-gray-500">
                    Students are marked <strong>Present</strong> by default.
                </p>


                <div class="flex gap-2">

                    <a
                        href="{{ route('attendances.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                    >
                        Save Attendance
                    </button>

                </div>

            </div>

        </div>

    </form>


@elseif($selectedClass)

    <div class="rounded-xl border border-gray-200 bg-white px-6 py-12 text-center shadow-sm">

        <h3 class="text-sm font-semibold text-gray-900">
            No students found
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            There are no students assigned to this class/section.
        </p>

    </div>


@else

    <div class="rounded-xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

        <h3 class="text-sm font-semibold text-gray-900">
            Select a class to start
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Choose the attendance date and class above.
        </p>

    </div>

@endif

</div>

@if($selectedClass && $students->count())

<script>

    function updateAttendanceCounts() {

        let present = 0;
        let absent = 0;
        let leave = 0;

        document
            .querySelectorAll('.attendance-radio:checked')
            .forEach(function (radio) {

                if (radio.dataset.status === 'present') {
                    present++;
                }

                if (radio.dataset.status === 'absent') {
                    absent++;
                }

                if (radio.dataset.status === 'leave') {
                    leave++;
                }

            });

        document.getElementById('presentCount').textContent = present;
        document.getElementById('absentCount').textContent = absent;
        document.getElementById('leaveCount').textContent = leave;
    }

    function updateAttendanceButtonStyles() {

        document.querySelectorAll('.attendance-radio').forEach(function (radio) {

            const button = radio.nextElementSibling;

            // Reset
            button.classList.remove(
                'bg-emerald-600',
                'bg-red-600',
                'bg-yellow-400',
                'text-white',
                'text-gray-600',
                'border-emerald-600',
                'border-red-600',
                'border-yellow-500',
                'border-gray-300',
                'shadow-md'
            );

            // Default state
            button.classList.add(
                'bg-white',
                'text-gray-600',
                'border-gray-300'
            );

            // Selected state
            if (radio.checked) {

                if (radio.dataset.status === 'present') {

                    button.classList.remove(
                        'bg-white',
                        'text-gray-600',
                        'border-gray-300'
                    );

                    button.classList.add(
                        'bg-emerald-600',
                        'text-white',
                        'border-emerald-600',
                        'shadow-md'
                    );

                } else if (radio.dataset.status === 'absent') {

                    button.classList.remove(
                        'bg-white',
                        'text-gray-600',
                        'border-gray-300'
                    );

                    button.classList.add(
                        'bg-red-600',
                        'text-white',
                        'border-red-600',
                        'shadow-md'
                    );

                } else if (radio.dataset.status === 'leave') {

                    button.classList.remove(
                        'bg-white',
                        'text-gray-600',
                        'border-gray-300'
                    );

                    button.classList.add(
                        'text-white',
                        'shadow-md'
                    );

                    button.style.backgroundColor = '#eab308';
                    button.style.borderColor = '#eab308';

                }

            }

        });

    }


document.querySelectorAll('.attendance-radio').forEach(function (radio) {

        radio.addEventListener('change', function () {

            updateAttendanceCounts();
            updateAttendanceButtonStyles();

        });

    });


    // Initial state
    updateAttendanceCounts();
    updateAttendanceButtonStyles();

</script>

@endif

@endsection
