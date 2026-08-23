@extends('layouts.app')

@section('content')
<div class="flex min-h-full w-full flex-col space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><div><p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Teacher profile</p><h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">{{ $teacher->name }}</h2><p class="mt-2 text-sm text-gray-500">{{ $teacher->subject ?: 'Teaching staff' }}</p></div><div class="flex gap-3"><a href="{{ route('teachers.index') }}" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Back</a><a href="{{ route('teachers.edit', $teacher) }}" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">Edit teacher</a></div></div>
    <section class="rounded-2xl border border-gray-200 bg-white shadow-sm"><div class="border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white px-6 py-8"><div class="flex items-center gap-5"><div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-indigo-100 text-2xl font-bold text-indigo-700">{{ strtoupper(substr($teacher->name, 0, 1)) }}</div><div><h3 class="text-2xl font-bold text-gray-900">{{ $teacher->name }}</h3><p class="mt-1 text-sm text-gray-500">{{ $teacher->qualification ?: 'Qualification not provided' }}</p><span class="mt-3 inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Active teacher</span></div></div></div>
        <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Father name</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->father_name }}</p></div>
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Phone</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->phone ?: 'Not provided' }}</p></div>
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Qualification</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->qualification ?: 'Not provided' }}</p></div>
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Subject</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->subject ?: 'Not assigned' }}</p></div>
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Monthly salary</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->salary !== null ? number_format((float) $teacher->salary, 2) : 'Not set' }}</p></div>
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Joining date</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->joining_date ? $teacher->joining_date->format('d M Y') : 'Not provided' }}</p></div>
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Contract start</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->contract_start_date ? $teacher->contract_start_date->format('d M Y') : 'Not provided' }}</p></div>
            <div class="rounded-xl bg-gray-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Contract end</p><p class="mt-2 font-semibold text-gray-900">{{ $teacher->contract_end_date ? $teacher->contract_end_date->format('d M Y') : 'Open contract' }}</p></div>
        </div>
    </section>
</div>
@endsection
