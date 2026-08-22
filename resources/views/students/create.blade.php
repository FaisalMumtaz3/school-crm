@extends('layouts.app')

@section('content')

<div class="py-6">
<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-xl font-semibold mb-4">Add Student</h2>

<form action="{{ route('students.store') }}" method="POST">
@csrf

<div class="mb-4">
<label class="block">Name</label>
<input type="text" name="name" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label class="block">Father Name</label>
<input type="text" name="father_name" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label class="block">Phone</label>
<input type="text" name="phone" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label class="block">Class</label>
<input type="text" name="class" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label class="block">Admission Date</label>
<input type="date" name="admission_date" class="w-full border rounded p-2">
</div>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
Save Student
</button>

</form>

</div>

</div>
</div>

@endsection
