<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ config('app.name', 'Laravel') }}</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">

        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            {{ config('app.name') }}
        </div>

        <nav class="flex-1 mt-4">

            <a href="/dashboard"
               class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('dashboard') ? 'bg-gray-700' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('students.index') }}"
               class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('students*') ? 'bg-gray-700' : '' }}">
                Students
            </a>

        </nav>

        <div class="p-6 border-t border-gray-700">

            <div class="mb-2 text-sm text-gray-400">
                {{ Auth::user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button class="text-red-400 hover:text-red-500">
                    Logout
                </button>
            </form>

        </div>

    </aside>


    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Topbar -->
        <header class="bg-white shadow">

            <div class="px-6 py-4 flex justify-between items-center">

                <h1 class="text-lg font-semibold">
                    Dashboard
                </h1>

                <div class="text-sm text-gray-600">
                    {{ now()->format('l, d M Y') }}
                </div>

            </div>

        </header>


        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>
