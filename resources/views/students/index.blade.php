@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- School CRM Header -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6">School CRM</h1>

        <!-- Dashboard Navigation -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Dashboard</h2>
            <div class="flex space-x-6">
                <span class="text-gray-700">Students</span>
                <span class="text-gray-700">Attendance</span>
                <span class="text-gray-700">Fees</span>
            </div>
        </div>

        <!-- Separator -->
        <hr class="my-6 border-gray-300">

        <!-- Students Section -->
        <div class="mt-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Students</h2>

            <!-- Students Table - Full Width -->
            <div class="bg-white rounded-lg shadow overflow-hidden w-full">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/5">
                                Father Name Phone
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                Class
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $student->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $student->father_name }} {{ $student->phone }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $student->class }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Example static rows to match your image -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                Faisal Mumtaz
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                Mumtaz Khan 03319524491
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                5
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <form action="#" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                Faisal Mumtaz
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                Mumtaz Khan 03319524491
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                5
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <form action="#" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
