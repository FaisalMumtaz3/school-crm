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
                Fees
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage student monthly fees and payments.
            </p>

        </div>


        <a
            href="{{ route('fees.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
        >

            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Manage Fees

        </a>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Filters --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <form
            method="GET"
            action="{{ route('fees.index') }}"
            class="fees-filters p-5"
        >

            {{-- Search --}}
            <div>

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


            {{-- Month --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Month
                </label>

                <select
                    name="month"
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                    <option value="">
                        All Months
                    </option>

                    @for($m = 1; $m <= 12; $m++)

                        <option
                            value="{{ $m }}"
                            {{ (string) request('month') === (string) $m ? 'selected' : '' }}
                        >
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>

                    @endfor

                </select>

            </div>


            {{-- Year --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Year
                </label>

                <select
                    name="year"
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                    <option value="">
                        All Years
                    </option>

                    @foreach($years as $year)

                        <option
                            value="{{ $year }}"
                            {{ (string) request('year') === (string) $year ? 'selected' : '' }}
                        >
                            {{ $year }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Class --}}
            <div>

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
                            value="{{ $class->id }}"
                            {{ (string) request('class') === (string) $class->id ? 'selected' : '' }}
                        >
                            {{ $class->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Section --}}
            <div>

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
                            value="{{ $section->id }}"
                            {{ (string) request('section') === (string) $section->id ? 'selected' : '' }}
                        >
                            {{ $section->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Status --}}
            <div>

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

                    <option
                        value="paid"
                        {{ request('status') === 'paid' ? 'selected' : '' }}
                    >
                        Paid
                    </option>

                    <option
                        value="partial"
                        {{ request('status') === 'partial' ? 'selected' : '' }}
                    >
                        Partial
                    </option>

                    <option
                        value="unpaid"
                        {{ request('status') === 'unpaid' ? 'selected' : '' }}
                    >
                        Unpaid
                    </option>

                </select>

            </div>


            {{-- Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                >
                    Filter
                </button>

                <a
                    href="{{ route('fees.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- DataTable --}}
    <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex shrink-0 items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6">

            <div>

                <h3 class="font-semibold text-gray-900">
                    Fee Records
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $fees->total() }} fee records
                </p>

            </div>

        </div>


        <div class="min-h-0 flex-1 overflow-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="sticky top-0 z-10 bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Month
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

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Fee
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Paid
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Balance
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

                    @forelse($fees as $fee)

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">

                                {{ \Carbon\Carbon::create()->month($fee->month)->format('M') }}
                                {{ $fee->year }}

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-gray-900">
                                {{ $fee->student->roll_number ?? '-' }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4">

                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $fee->student->name }}
                                </div>

                                <div class="mt-0.5 text-xs text-gray-500">
                                    {{ $fee->student->father_name }}
                                </div>

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                {{ $fee->student->schoolClass?->name ?? '-' }}

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                {{ $fee->student->studentSection?->name ?? '-' }}

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm text-gray-700">
                                Rs. {{ number_format($fee->fee_amount, 2) }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-medium text-gray-900">
                                Rs. {{ number_format($fee->paid_amount, 2) }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-semibold text-gray-900">
                                Rs. {{ number_format($fee->balance, 2) }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4">

                                @if($fee->status === 'paid')

                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Paid
                                    </span>

                                @elseif($fee->status === 'partial')

                                    <span class="inline-flex items-center rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-semibold text-yellow-700">
                                        Partial
                                    </span>

                                @else

                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        Unpaid
                                    </span>

                                @endif

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-right">

                                <a
                                    href="{{ route('fees.create', [
                                        'month' => $fee->month,
                                        'year' => $fee->year,
                                        'class' => $fee->student->class,
                                        'section' => $fee->student->section,
                                    ]) }}"
                                    class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-800"
                                >
                                    Edit
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="10"
                                class="px-5 py-12 text-center"
                            >

                                <div class="text-sm font-semibold text-gray-900">
                                    No fee records found
                                </div>

                                <p class="mt-1 text-sm text-gray-500">
                                    Start by managing fees for a class.
                                </p>

                                <a
                                    href="{{ route('fees.create') }}"
                                    class="mt-4 inline-flex rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                                >
                                    Manage Fees
                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($fees->hasPages())

            <div class="shrink-0 border-t border-gray-100 px-5 py-4">
                {{ $fees->links() }}
            </div>

        @endif

    </div>

</div>


<style>

    .fees-filters {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
    }

    @media (max-width: 1023px) {

        .fees-filters {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 639px) {

        .fees-filters {
            grid-template-columns: 1fr;
        }

    }

</style>

@endsection