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
            Fees
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Manage student monthly fees and payments.
        </p>

    </div>


    <a
        href="{{ route('fees.create') }}"
        class="btn btn-primary"
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

    <div class="flex items-center gap-3 rounded-xl border border-success-200 bg-success-50 px-4 py-3 text-sm font-medium text-success-800">
        {{ session('success') }}
    </div>

@endif


{{-- Filters --}}
<div class="card">

    <form
        method="GET"
        action="{{ route('fees.index') }}"
        class="fees-filters p-6"
    >

        {{-- Search --}}
        <div>

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


        {{-- Month --}}
        <div>

            <label class="form-label">
                Month
            </label>

            <select
                name="month"
                class="form-input form-select"
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

            <label class="form-label">
                Year
            </label>

            <select
                name="year"
                class="form-input form-select"
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
        <div>

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
        <div>

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
                class="btn btn-primary"
            >
                Filter
            </button>

            <a
                href="{{ route('fees.index') }}"
                class="btn btn-secondary"
            >
                Reset
            </a>

        </div>

    </form>

</div>


{{-- DataTable --}}
<div class="card overflow-hidden">

    <div class="card-header">

        <div>

            <h3 class="font-semibold text-gray-900">
                Fee Records
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                {{ $fees->total() }} fee records
                {{ auth()->user()->isAdmin() ? 'across all schools' : '' }}
            </p>

        </div>

    </div>


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


            <tbody class="divide-y divide-gray-100">

                @forelse($fees as $fee)

                    <tr class="transition hover:bg-gray-50">

                        @if (auth()->user()->isAdmin())
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                            <span class="badge badge-success">{{ $fee->school->name ?? 'N/A' }}</span>
                        </td>
                        @endif

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

                                <span class="badge badge-success">
                                    Paid
                                </span>

                            @elseif($fee->status === 'partial')

                                <span class="badge badge-warning">
                                    Partial
                                </span>

                            @else

                                <span class="badge badge-danger">
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
                                class="text-sm font-semibold text-primary-600 transition hover:text-primary-800"
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
                                class="mt-4 btn btn-primary"
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

        <div class="card-footer">
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