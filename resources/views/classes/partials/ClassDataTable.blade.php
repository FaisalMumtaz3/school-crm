<section
    id="class-datatable"
    class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
>


{{-- Table Header --}}
<div
    class="flex shrink-0 flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
>

    <div>
        <h3 class="font-semibold text-gray-900">
            All classes
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            {{ $classes->total() }}
            {{ Str::plural('record', $classes->total()) }}
            in your directory
        </p>
    </div>

    {{-- Export --}}
    {{-- <a
        href="{{ route('classes.export', [
            'search' => request('search'),
        ]) }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
    >
        <svg
            class="h-4 w-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"
            />
        </svg>

        Export Excel
    </a> --}}

    {{-- Search --}}
    <form
        method="GET"
        action="{{ route('classes.index') }}"
        data-class-filter-form
        class="grid gap-3 sm:grid-cols-2 lg:flex lg:items-center"
    >
        <label class="relative block lg:w-64">
            <span class="sr-only">
                Search classes
            </span>

            <input
                type="search"
                name="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Search classes..."
                autocomplete="off"
                class="w-full rounded-xl border-gray-300 py-2.5 pl-3 pr-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >

            <button
                type="submit"
                aria-label="Search classes"
                class="absolute right-1.5 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-lg text-indigo-600 transition hover:bg-indigo-50"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                    />
                </svg>
            </button>
        </label>

        @if (collect($filters)->filter()->isNotEmpty())
            <a
                href="{{ route('classes.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Clear
            </a>
        @endif
    </form>

</div>


{{-- Empty State --}}
@if ($classes->isEmpty())

    <div class="flex flex-1 items-center justify-center px-6 py-16 text-center">
        <div>
            <h3 class="text-base font-semibold text-gray-900">
                No matching classes
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Try changing your search criteria.
            </p>

            <a
                href="{{ route('classes.index') }}"
                class="mt-5 inline-flex rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
            >
                Clear filters
            </a>
        </div>
    </div>

@else

    {{-- Table --}}
    <div class="min-h-0 flex-1 overflow-auto">

        <table class="min-w-full divide-y divide-gray-100">

            <thead class="sticky top-0 z-20 bg-gray-50">
                <tr>

                    @foreach ($columns as $column)
                        <th
                            class="whitespace-nowrap px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                        >
                            {{ $column['label'] }}
                        </th>
                    @endforeach

                    <th class="relative px-6 py-3.5">
                        <span class="sr-only">
                            Actions
                        </span>
                    </th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                @foreach ($classes as $schoolClass)

                    <tr class="transition hover:bg-indigo-50/30">

                        @foreach ($columns as $column)

                            @php
                                $value = data_get($schoolClass, $column['key']);
                            @endphp

                            <td
                                class="whitespace-nowrap px-6 py-4 text-sm text-gray-600"
                            >

                                @if ($column['key'] === 'name')

                                    <div class="flex items-center gap-3">

                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-sm font-bold text-indigo-700"
                                        >
                                            {{ strtoupper(substr($value, 0, 1)) }}
                                        </span>

                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ $value }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-gray-500">
                                                Class
                                            </p>
                                        </div>

                                    </div>

                                @else

                                    {{ $value ?: 'Not assigned' }}

                                @endif

                            </td>

                        @endforeach


                        {{-- Actions --}}
                        <td class="relative whitespace-nowrap px-6 py-4 text-right">

                            <details class="class-actions relative inline-block">

                                <summary
                                    aria-label="Open actions for {{ $schoolClass->name }}"
                                    class="flex h-9 w-9 cursor-pointer list-none items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 [&::-webkit-details-marker]:hidden"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M12 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"
                                        />
                                    </svg>
                                </summary>

                                <div
                                    class="absolute right-0 top-full z-[9999] mt-2 w-40 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 text-left shadow-xl"
                                >

                                    <a
                                        href="{{ route('classes.show', $schoolClass) }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('classes.edit', $schoolClass) }}"
                                        class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('classes.destroy', $schoolClass) }}"
                                        method="POST"
                                        class="delete-class-form"
                                        data-class-name="{{ $schoolClass->name }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="block w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                </div>

                            </details>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if ($classes->hasPages())
        <div class="shrink-0 border-t border-gray-100 px-5 py-4 sm:px-6">
            {{ $classes->links() }}
        </div>
    @endif

@endif


</section>

<script>

document.addEventListener('DOMContentLoaded', function () {

    let searchTimer;

    /*
     * Close an open action menu when clicking outside.
     */
    document.addEventListener('click', function (event) {

        if (event.target.closest('.class-actions')) {
            return;
        }

        document
            .querySelectorAll('.class-actions[open]')
            .forEach(function (menu) {
                menu.removeAttribute('open');
            });

    });


    /*
     * Close action menu with Escape.
     */
    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        document
            .querySelectorAll('.class-actions[open]')
            .forEach(function (menu) {
                menu.removeAttribute('open');
            });

    });


    /*
     * Reload only the class datatable.
     */
    function loadClassTable(form) {

        const table = document.querySelector('#class-datatable');

        const searchInput = form.querySelector(
            'input[name="search"]'
        );

        const shouldRestoreSearchFocus =
            document.activeElement === searchInput;

        const searchCursor =
            shouldRestoreSearchFocus
                ? searchInput.selectionStart
                : null;

        const query =
            new URLSearchParams(new FormData(form));

        table.classList.add(
            'opacity-60',
            'pointer-events-none'
        );

        fetch(
            `${form.action}?${query.toString()}`,
            {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            }
        )
        .then((response) => response.text())

        .then((html) => {

            const replacement =
                new DOMParser()
                    .parseFromString(html, 'text/html')
                    .querySelector('#class-datatable');

            if (replacement) {

                table.replaceWith(replacement);

                if (shouldRestoreSearchFocus) {

                    const nextSearchInput =
                        document.querySelector(
                            '[data-class-filter-form] input[name="search"]'
                        );

                    nextSearchInput.focus();

                    nextSearchInput.setSelectionRange(
                        searchCursor,
                        searchCursor
                    );

                }

            }

            window.history.replaceState(
                {},
                '',
                `${form.action}?${query.toString()}`
            );

        })

        .finally(() => {

            const currentTable =
                document.querySelector('#class-datatable');

            if (currentTable) {
                currentTable.classList.remove(
                    'opacity-60',
                    'pointer-events-none'
                );
            }

        });

    }


    /*
     * Search form.
     */
    document.addEventListener('submit', function (event) {

        const form =
            event.target.closest(
                '[data-class-filter-form]'
            );

        if (!form) {
            return;
        }

        event.preventDefault();

        loadClassTable(form);

    });


    /*
     * Live search.
     */
    document.addEventListener('input', function (event) {

        if (
            !event.target.matches(
                '[data-class-filter-form] input[name="search"]'
            )
        ) {
            return;
        }

        clearTimeout(searchTimer);

        searchTimer = setTimeout(
            () => loadClassTable(event.target.form),
            350
        );

    });

});

</script>
