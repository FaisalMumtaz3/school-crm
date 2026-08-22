@extends('layouts.app')

@section('content')

<div class="py-6">
<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-xl font-semibold mb-4">Edit Student</h2>

<form action="{{ route('students.update',$student->id) }}" method="POST">
@csrf
@method('PUT')

<div class="mb-4">
<label>Name</label>
<input type="text" name="name" value="{{ $student->name }}" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label>Father Name</label>
<input type="text" name="father_name" value="{{ $student->father_name }}" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label>Phone</label>
<input type="text" name="phone" value="{{ $student->phone }}" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label>Class</label>
<input type="text" name="class" value="{{ $student->class }}" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label>Admission Date</label>
<input type="date" name="admission_date" value="{{ $student->admission_date }}" class="w-full border rounded p-2">
</div>

<button class="bg-green-500 text-white px-4 py-2 rounded">
Update Student
</button>

</form>

</div>

</div>
</div>

@endsection
