@extends('layouts.app')

@section('content')

<div class="mx-auto flex min-h-full w-full max-w-7xl flex-col space-y-6">

    {{-- Header --}}
    <div>

        <a
            href="{{ route('fees.index') }}"
            class="mb-4 inline-flex items-center gap-2 text-sm font-semibold text-gray-500 transition hover:text-indigo-600"
        >

            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Back to Fees

        </a>


        <h1 class="text-2xl font-bold tracking-tight text-gray-900">
            Manage Fees
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Select month, class and section to manage student fees.
        </p>

    </div>


    {{-- Selection --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <form
            method="GET"
            action="{{ route('fees.create') }}"
            class="fees-selection p-5"
        >

            {{-- Month --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                    Month
                </label>

                <select
                    name="month"
                    required
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                    @for($m = 1; $m <= 12; $m++)

                        <option
                            value="{{ $m }}"
                            {{ (int) $month === $m ? 'selected' : '' }}
                        >
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>

                    @endfor

                </select>

            </div>


            {{-- Year --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                    Year
                </label>

                <select
                    name="year"
                    required
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                    @for($y = now()->year - 2; $y <= now()->year + 1; $y++)

                        <option
                            value="{{ $y }}"
                            {{ (int) $year === $y ? 'selected' : '' }}
                        >
                            {{ $y }}
                        </option>

                    @endfor

                </select>

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
                            value="{{ $class->id }}"
                            {{ (string) $selectedClass === (string) $class->id ? 'selected' : '' }}
                        >
                            {{ $class->name }}
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


            {{-- Default Fee --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                    Default Fee
                </label>

                <input
                    type="number"
                    name="default_fee"
                    value="{{ $defaultFee }}"
                    min="0"
                    step="0.01"
                    placeholder="e.g. 3000"
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

            </div>


            {{-- Load --}}
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
            action="{{ route('fees.store') }}"
            class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
        >

            @csrf


            <input
                type="hidden"
                name="month"
                value="{{ $month }}"
            >

            <input
                type="hidden"
                name="year"
                value="{{ $year }}"
            >

            <input
                type="hidden"
                name="class"
                value="{{ $selectedClass }}"
            >

            <input
                type="hidden"
                name="section"
                value="{{ $selectedSection }}"
            >


            {{-- Header --}}
            <div class="shrink-0 border-b border-gray-100 px-5 py-4 sm:px-6">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="font-semibold text-gray-900">

                            {{ optional($classes->firstWhere('id', $selectedClass))->name }}

                            @if($selectedSection)

                                @php
                                    $currentSection = $sections->firstWhere(
                                        'id',
                                        $selectedSection
                                    );
                                @endphp

                                - Section {{ $currentSection?->name }}

                            @endif

                        </h2>

                        <p class="mt-1 text-sm text-gray-500">

                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                            {{ $year }}

                            ·

                            {{ $students->count() }} students

                        </p>

                    </div>


                    {{-- Summary --}}
                    <div class="flex flex-wrap gap-2 text-xs font-semibold">

                        <span class="rounded-full bg-green-50 px-3 py-1.5 text-green-700">
                            Paid:
                            <span id="paidCount">0</span>
                        </span>

                        <span class="rounded-full bg-yellow-50 px-3 py-1.5 text-yellow-700">
                            Partial:
                            <span id="partialCount">0</span>
                        </span>

                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-red-700">
                            Unpaid:
                            <span id="unpaidCount">0</span>
                        </span>

                    </div>

                </div>

            </div>


            {{-- Table --}}
            <div class="min-h-0 flex-1 overflow-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="sticky top-0 z-10 bg-gray-50">

                        <tr>

                            <th class="w-14 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                #
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Roll No
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Student
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Fee Amount
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Paid Amount
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Balance
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Due Date
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($students as $index => $student)

                            <tr class="fee-row transition hover:bg-gray-50">

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


                                {{-- Fee Amount --}}
                                <td class="px-5 py-4">

                                    <input
                                        type="number"
                                        name="fees[{{ $student->id }}][fee_amount]"
                                        value="{{ $student->fee_amount }}"
                                        min="0"
                                        step="0.01"
                                        class="fee-amount w-32 rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >

                                </td>


                                {{-- Paid Amount --}}
                                <td class="px-5 py-4">

                                    <input
                                        type="number"
                                        name="fees[{{ $student->id }}][paid_amount]"
                                        value="{{ $student->paid_amount }}"
                                        min="0"
                                        step="0.01"
                                        class="paid-amount w-32 rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >

                                </td>


                                {{-- Balance --}}
                                <td class="px-5 py-4">

                                    <span class="balance-display text-sm font-semibold text-gray-900">
                                        Rs. {{ number_format($student->balance, 2) }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    <span class="status-display inline-flex min-w-[75px] items-center justify-center rounded-full px-2.5 py-1 text-xs font-semibold">

                                        {{ ucfirst($student->fee_status) }}

                                    </span>

                                </td>


                                {{-- Due Date --}}
                                <td class="px-5 py-4">

                                    <input
                                        type="date"
                                        name="fees[{{ $student->id }}][due_date]"
                                        value="{{ $student->fee_due_date }}"
                                        class="w-36 rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                        Enter the monthly fee and amount received for each student.
                    </p>


                    <div class="flex gap-2">

                        <a
                            href="{{ route('fees.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            Save Fees
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
                Choose the month, year and class above.
            </p>

        </div>

    @endif

</div>


@if($selectedClass && $students->count())

<script>

    function updateFeeRow(row) {

        const feeInput = row.querySelector('.fee-amount');
        const paidInput = row.querySelector('.paid-amount');

        const balanceDisplay =
            row.querySelector('.balance-display');

        const statusDisplay =
            row.querySelector('.status-display');


        let fee =
            parseFloat(feeInput.value) || 0;

        let paid =
            parseFloat(paidInput.value) || 0;


        if (paid > fee) {
            paid = fee;
            paidInput.value = fee;
        }


        let balance =
            Math.max(fee - paid, 0);


        let status;


        if (fee > 0 && paid >= fee) {

            status = 'Paid';

        } else if (paid > 0) {

            status = 'Partial';

        } else {

            status = 'Unpaid';
        }


        balanceDisplay.textContent =
            'Rs. ' + balance.toFixed(2);


        statusDisplay.textContent =
            status;


        /*
        |--------------------------------------------------------------------------
        | Reset status colors
        |--------------------------------------------------------------------------
        */

        statusDisplay.classList.remove(
            'bg-green-50',
            'text-green-700',
            'bg-yellow-50',
            'text-yellow-700',
            'bg-red-50',
            'text-red-700'
        );


        /*
        |--------------------------------------------------------------------------
        | Apply status color
        |--------------------------------------------------------------------------
        */

        if (status === 'Paid') {

            statusDisplay.classList.add(
                'bg-green-50',
                'text-green-700'
            );

        } else if (status === 'Partial') {

            statusDisplay.classList.add(
                'bg-yellow-50',
                'text-yellow-700'
            );

        } else {

            statusDisplay.classList.add(
                'bg-red-50',
                'text-red-700'
            );
        }

    }


    function updateFeeCounts() {

        let paid = 0;
        let partial = 0;
        let unpaid = 0;


        document
            .querySelectorAll('.fee-row')
            .forEach(function(row) {

                const feeInput =
                    row.querySelector('.fee-amount');

                const paidInput =
                    row.querySelector('.paid-amount');


                const fee =
                    parseFloat(feeInput.value) || 0;

                const amountPaid =
                    parseFloat(paidInput.value) || 0;


                if (fee > 0 && amountPaid >= fee) {

                    paid++;

                } else if (amountPaid > 0) {

                    partial++;

                } else {

                    unpaid++;
                }

            });


        document.getElementById('paidCount')
            .textContent = paid;

        document.getElementById('partialCount')
            .textContent = partial;

        document.getElementById('unpaidCount')
            .textContent = unpaid;
    }


    document
        .querySelectorAll('.fee-row')
        .forEach(function(row) {

            const feeInput =
                row.querySelector('.fee-amount');

            const paidInput =
                row.querySelector('.paid-amount');


            feeInput.addEventListener(
                'input',
                function() {

                    updateFeeRow(row);
                    updateFeeCounts();

                }
            );


            paidInput.addEventListener(
                'input',
                function() {

                    updateFeeRow(row);
                    updateFeeCounts();

                }
            );


            updateFeeRow(row);

        });


    updateFeeCounts();

</script>

@endif


<style>

    .fees-selection {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
    }

    @media (max-width: 1023px) {

        .fees-selection {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 639px) {

        .fees-selection {
            grid-template-columns: 1fr;
        }

    }

</style>

@endsection