@extends('layouts.app')

@section('content')

<div class="student-form-page flex min-h-full w-full flex-col">
	<div class="mb-8">
		<a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 transition hover:text-indigo-600">
			<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6" /></svg>
			Back to students
		</a>
		<p class="mt-6 text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Student directory</p>
		<h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">Add student</h2>
		<p class="mt-2 text-sm text-gray-500">Create a new student record with their family and admission details.</p>
	</div>

	@if ($errors->any())
		<div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
			<p class="font-semibold">Please correct the highlighted fields.</p>
			<ul class="mt-1 list-inside list-disc">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<section class="student-form-card flex flex-1 flex-col overflow-visible rounded-2xl border border-gray-200 bg-white shadow-sm">
		{{-- <div class="border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-sky-50 px-6 py-5 sm:px-8">
			<div class="flex items-center gap-4">
				<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">
					<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 20a6 6 0 0 0-12 0m6-8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-1h4m-2-2v4" /></svg>
				</span>
				<div>
					<h3 class="font-semibold text-gray-900">Student information</h3>
					<p class="mt-1 text-sm text-gray-500">Fields marked with <span class="text-red-500">*</span> are required.</p>
				</div>
			</div>
		</div> --}}

		<form action="{{ route('students.store') }}" method="POST" class="student-form flex flex-1 flex-col px-6 py-6 sm:px-8 sm:py-8">
			@csrf
			<div class="grid gap-6 sm:grid-cols-2">
				<div>
					<label for="name" class="mb-2 block text-sm font-semibold text-gray-700">Student name <span class="text-red-500">*</span></label>
					<input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. Ayesha Khan" class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror">
					@error('name')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
				</div>
				<div>
					<label for="father_name" class="mb-2 block text-sm font-semibold text-gray-700">Father name <span class="text-red-500">*</span></label>
					<input id="father_name" type="text" name="father_name" value="{{ old('father_name') }}" required placeholder="e.g. Imran Khan" class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 @error('father_name') border-red-300 @enderror">
					@error('father_name')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
				</div>
				<div>
					<label for="phone" class="mb-2 block text-sm font-semibold text-gray-700">Phone number <span class="font-normal text-gray-400">(optional)</span></label>
					<div class="flex overflow-hidden rounded-xl border border-gray-300 bg-white shadow-sm transition focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 @error('phone') border-red-300 @enderror">
						<span class="flex items-center gap-2 border-r border-gray-200 bg-slate-50 px-3 text-sm font-semibold text-slate-700"><span class="flex h-5 w-7 items-center justify-center rounded bg-emerald-600 text-[9px] font-bold text-white">PK</span>+92</span>
						<input id="phone" type="tel" name="phone" value="{{ old('phone') ? preg_replace('/^\+?92/', '', old('phone')) : '' }}" inputmode="numeric" autocomplete="tel-national" maxlength="10" pattern="[0-9]{10}" title="Enter 10 digits after the +92 country code" placeholder="3001234567" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="min-w-0 flex-1 border-0 px-4 py-3 text-sm placeholder:text-gray-400 focus:ring-0">
					</div>
					<p class="mt-1.5 text-xs text-gray-500">Enter 10 digits after the +92 country code.</p>
					@error('phone')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
				</div>
				<div>
					<label
						for="class"
						class="mb-2 block text-sm font-semibold text-gray-700">
						Class <span class="text-red-500">*</span>
					</label>

				<select
					id="class"
					name="class"
					required
					class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 @error('class') border-red-300 @enderror"
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
					<p class="mt-1.5 text-sm text-red-600">
						{{ $message }}
					</p>
				@enderror

				</div>

				<div>
					<label
						for="section"
						class="mb-2 block text-sm font-semibold text-gray-700"
					>
						Section
						<span class="font-normal text-gray-400">
							(optional)
						</span>
					</label>

				<select
					id="section"
					name="section"
					class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 @error('section') border-red-300 @enderror"
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
					<p class="mt-1.5 text-sm text-red-600">
						{{ $message }}
					</p>
				@enderror


				</div>
				<div>
					<label for="roll_number" class="mb-2 block text-sm font-semibold text-gray-700">Roll number <span class="font-normal text-gray-400">(optional)</span></label>
					<input id="roll_number" type="number" name="roll_number" value="{{ old('roll_number') }}" min="1" step="1" inputmode="numeric" placeholder="e.g. 12" class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 @error('roll_number') border-red-300 @enderror">
					@error('roll_number')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
				</div>
				<div class="sm:col-span-2">
					<label for="admission_date" class="mb-2 block text-sm font-semibold text-gray-700">Admission date <span class="font-normal text-gray-400">(optional)</span></label>
					<input id="admission_date" type="date" name="admission_date" value="{{ old('admission_date') }}" class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 @error('admission_date') border-red-300 @enderror sm:max-w-md">
					@error('admission_date')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
				</div>
			</div>

			<div class="student-form-actions mt-auto flex flex-col-reverse gap-3 border-t border-gray-100 pt-8 sm:flex-row sm:justify-end">
				<a href="{{ route('students.index') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Cancel</a>
				<button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
					<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
					Save student
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

