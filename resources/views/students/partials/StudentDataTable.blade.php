<section id="student-datatable" class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="flex shrink-0 flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h3 class="font-semibold text-gray-900">All students</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $students->total() }} {{ Str::plural('record', $students->total()) }} in your directory</p>
        </div>
        <form method="GET" action="{{ route('students.index') }}" data-student-filter-form class="grid gap-3 sm:grid-cols-2 lg:flex lg:items-center">
            <label class="relative block lg:w-64"><span class="sr-only">Search students</span><input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search students..." autocomplete="off" class="w-full rounded-xl border-gray-300 py-2.5 pl-3 pr-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><button type="submit" aria-label="Search students" class="absolute right-1.5 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-lg text-indigo-600 transition hover:bg-indigo-50"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" /></svg></button></label>
            <label><span class="sr-only">Filter by class</span><select name="class" class="w-full rounded-xl border-gray-300 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 lg:w-36"><option value="">All classes</option>@foreach ($classes as $class)<option value="{{ $class }}" @selected(($filters['class'] ?? '') === $class)>Class {{ $class }}</option>@endforeach</select></label>
            <label><span class="sr-only">Filter by section</span><select name="section" class="w-full rounded-xl border-gray-300 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 lg:w-36"><option value="">All sections</option>@foreach ($sections as $section)<option value="{{ $section }}" @selected(($filters['section'] ?? '') === $section)>Section {{ $section }}</option>@endforeach</select></label>
            @if (collect($filters)->filter()->isNotEmpty())<a href="{{ route('students.index') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Clear</a>@endif
        </form>
    </div>

    @if ($students->isEmpty())
        <div class="flex flex-1 items-center justify-center px-6 py-16 text-center"><div><h3 class="text-base font-semibold text-gray-900">No matching students</h3><p class="mt-1 text-sm text-gray-500">Try changing your search or filter criteria.</p><a href="{{ route('students.index') }}" class="mt-5 inline-flex rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">Clear filters</a></div></div>
    @else
        <div class="min-h-0 flex-1 overflow-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="sticky top-0 z-20 bg-gray-50"><tr>
                    @foreach ($columns as $column)
                        <th class="whitespace-nowrap px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $column['label'] }}</th>
                    @endforeach
                    <th class="relative px-6 py-3.5"><span class="sr-only">Actions</span></th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($students as $student)
                        <tr class="transition hover:bg-indigo-50/30">
                            @foreach ($columns as $column)
                                @php($value = data_get($student, $column['key']))
                                <td class="whitespace-nowrap px-6 py-4 text-sm {{ $column['key'] === 'roll_number' ? 'font-semibold text-gray-700' : 'text-gray-600' }}">
                                    @if ($column['key'] === 'name')
                                        <div class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-sm font-bold text-indigo-700">{{ strtoupper(substr($value, 0, 1)) }}</span><div><p class="font-semibold text-gray-900">{{ $value }}</p><p class="mt-0.5 text-xs text-gray-500">Roll {{ $student->roll_number ?: 'Not assigned' }}</p></div></div>
                                    @elseif ($column['key'] === 'class')
                                        <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700">Class {{ $value }}</span>
                                    @elseif ($column['key'] === 'admission_date')
                                        {{ $value ? \Carbon\Carbon::parse($value)->format('d M Y') : 'Not provided' }}
                                    @else
                                        {{ $value ?: 'Not assigned' }}
                                    @endif
                                </td>
                            @endforeach
                            <td class="relative whitespace-nowrap px-6 py-4 text-right"><details class="student-actions relative inline-block"><summary aria-label="Open actions for {{ $student->name }}" class="flex h-9 w-9 cursor-pointer list-none items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 [&::-webkit-details-marker]:hidden"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" /></svg></summary><div class="absolute right-0 top-full z-[9999] mt-2 w-40 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 text-left shadow-xl"><a href="{{ route('students.show', $student) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">View</a><a href="{{ route('students.edit', $student) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">Edit</a><form action="{{ route('students.destroy', $student) }}" method="POST" class="delete-student-form" data-student-name="{{ $student->name }}">@csrf @method('DELETE')<button type="submit" class="block w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50">Delete</button></form></div></details></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($students->hasPages())<div class="shrink-0 border-t border-gray-100 px-5 py-4 sm:px-6">{{ $students->links() }}</div>@endif
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let searchTimer;

    // Close an open row menu whenever focus moves outside that menu.
    document.addEventListener('click', function (event) {
        if (event.target.closest('.student-actions')) return;
        document.querySelectorAll('.student-actions[open]').forEach(function (menu) {
            menu.removeAttribute('open');
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') return;
        document.querySelectorAll('.student-actions[open]').forEach(function (menu) {
            menu.removeAttribute('open');
        });
    });

    // Replace only this module's table on search/filter changes.
    function loadStudentTable(form) {
        const table = document.querySelector('#student-datatable');
        const searchInput = form.querySelector('input[name="search"]');
        const shouldRestoreSearchFocus = document.activeElement === searchInput;
        const searchCursor = shouldRestoreSearchFocus ? searchInput.selectionStart : null;
        const query = new URLSearchParams(new FormData(form));
        table.classList.add('opacity-60', 'pointer-events-none');
        fetch(`${form.action}?${query.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
            .then((response) => response.text())
            .then((html) => {
                const replacement = new DOMParser().parseFromString(html, 'text/html').querySelector('#student-datatable');
                if (replacement) {
                    table.replaceWith(replacement);

                    if (shouldRestoreSearchFocus) {
                        const nextSearchInput = document.querySelector('[data-student-filter-form] input[name="search"]');
                        nextSearchInput.focus();
                        nextSearchInput.setSelectionRange(searchCursor, searchCursor);
                    }
                }
                window.history.replaceState({}, '', `${form.action}?${query.toString()}`);
            })
            .finally(() => document.querySelector('#student-datatable').classList.remove('opacity-60', 'pointer-events-none'));
    }

    document.addEventListener('submit', function (event) {
        const form = event.target.closest('[data-student-filter-form]');
        if (!form) return;
        event.preventDefault();
        loadStudentTable(form);
    });

    document.addEventListener('input', function (event) {
        if (!event.target.matches('[data-student-filter-form] input[name="search"]')) return;
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadStudentTable(event.target.form), 350);
    });

    document.addEventListener('change', function (event) {
        if (event.target.matches('[data-student-filter-form] select')) loadStudentTable(event.target.form);
    });
});
</script>
