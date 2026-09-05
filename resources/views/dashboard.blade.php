@extends('layouts.app')

@section('content')

<div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Overview</p>
        <h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">School dashboard</h2>
    </div>
    <p class="text-sm text-gray-500">A quick look at today&apos;s activity</p>
</div>

<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
    <article class="relative overflow-hidden rounded-2xl bg-indigo-600 p-6 text-white shadow-lg shadow-indigo-200">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-100">Total students</p>
                <p class="mt-4 text-4xl font-bold tracking-tight">{{ number_format($totalStudents) }}</p>
            </div>
            <span class="rounded-xl bg-white/15 p-3" aria-hidden="true">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-3a4 4 0 1 1 0 8m4 5v-2a4 4 0 0 0-3-3.87" /></svg>
            </span>
        </div>
        <p class="mt-5 text-sm text-indigo-100">Enrolled across the school</p>
    </article>

    <article class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Present today</p>
                <p class="mt-4 text-4xl font-bold tracking-tight text-gray-900">{{ number_format($presentStudents) }}</p>
            </div>
            <span class="rounded-xl bg-emerald-50 p-3 text-emerald-600" aria-hidden="true">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </span>
        </div>
        <p class="mt-5 text-sm font-medium text-emerald-600">{{ round(($presentStudents / max($totalStudents, 1)) * 100) }}% attendance rate</p>
    </article>

    <article class="rounded-2xl border border-amber-100 bg-white p-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pending fees</p>
                <p class="mt-4 text-4xl font-bold tracking-tight text-gray-900">{{ number_format($pendingFees) }}</p>
            </div>
            <span class="rounded-xl bg-amber-50 p-3 text-amber-600" aria-hidden="true">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l2.5 2.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </span>
        </div>
        <p class="mt-5 text-sm font-medium text-amber-600">Accounts needing attention</p>
    </article>

    <article class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total classes</p>
                <p class="mt-4 text-4xl font-bold tracking-tight text-gray-900">{{ number_format($studentsClasses) }}</p>
            </div>
            <span class="rounded-xl bg-sky-50 p-3 text-sky-600" aria-hidden="true">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" /></svg>
            </span>
        </div>
        <p class="mt-5 text-sm font-medium text-sky-600">Active learning groups</p>
    </article>
</div>

<div class="mt-6 grid gap-5 lg:grid-cols-3">
    <article class="rounded-2xl border border-red-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-900">Absent students today</h3>
                <p class="mt-1 text-sm text-gray-500">{{ number_format($absentStudents) }} students</p>
            </div>
            <span class="rounded-xl bg-red-50 p-3 text-red-600" aria-hidden="true">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.9 2.7 17a2 2 0 0 0 1.74 3h15.12a2 2 0 0 0 1.74-3L13.7 3.9a2 2 0 0 0-3.4 0Z" /></svg>
            </span>
        </div>

        <ul class="mt-5 divide-y divide-gray-100">
            @forelse($absentStudentList->take(5) as $student)
                <li class="py-3 first:pt-0 last:pb-0">
                    <p class="text-sm font-semibold text-gray-900">{{ $student->name }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        Roll {{ $student->roll_number ?? '-' }}
                        · {{ $student->schoolClass?->name ?? '-' }}
                        · {{ $student->studentSection?->name ?? '-' }}
                    </p>
                </li>
            @empty
                <li class="py-3 text-sm text-gray-500">No absent students recorded today.</li>
            @endforelse
        </ul>

        @if($absentStudents > 5)
            <details class="mt-4 border-t border-gray-100 pt-3">
                <summary class="cursor-pointer text-sm font-semibold text-indigo-600">Show {{ $absentStudents - 5 }} more</summary>
                <ul class="mt-2 divide-y divide-gray-100">
                    @foreach($absentStudentList->slice(5) as $student)
                        <li class="py-3 last:pb-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $student->name }}</p>
                            <p class="mt-1 text-xs text-gray-500">Roll {{ $student->roll_number ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </details>
        @endif
    </article>

    <article class="rounded-2xl border border-orange-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-900">Unpaid fees</h3>
                <p class="mt-1 text-sm text-gray-500">{{ number_format($unpaidFees) }} students</p>
            </div>
        </div>

        <ul class="mt-5 divide-y divide-gray-100">
            @forelse($unpaidStudentList->take(5) as $fee)
                <li class="py-3 first:pt-0 last:pb-0">
                    <p class="text-sm font-semibold text-gray-900">{{ $fee->student->name }}</p>
                    <p class="mt-1 text-xs text-gray-500">Roll {{ $fee->student->roll_number ?? '-' }} · {{ $fee->student->schoolClass?->name ?? '-' }}</p>
                </li>
            @empty
                <li class="py-3 text-sm text-gray-500">No unpaid fee students.</li>
            @endforelse
        </ul>

        @if($unpaidFees > 5)
            <details class="mt-4 border-t border-gray-100 pt-3">
                <summary class="cursor-pointer text-sm font-semibold text-indigo-600">Show {{ $unpaidFees - 5 }} more</summary>
                <ul class="mt-2 divide-y divide-gray-100">
                    @foreach($unpaidStudentList->slice(5) as $fee)
                        <li class="py-3 last:pb-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $fee->student->name }}</p>
                            <p class="mt-1 text-xs text-gray-500">Roll {{ $fee->student->roll_number ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </details>
        @endif
    </article>

    <article class="rounded-2xl border border-yellow-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-900">Partial fees</h3>
                <p class="mt-1 text-sm text-gray-500">{{ number_format($partialFees) }} students</p>
            </div>
        </div>

        <ul class="mt-5 divide-y divide-gray-100">
            @forelse($partialStudentList->take(5) as $fee)
                <li class="py-3 first:pt-0 last:pb-0">
                    <p class="text-sm font-semibold text-gray-900">{{ $fee->student->name }}</p>
                    <p class="mt-1 text-xs text-gray-500">Roll {{ $fee->student->roll_number ?? '-' }} · {{ $fee->student->schoolClass?->name ?? '-' }}</p>
                </li>
            @empty
                <li class="py-3 text-sm text-gray-500">No partial fee students.</li>
            @endforelse
        </ul>

        @if($partialFees > 5)
            <details class="mt-4 border-t border-gray-100 pt-3">
                <summary class="cursor-pointer text-sm font-semibold text-indigo-600">Show {{ $partialFees - 5 }} more</summary>
                <ul class="mt-2 divide-y divide-gray-100">
                    @foreach($partialStudentList->slice(5) as $fee)
                        <li class="py-3 last:pb-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $fee->student->name }}</p>
                            <p class="mt-1 text-xs text-gray-500">Roll {{ $fee->student->roll_number ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </details>
        @endif
    </article>
</div>

@endsection
