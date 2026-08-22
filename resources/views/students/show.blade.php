@extends('layouts.app')

@section('content')

<div class="py-6">
<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-xl font-semibold mb-4">Student Details</h2>

<div class="space-y-3">

<p><strong>Name:</strong> {{ $student->name }}</p>
<p><strong>Father Name:</strong> {{ $student->father_name }}</p>
<p><strong>Phone:</strong> {{ $student->phone }}</p>
<p><strong>Class:</strong> {{ $student->class }}</p>
<p><strong>Admission Date:</strong> {{ $student->admission_date }}</p>

</div>

<a href="{{ route('students.index') }}"
class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded">
Back
</a>

</div>

</div>
</div>

@endsection
