<section id="teacher-datatable"
    class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div
        class="flex shrink-0 flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h3 class="font-semibold text-gray-900">All teachers</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $teachers->total() }}
                {{ Str::plural('record', $teachers->total()) }} in your directory</p>
        </div>
        <form method="GET" action="{{ route('teachers.index') }}" data-teacher-filter-form
            class="grid gap-3 sm:grid-cols-2 lg:flex lg:items-center">
            <label class="relative block lg:w-64"><span class="sr-only">Search teachers</span><input type="search"
                    name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search teachers..."
                    autocomplete="off"
                    class="w-full rounded-xl border-gray-300 py-2.5 pl-3 pr-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><button
                    type="submit" aria-label="Search teachers"
                    class="absolute right-1.5 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-lg text-indigo-600 hover:bg-indigo-50"><svg
                        class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg></button></label>
            <label><span class="sr-only">Filter by subject</span><select name="subject"
                    class="w-full rounded-xl border-gray-300 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 lg:w-36">
                    <option value="">All subjects</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject }}" @selected(($filters['subject'] ?? '') === $subject)>{{ $subject }}</option>
                    @endforeach
                </select>
            </label>
            <label><span class="sr-only">Filter by qualification</span><select name="qualification"
                    class="w-full rounded-xl border-gray-300 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 lg:w-40">
                    <option value="">All qualifications</option>
                    @foreach ($qualifications as $qualification)
                        <option value="{{ $qualification }}" @selected(($filters['qualification'] ?? '') === $qualification)>{{ $qualification }}</option>
                    @endforeach
                </select></label>
            @if (collect($filters)->filter()->isNotEmpty())
                <a href="{{ route('teachers.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Clear</a>
            @endif
        </form>
    </div>
    @if ($teachers->isEmpty())
        <div class="flex flex-1 items-center justify-center px-6 py-16 text-center">
            <div>
                <h3 class="text-base font-semibold text-gray-900">No matching teachers</h3>
                <p class="mt-1 text-sm text-gray-500">Try changing your search or filters.</p><a
                    href="{{ route('teachers.index') }}"
                    class="mt-5 inline-flex rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">Clear
                    filters</a>
            </div>
        </div>
    @else
        <div class="min-h-0 flex-1 overflow-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="sticky top-0 z-20 bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Teacher</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Father name</th>
                        {{-- <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Phone</th> --}}
                        <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Qualification</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Subject</th>
                        {{-- <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Salary</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Contract</th> --}}
                        <th class="px-6 py-3.5"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($teachers as $teacher)
                        <tr class="transition hover:bg-indigo-50/30">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3"><span
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-sm font-bold text-indigo-700">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $teacher->name }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">Teaching staff</p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">{{ $teacher->father_name }}
                            </td>
                            {{-- <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                {{ $teacher->phone ?: 'Not provided' }}</td> --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                {{ $teacher->qualification ?: 'Not provided' }}</td> 
                            <td class="whitespace-nowrap px-6 py-4"><span
                                    class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700">{{ $teacher->subject ?: 'General' }}</span>
                            </td>
                            {{-- <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-700">
                                {{ $teacher->salary !== null ? number_format((float) $teacher->salary, 2) : 'Not set' }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                {{ $teacher->contract_start_date ? \Carbon\Carbon::parse($teacher->contract_start_date)->format('d M Y') : 'Not set' }}<span
                                    class="text-gray-400"> to
                                </span>{{ $teacher->contract_end_date ? \Carbon\Carbon::parse($teacher->contract_end_date)->format('d M Y') : 'Open' }}
                            </td> --}}
                            <td class="relative whitespace-nowrap px-6 py-4 text-right">
                                <details class="teacher-actions relative inline-block">
                                    <summary aria-label="Open actions for {{ $teacher->name }}"
                                        class="flex h-9 w-9 cursor-pointer list-none items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 [&::-webkit-details-marker]:hidden">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M12 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                        </svg></summary>
                                    <div
                                        class="absolute right-0 top-full z-20 mt-2 w-40 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 text-left shadow-xl">
                                        <a href="{{ route('teachers.show', $teacher) }}"
                                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50">View</a><a
                                            href="{{ route('teachers.edit', $teacher) }}"
                                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50">Edit</a>
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST"
                                            class="delete-teacher-form" data-student-name="{{ $teacher->name }}">@csrf
                                            @method('DELETE')<button type="submit"
                                                class="block w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50">Delete</button>
                                        </form>
                                    </div>
                                </details>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($teachers->hasPages())
            <div class="shrink-0 border-t border-gray-100 px-5 py-4 sm:px-6">{{ $teachers->links() }}</div>
        @endif
    @endif
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let searchTimer;

        // Replace only the teacher table when staff search or filters change.
        function loadTeacherTable(form) {
            const table = document.querySelector('#teacher-datatable');
            const searchInput = form.querySelector('input[name="search"]');
            const keepFocus = document.activeElement === searchInput;
            const cursor = keepFocus ? searchInput.selectionStart : null;
            const query = new URLSearchParams(new FormData(form));

            table.classList.add('opacity-60', 'pointer-events-none');
            fetch(`${form.action}?${query.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then((response) => response.text())
                .then((html) => {
                    const replacement = new DOMParser().parseFromString(html, 'text/html').querySelector(
                        '#teacher-datatable');
                    if (replacement) {
                        table.replaceWith(replacement);
                        if (keepFocus) {
                            const nextInput = document.querySelector(
                                '[data-teacher-filter-form] input[name="search"]');
                            nextInput.focus();
                            nextInput.setSelectionRange(cursor, cursor);
                        }
                    }
                    window.history.replaceState({}, '', `${form.action}?${query.toString()}`);
                })
                .finally(() => document.querySelector('#teacher-datatable').classList.remove('opacity-60',
                    'pointer-events-none'));
        }

        document.addEventListener('submit', function(event) {
            const form = event.target.closest('[data-teacher-filter-form]');
            if (!form) return;
            event.preventDefault();
            loadTeacherTable(form);
        });

        document.addEventListener('input', function(event) {
            if (!event.target.matches('[data-teacher-filter-form] input[name="search"]')) return;
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => loadTeacherTable(event.target.form), 350);
        });

        document.addEventListener('change', function(event) {
            if (event.target.matches('[data-teacher-filter-form] select')) loadTeacherTable(event.target
                .form);
        });
    });
</script>
