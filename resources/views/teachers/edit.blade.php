@extends('layouts.app')

@section('content')
    <div class="flex min-h-full w-full flex-col">
        <div class="mb-8"><a href="{{ route('teachers.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-indigo-600">← Back to
                teachers</a>
            <p class="mt-6 text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Teacher directory</p>
            <h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">Edit teacher</h2>
            <p class="mt-2 text-sm text-gray-500">Update the profile and contract for {{ $teacher->name }}.</p>
        </div>
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Please correct the highlighted fields.</p>
                <ul class="mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section
            class="student-form-card flex flex-1 flex-col overflow-visible rounded-2xl border border-gray-200 bg-white shadow-sm">
            {{-- <div class="border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-sky-50 px-6 py-5 sm:px-8">
                <h3 class="font-semibold text-gray-900">Teacher information</h3>
                <p class="mt-1 text-sm text-gray-500">Keep this staff record accurate and up to date.</p>
            </div> --}}
            <form action="{{ route('teachers.update', $teacher) }}" method="POST"
                class="student-form flex flex-1 flex-col px-6 py-6 sm:px-8 sm:py-8">@csrf @method('PUT')
                <div class="grid gap-6 sm:grid-cols-2">
                    <div><label for="name" class="mb-2 block text-sm font-semibold text-gray-700">Teacher name <span
                                class="text-red-500">*</span></label><input id="name" name="name"
                            value="{{ old('name', $teacher->name) }}" required autofocus
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div><label for="father_name" class="mb-2 block text-sm font-semibold text-gray-700">Father name <span
                                class="text-red-500">*</span></label><input id="father_name" name="father_name"
                            value="{{ old('father_name', $teacher->father_name) }}" required
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('father_name') border-red-300 @enderror">
                        @error('father_name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div><label for="phone" class="mb-2 block text-sm font-semibold text-gray-700">Phone <span
                                class="font-normal text-gray-400">(optional)</span></label>
                        <div class="flex overflow-hidden rounded-xl border border-gray-300"><span
                                class="flex items-center gap-2 border-r border-gray-200 bg-slate-50 px-3 text-sm font-semibold">PK
                                +92</span><input id="phone" type="tel" name="phone"
                                value="{{ old('phone', preg_replace('/^\+?92/', '', ltrim($teacher->phone ?? '', '0'))) }}"
                                inputmode="numeric" maxlength="10" pattern="[0-9]{10}" placeholder="3001234567"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="min-w-0 flex-1 border-0 px-4 py-3 text-sm focus:ring-0"></div>
                        @error('phone')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div><label for="qualification"
                            class="mb-2 block text-sm font-semibold text-gray-700">Qualification</label><input
                            id="qualification" name="qualification"
                            value="{{ old('qualification', $teacher->qualification) }}"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div><label for="subject" class="mb-2 block text-sm font-semibold text-gray-700">Subject</label><input
                            id="subject" name="subject" value="{{ old('subject', $teacher->subject) }}"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div><label for="salary" class="mb-2 block text-sm font-semibold text-gray-700">Monthly
                            salary</label><input id="salary" type="number" name="salary"
                            value="{{ old('salary', $teacher->salary) }}" min="0" step="0.01"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div><label for="joining_date" class="mb-2 block text-sm font-semibold text-gray-700">Joining
                            date</label><input id="joining_date" type="date" name="joining_date"
                            value="{{ old('joining_date', optional($teacher->joining_date)->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div><label for="contract_start_date" class="mb-2 block text-sm font-semibold text-gray-700">Contract
                            start date</label><input id="contract_start_date" type="date" name="contract_start_date"
                            value="{{ old('contract_start_date', optional($teacher->contract_start_date)->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div><label for="contract_end_date" class="mb-2 block text-sm font-semibold text-gray-700">Contract end
                            date</label><input id="contract_end_date" type="date" name="contract_end_date"
                            value="{{ old('contract_end_date', optional($teacher->contract_end_date)->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <div
                    class="student-form-actions mt-auto flex flex-col-reverse gap-3 border-t border-gray-100 pt-8 sm:flex-row sm:justify-end">
                    <a href="{{ route('teachers.index') }}"
                        class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Cancel</a><button
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">Save
                        changes</button></div>
            </form>
        </section>
    </div>
@endsection
