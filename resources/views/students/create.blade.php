@extends('layouts.app')

@section('content')

<div class="student-form-page flex min-h-full w-full flex-col">
    <div class="mb-8">
        <a href="{{ route('students.index') }}" class="btn btn-ghost text-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6" /></svg>
            Back to Students
        </a>
        <p class="mt-6 text-sm font-semibold uppercase tracking-wide text-primary-600">Student Directory</p>
        <h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">Add Student</h2>
        <p class="mt-2 text-sm text-gray-500">Create a new student record with their family and admission details.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-danger-200 bg-danger-50 px-4 py-3 text-sm text-danger-700" role="alert">
            <p class="font-semibold">Please correct the highlighted fields.</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="student-form-card flex flex-1 flex-col overflow-visible card">
        <form action="{{ route('students.store') }}" method="POST" class="student-form flex flex-1 flex-col p-6">
            @csrf
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="name" class="form-label">Student name <span class="text-danger-500">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. Ayesha Khan" class="form-input @error('name') border-danger-300 @enderror">
                    @error('name')<p class="mt-1.5 text-sm text-danger-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="father_name" class="form-label">Father name <span class="text-danger-500">*</span></label>
                    <input id="father_name" type="text" name="father_name" value="{{ old('father_name') }}" required placeholder="e.g. Imran Khan" class="form-input @error('father_name') border-danger-300 @enderror">
                    @error('father_name')<p class="mt-1.5 text-sm text-danger-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="form-label">Phone number <span class="font-normal text-gray-400">(optional)</span></label>
                    <div class="flex overflow-hidden rounded-xl border border-gray-300 bg-white shadow-sm transition focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-primary-500 @error('phone') border-danger-300 @enderror">
                        <span class="flex items-center gap-2 border-r border-gray-200 bg-slate-50 px-3 text-sm font-semibold text-slate-700"><span class="flex h-5 w-7 items-center justify-center rounded bg-success-600 text-[9px] font-bold text-white">PK</span>+92</span>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') ? preg_replace('/^\+?92/', '', old('phone')) : '' }}" inputmode="numeric" autocomplete="tel-national" maxlength="10" pattern="[0-9]{10}" title="Enter 10 digits after the +92 country code" placeholder="3001234567" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="min-w-0 flex-1 border-0 px-4 py-3 text-sm placeholder:text-gray-400 focus:ring-0">
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500">Enter 10 digits after the +92 country code.</p>
                    @error('phone')<p class="mt-1.5 text-sm text-danger-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label
                        for="class"
                        class="form-label">
                        Class <span class="text-danger-500">*</span>
                    </label>

                <select
                    id="class"
                    name="class"
                    required
                    class="form-input form-select @error('class') border-danger-300 @enderror"
                >

                    <option value="">
                        Select class
                    </option>

                    @foreach ($classes as $class)

                        <option
                            value="{{ $class->id }}"
                            {{ old('class') == $class->id ? 'selected' : '' }}
                            {{ $class->name }}
                        </option>

                    @endforeach

                </select>

                @error('class')
                    <p class="mt-1.5 text-sm text-danger-600">
                        {{ $message }}
                    </p>
                @enderror

                </div>

                <div>
                    <label
                        for="section"
                        class="form-label"
                    >
                        Section
                        <span class="font-normal text-gray-400">
                            (optional)
                        </span>
                    </label>

                <select
                    id="section"
                    name="section"
                    class="form-input form-select @error('section') border-danger-300 @enderror"
                >

                    <option value="">
                        Select section
                    </option>

                    @foreach ($sections as $section)
                        <option
                            value="{{ $section->id }}"
                            @selected((string) old('section') === (string) $section->id)
                        >
                            {{ $section->name }}
                        </option>
                    @endforeach

                </select>

                @error('section')
                    <p class="mt-1.5 text-sm text-danger-600">
                        {{ $message }}
                    </p>
                @enderror


                </div>
                <div>
                    <label for="roll_number" class="form-label">Roll number <span class="font-normal text-gray-400">(optional)</span></label>
                    <input id="roll_number" type="number" name="roll_number" value="{{ old('roll_number') }}" min="1" step="1" inputmode="numeric" placeholder="e.g. 12" class="form-input @error('roll_number') border-danger-300 @enderror">
                    @error('roll_number')<p class="mt-1.5 text-sm text-danger-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="admission_date" class="form-label">Admission date <span class="font-normal text-gray-400">(optional)</span></label>
                    <input id="admission_date" type="date" name="admission_date" value="{{ old('admission_date') }}" class="form-input @error('admission_date') border-danger-300 @enderror sm:max-w-md">
                    @error('admission_date')<p class="mt-1.5 text-sm text-danger-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="student-form-actions mt-auto flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Save Student
                </button>
            </div>
        </form>
    </section>
</div>

@endsection
<script>

document.addEventListener('DOMContentLoaded', function () {

    const classSelect = document.getElementById('class');
    const sectionSelect = document.getElementById('section');

    if (!classSelect || !sectionSelect) {
        console.error('Class or Section select not found.');
        return;
    }


    function loadSections(classId, selectedSection = '') {

        return;

        sectionSelect.innerHTML =
            '<option value="">Select section</option>';

        if (!classId) {
            return;
        }


        /*
         * Laravel-generated route.
         * __CLASS_ID__ will be replaced with
         * the selected class ID.
         */
        let url =
            '';

        url = url.replace(
            '__CLASS_ID__',
            classId
        );


        fetch(url, {
            method: 'GET',

            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }

        })

        .then(response => {

            if (!response.ok) {
                throw new Error(
                    'HTTP error: ' + response.status
                );
            }

            return response.json();

        })

        .then(sections => {

            sectionSelect.innerHTML =
                '<option value="">Select section</option>';


            sections.forEach(section => {

                const option =
                    document.createElement('option');

                option.value = section.id;

                option.textContent = section.name;


                if (
                    selectedSection &&
                    selectedSection == section.id
                ) {
                    option.selected = true;
                }


                sectionSelect.appendChild(option);

            });

        })

        .catch(error => {

            console.error(
                'Unable to load sections:',
                error
            );

            sectionSelect.innerHTML =
                '<option value="">Unable to load sections</option>';

        });

    }


    /*
     * Load sections when class changes.
     */
    classSelect.addEventListener('change', function () {

        loadSections(
            this.value
        );

    });


    /*
     * Restore old section after validation error.
     */
    const oldClass =
        classSelect.value;

    const oldSection =
        "{{ old('section') }}";


    if (oldClass) {

        loadSections(
            oldClass,
            oldSection
        );

    }

});

</script>