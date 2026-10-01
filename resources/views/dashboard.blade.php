@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-primary-600">Overview</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">School Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">A quick look at today's activity</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <span class="text-sm text-gray-600 font-medium">{{ now()->format('l, F j, Y') }}</span>
            </div>
            <a href="{{ route('reports.fees') }}" class="btn btn-secondary btn-sm hidden sm:inline-flex">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                View Reports
            </a>
        </div>
    </div>

    {{-- Key Metrics Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <article class="stat-card stat-card-primary relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600/10 to-primary-700/20" aria-hidden="true"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-primary-100">Total Students</p>
                    <p class="mt-2 text-4xl font-bold tracking-tight">{{ number_format($totalStudents) }}</p>
                </div>
                <span class="rounded-xl bg-white/15 p-3" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-3a4 4 0 1 1 0 8m4 5v-2a4 4 0 0 0-3-3.87" /></svg>
                </span>
            </div>
            <div class="mt-4 flex items-center gap-2 relative z-10">
                <span class="inline-flex items-center px-2 py-1 rounded-full bg-white/15 text-xs font-medium text-primary-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-success-400 mr-1.5"></span>
                    Active
                </span>
            </div>
            <p class="mt-3 text-sm text-primary-100 relative z-10">Enrolled {{ auth()->user()->isAdmin() ? 'across all schools' : 'in this school' }}</p>
        </article>

        <article class="stat-card relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-success-500/5 to-success-600/10" aria-hidden="true"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500">Present Today</p>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900">{{ number_format($presentStudents) }}</p>
                </div>
                <span class="rounded-xl bg-success-100 p-3 text-success-600" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </span>
            </div>
            <div class="mt-4 flex items-center gap-3 relative z-10">
                <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-success-500 rounded-full" style="width: {{ round(($presentStudents / max($totalStudents, 1)) * 100) }}%"></div>
                </div>
                <span class="text-sm font-semibold text-success-600 whitespace-nowrap">{{ round(($presentStudents / max($totalStudents, 1)) * 100) }}%</span>
            </div>
            <p class="mt-3 text-sm font-medium text-success-600 relative z-10">Attendance rate</p>
        </article>

        <article class="stat-card relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-warning-500/5 to-warning-600/10" aria-hidden="true"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Fees</p>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900">{{ number_format($pendingFees) }}</p>
                </div>
                <span class="rounded-xl bg-warning-100 p-3 text-warning-600" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l2.5 2.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </span>
            </div>
            <div class="mt-4 relative z-10">
                @php
                    $pendingRate = $totalStudents > 0 ? round(($pendingFees / $totalStudents) * 100) : 0;
                @endphp
                <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-warning-500 rounded-full" style="width: {{ $pendingRate }}%"></div>
                </div>
            </div>
            <p class="mt-3 text-sm font-medium text-warning-600 relative z-10">{{ $pendingRate }}% of students</p>
        </article>

        <article class="stat-card relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-info-500/5 to-info-600/10" aria-hidden="true"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Classes</p>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900">{{ number_format($studentsClasses ?? $totalClasses ?? 0) }}</p>
                </div>
                <span class="rounded-xl bg-info-100 p-3 text-info-600" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" /></svg>
                </span>
            </div>
            <div class="mt-4 grid gap-3 sm:grid-cols-2 relative z-10">
                <div class="p-3 rounded-xl bg-gray-50">
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTeachers ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Teachers</p>
                </div>
                <div class="p-3 rounded-xl bg-gray-50">
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSections ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Sections</p>
                </div>
            </div>
            <p class="mt-3 text-sm font-medium text-info-600 relative z-10">Active learning groups</p>
        </article>
    </div>

    {{-- Analytics Cards Row --}}
    <div class="grid gap-4 lg:grid-cols-3">
        {{-- Absent Students --}}
        <article class="card relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-danger-500" aria-hidden="true"></div>
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">Absent Students Today</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ number_format($absentStudents) }} students</p>
                    </div>
                    <span class="rounded-xl bg-danger-100 p-2 text-danger-600" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.9 2.7 17a2 2 0 0 0 1.74 3h15.12a2 2 0 0 0 1.74-3L13.7 3.9a2 2 0 0 0-3.4 0Z" /></svg>
                    </span>
                </div>
            </div>

            <div class="card-body divide-y divide-gray-100 p-0">
                @forelse($absentStudentList->take(5) as $student)
                    <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors group">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-danger-100 text-sm font-bold text-danger-700 group-hover:scale-110 transition-transform">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $student->name }}</p>
                            <p class="mt-0.5 text-xs text-gray-500 flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-xs text-gray-600">Roll {{ $student->roll_number ?? '-' }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary-50 text-xs text-primary-700">{{ $student->schoolClass?->name ?? '-' }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-info-50 text-xs text-info-700">{{ $student->studentSection?->name ?? '-' }}</span>
                            </p>
                        </div>
                        <a href="{{ route('students.show', $student) }}" class="btn btn-ghost btn-sm btn-icon p-2 text-gray-400 hover:text-primary-600" title="View details">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </a>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 mb-3">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m5.656 0l3.536 3.536m-3.536 0l-3.536 3.536m-5.656 0l-3.536 3.536m0-5.656l3.536-3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">No absent students</p>
                        <p class="mt-1 text-sm text-gray-500">All students are present today</p>
                    </div>
                @endforelse
            </div>

            @if($absentStudents > 5)
                <details class="card-footer group">
                    <summary class="cursor-pointer text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center justify-between p-4 -mx-6 -mb-4 rounded-b-xl bg-gray-50/50 border-t border-gray-100">
                        Show {{ $absentStudents - 5 }} more
                        <svg class="h-4 w-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <div class="mt-3 divide-y divide-gray-100">
                        @foreach($absentStudentList->slice(5) as $student)
                            <div class="py-3 px-6 flex items-center gap-4 last:pb-0">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-xs font-medium text-gray-600">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $student->name }}</p>
                                    <p class="text-xs text-gray-500">Roll {{ $student->roll_number ?? '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </details>
            @endif
        </article>

        {{-- Unpaid Fees --}}
        <article class="card relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-warning-500" aria-hidden="true"></div>
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">Unpaid Fees</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ number_format($unpaidFees) }} students</p>
                    </div>
                    <span class="rounded-xl bg-warning-100 p-2 text-warning-600" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2ZM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Z" /></svg>
                    </span>
                </div>
            </div>

            <div class="card-body divide-y divide-gray-100 p-0">
                @forelse($unpaidStudentList->take(5) as $fee)
                    <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors group">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning-100 text-sm font-bold text-warning-700 group-hover:scale-110 transition-transform">
                            {{ strtoupper(substr($fee->student->name, 0, 1)) }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $fee->student->name }}</p>
                            <p class="mt-0.5 text-xs text-gray-500 flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-xs text-gray-600">Roll {{ $fee->student->roll_number ?? '-' }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary-50 text-xs text-primary-700">{{ $fee->student->schoolClass?->name ?? '-' }}</span>
                            </p>
                        </div>
                        <span class="badge badge-danger">Unpaid</span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 mb-3">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2ZM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Z" /></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">No unpaid fees</p>
                        <p class="mt-1 text-sm text-gray-500">All fees are collected</p>
                    </div>
                @endforelse
            </div>

            @if($unpaidFees > 5)
                <details class="card-footer group">
                    <summary class="cursor-pointer text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center justify-between p-4 -mx-6 -mb-4 rounded-b-xl bg-gray-50/50 border-t border-gray-100">
                        Show {{ $unpaidFees - 5 }} more
                        <svg class="h-4 w-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <div class="mt-3 divide-y divide-gray-100">
                        @foreach($unpaidStudentList->slice(5) as $fee)
                            <div class="py-3 px-6 flex items-center gap-4 last:pb-0">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-xs font-medium text-gray-600">
                                    {{ strtoupper(substr($fee->student->name, 0, 1)) }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $fee->student->name }}</p>
                                    <p class="text-xs text-gray-500">Roll {{ $fee->student->roll_number ?? '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </details>
            @endif
        </article>

        {{-- Partial Fees --}}
        <article class="card relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-info-500" aria-hidden="true"></div>
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">Partial Fees</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ number_format($partialFees) }} students</p>
                    </div>
                    <span class="rounded-xl bg-info-100 p-2 text-info-600" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z" /></svg>
                    </span>
                </div>
            </div>

            <div class="card-body divide-y divide-gray-100 p-0">
                @forelse($partialStudentList->take(5) as $fee)
                    <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors group">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-info-100 text-sm font-bold text-info-700 group-hover:scale-110 transition-transform">
                            {{ strtoupper(substr($fee->student->name, 0, 1)) }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $fee->student->name }}</p>
                            <p class="mt-0.5 text-xs text-gray-500 flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-xs text-gray-600">Roll {{ $fee->student->roll_number ?? '-' }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary-50 text-xs text-primary-700">{{ $fee->student->schoolClass?->name ?? '-' }}</span>
                            </p>
                        </div>
                        <span class="badge badge-warning">Partial</span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 mb-3">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z" /></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">No partial payments</p>
                        <p class="mt-1 text-sm text-gray-500">All fees are fully paid or unpaid</p>
                    </div>
                @endforelse
            </div>

            @if($partialFees > 5)
                <details class="card-footer group">
                    <summary class="cursor-pointer text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center justify-between p-4 -mx-6 -mb-4 rounded-b-xl bg-gray-50/50 border-t border-gray-100">
                        Show {{ $partialFees - 5 }} more
                        <svg class="h-4 w-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <div class="mt-3 divide-y divide-gray-100">
                        @foreach($partialStudentList->slice(5) as $fee)
                            <div class="py-3 px-6 flex items-center gap-4 last:pb-0">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-xs font-medium text-gray-600">
                                    {{ strtoupper(substr($fee->student->name, 0, 1)) }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $fee->student->name }}</p>
                                    <p class="text-xs text-gray-500">Roll {{ $fee->student->roll_number ?? '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </details>
            @endif
        </article>
    </div>

    {{-- Action Cards Grid --}}
    <div class="grid gap-4 lg:grid-cols-4">
        <article class="card p-6 hover:shadow-lg transition-shadow duration-300 group">
            <div class="flex items-center gap-4">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Add Teacher</h3>
                    <p class="text-sm text-gray-500">Register new teaching staff</p>
                </div>
            </div>
            <a href="{{ route('teachers.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700 group-hover:gap-2 transition-all">
                Get started <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </article>

        <article class="card p-6 hover:shadow-lg transition-shadow duration-300 group">
            <div class="flex items-center gap-4">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-success-100 text-success-600 group-hover:bg-success-600 group-hover:text-white transition-colors duration-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Add Student</h3>
                    <p class="text-sm text-gray-500">Enroll new student</p>
                </div>
            </div>
            <a href="{{ route('students.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700 group-hover:gap-2 transition-all">
                Get started <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </article>

        <article class="card p-6 hover:shadow-lg transition-shadow duration-300 group">
            <div class="flex items-center gap-4">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-warning-100 text-warning-600 group-hover:bg-warning-600 group-hover:text-white transition-colors duration-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2ZM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Z" /></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Record Fee</h3>
                    <p class="text-sm text-gray-500">Process fee payment</p>
                </div>
            </div>
            <a href="{{ route('fees.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700 group-hover:gap-2 transition-all">
                Get started <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </article>

        <article class="card p-6 hover:shadow-lg transition-shadow duration-300 group">
            <div class="flex items-center gap-4">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-info-100 text-info-600 group-hover:bg-info-600 group-hover:text-white transition-colors duration-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Take Attendance</h3>
                    <p class="text-sm text-gray-500">Mark daily attendance</p>
                </div>
            </div>
            <a href="{{ route('attendances.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700 group-hover:gap-2 transition-all">
                Get started <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
        </article>
    </div>

    {{-- Quick Stats Summary --}}
    <div class="grid gap-4 lg:grid-cols-2">
        <article class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Quick Links</h3>
            </div>
            <div class="card-body">
                <div class="grid gap-3 sm:grid-cols-2">
                    <a href="{{ route('students.index') }}" class="btn btn-ghost w-full justify-start group">
                        <svg class="h-5 w-5 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        All Students
                    </a>
                    <a href="{{ route('teachers.index') }}" class="btn btn-ghost w-full justify-start group">
                        <svg class="h-5 w-5 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        All Teachers
                    </a>
                    <a href="{{ route('classes.index') }}" class="btn btn-ghost w-full justify-start group">
                        <svg class="h-5 w-5 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        All Classes
                    </a>
                    <a href="{{ route('fees.index') }}" class="btn btn-ghost w-full justify-start group">
                        <svg class="h-5 w-5 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2ZM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Z" /></svg>
                        Fee Records
                    </a>
                </div>
            </div>
        </article>

        <article class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">System Status</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-success-100 text-success-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </span>
                            <div>
                                <p class="font-medium text-gray-900">System Online</p>
                                <p class="text-xs text-gray-500">All services operational</p>
                            </div>
                        </div>
                        <span class="inline-flex h-2 w-2 rounded-full bg-success-500"></span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary-100 text-primary-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </span>
                            <div>
                                <p class="font-medium text-gray-900">Database</p>
                                <p class="text-xs text-gray-500">Connected</p>
                            </div>
                        </div>
                        <span class="inline-flex h-2 w-2 rounded-full bg-success-500"></span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-info-100 text-info-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </span>
                            <div>
                                <p class="font-medium text-gray-900">Backup Status</p>
                                <p class="text-xs text-gray-500">Last: {{ now()->subHours(2)->format('H:i') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex h-2 w-2 rounded-full bg-success-500"></span>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection