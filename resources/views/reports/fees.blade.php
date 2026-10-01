@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header Section --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-primary-600">Reports</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">Fee Report</h1>
            <p class="mt-1 text-sm text-gray-500">View student-wise fees by class, section, and payment status</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('fees.index') }}" class="btn btn-secondary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Fee Records
            </a>
            <button class="btn btn-primary hidden sm:inline-flex" onclick="window.print()">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2h2m-2-4h10M10 8v4m0 4h.01M17 8v4m0 4h.01M14 8v4m0 4h.01M11 8v4m0 4h.01M8 8v4m0 4h.01M5 8v4m0 4h.01" /></svg>
                Print Report
            </button>
        </div>
    </div>

    {{-- Summary Cards --}}
    @if($fees->total() > 0)
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="stat-card stat-card-primary relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600/10 to-primary-700/20" aria-hidden="true"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-primary-100">Total Records</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight">{{ number_format($fees->total()) }}</p>
                    </div>
                    <span class="rounded-xl bg-white/15 p-3" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </span>
                </div>
                <p class="mt-3 text-sm text-primary-100 relative z-10">Fee records found</p>
            </article>

            @php
                $totalFeeAmount = $fees->sum('fee_amount');
                $totalPaidAmount = $fees->sum('paid_amount');
                $totalBalance = $fees->sum('balance');
                $paidCount = $fees->where('status', 'paid')->count();
                $partialCount = $fees->where('status', 'partial')->count();
                $unpaidCount = $fees->where('status', 'unpaid')->count();
                $collectionRate = $totalFeeAmount > 0 ? round(($totalPaidAmount / $totalFeeAmount) * 100) : 0;
            @endphp

            <article class="stat-card relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-success-500/5 to-success-600/10" aria-hidden="true"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Fees</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">Rs. {{ number_format($totalFeeAmount, 2) }}</p>
                    </div>
                    <span class="rounded-xl bg-success-100 p-3 text-success-600" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2ZM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Z" /></svg>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-3 relative z-10">
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-success-500 rounded-full" style="width: {{ $collectionRate }}%"></div>
                    </div>
                    <span class="text-sm font-semibold text-success-600 whitespace-nowrap">{{ $collectionRate }}% collected</span>
                </div>
                <p class="mt-3 text-sm font-medium text-success-600 relative z-10">Collection rate</p>
            </article>

            <article class="stat-card relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-warning-500/5 to-warning-600/10" aria-hidden="true"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Outstanding</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">Rs. {{ number_format($totalBalance, 2) }}</p>
                    </div>
                    <span class="rounded-xl bg-warning-100 p-3 text-warning-600" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.9 2.7 17a2 2 0 0 0 1.74 3h15.12a2 2 0 0 0 1.74-3L13.7 3.9a2 2 0 0 0-3.4 0Z" /></svg>
                    </span>
                </div>
                <div class="mt-4 grid gap-3 sm:grid-cols-3 relative z-10">
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-xl font-bold text-danger-600">{{ $unpaidCount }}</p>
                        <p class="text-xs text-gray-500">Unpaid</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-xl font-bold text-warning-600">{{ $partialCount }}</p>
                        <p class="text-xs text-gray-500">Partial</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-xl font-bold text-success-600">{{ $paidCount }}</p>
                        <p class="text-xs text-gray-500">Paid</p>
                    </div>
                </div>
                <p class="mt-3 text-sm font-medium text-warning-600 relative z-10">Pending collection</p>
            </article>

            <article class="stat-card relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-info-500/5 to-info-600/10" aria-hidden="true"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Collected</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">Rs. {{ number_format($totalPaidAmount, 2) }}</p>
                    </div>
                    <span class="rounded-xl bg-info-100 p-3 text-info-600" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z" /></svg>
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Paid / Total</span>
                        <span class="font-semibold text-gray-900">Rs. {{ number_format($totalPaidAmount, 2) }} / Rs. {{ number_format($totalFeeAmount, 2) }}</span>
                    </div>
                </div>
                <p class="mt-3 text-sm font-medium text-info-600 relative z-10">Total collected</p>
            </article>
        </div>
    @endif

    {{-- Filters Card --}}
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Filters
            </h3>
        </div>
        <form method="GET" action="{{ route('reports.fees') }}" class="p-6">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-5">
                <div>
                    <label class="form-label">Class</label>
                    <select name="class" class="form-input form-select">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ (string) request('class') === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Section</label>
                    <select name="section" class="form-input form-select">
                        <option value="">All Sections</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ (string) request('section') === (string) $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Payment Status</label>
                    <select name="status" class="form-input form-select">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Month</label>
                    <select name="month" class="form-input form-select">
                        <option value="">All Months</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ (string) request('month') === (string) $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="form-label">Year</label>
                    <select name="year" class="form-input form-select">
                        <option value="">All Years</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ (string) request('year') === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2 lg:col-span-2">
                    <button type="submit" class="btn btn-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        Filter
                    </button>
                    <a href="{{ route('reports.fees') }}" class="btn btn-secondary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="card overflow-hidden">
        <div class="card-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-gray-900">Student Fee Details</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $fees->total() }} student fee records{{ auth()->user()->isAdmin() ? ' across all schools' : '' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                    {{ $fees->currentPage() }} / {{ $fees->lastPage() }}
                </span>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        @if (auth()->user()->isAdmin())
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">School</th>
                        @endif
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Student</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 hidden md:table-cell">Class</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 hidden lg:table-cell">Section</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Period</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Fee</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Paid</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Balance</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($fees as $fee)
                        <tr class="transition hover:bg-gray-50 group">
                            @if (auth()->user()->isAdmin())
                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="badge badge-success">{{ $fee->school->name ?? 'N/A' }}</span>
                            </td>
                            @endif
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100 text-sm font-bold text-primary-700 group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($fee->student->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $fee->student->name }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">Roll No: {{ $fee->student->roll_number ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 hidden md:table-cell">
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-primary-50 text-primary-700 text-xs font-medium">{{ $fee->student->schoolClass?->name ?? '-' }}</span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 hidden lg:table-cell">
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-info-50 text-info-700 text-xs font-medium">{{ $fee->student->studentSection?->name ?? '-' }}</span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::create()->month($fee->month)->format('M') }} {{ $fee->year }}</td>

                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm text-gray-700 font-medium">Rs. {{ number_format($fee->fee_amount, 2) }}</td>

                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-medium text-gray-900 text-success-600">Rs. {{ number_format($fee->paid_amount, 2) }}</td>

                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-semibold text-gray-900 {{ $fee->balance > 0 ? 'text-danger-600' : 'text-success-600' }}">Rs. {{ number_format($fee->balance, 2) }}</td>

                            <td class="whitespace-nowrap px-5 py-4">
                                @if($fee->status === 'paid')
                                    <span class="badge badge-success flex items-center gap-1.5">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                        Paid
                                    </span>
                                @elseif($fee->status === 'partial')
                                    <span class="badge badge-warning flex items-center gap-1.5">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                                        Partial
                                    </span>
                                @else
                                    <span class="badge badge-danger flex items-center gap-1.5">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                        Unpaid
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-16 text-center">
                                <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 mb-4">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-900">No fee records found</p>
                                <p class="mt-1 text-sm text-gray-500">Try changing the class, section, payment status, or date filters</p>
                                <a href="{{ route('fees.create') }}" class="mt-4 inline-flex items-center gap-2 btn btn-primary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    Manage Fees
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($fees->hasPages())
            <div class="card-footer flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-gray-500">Showing {{ $fees->firstItem() }} to {{ $fees->lastItem() }} of {{ $fees->total() }} results</p>
                <div class="flex items-center gap-2">
                    {{ $fees->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection