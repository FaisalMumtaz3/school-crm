<?php

namespace App\Http\Controllers;

use App\DataTables\StudentDataTable;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(StudentDataTable $table)
    {
        $tableData = $table->viewData();

        if (request()->ajax()) {
            return view('students.partials.StudentDataTable', $tableData);
        }

        return view('students.index', $tableData);
    }

    public function create()
    {
        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();

        $classes = SchoolClass::query()
            ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
            ->orderBy('name')
            ->get();

        $sections = Section::query()
            ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
            ->orderBy('name')
            ->get();

        return view('students.create', compact('classes', 'sections'));
    }

    public function store(Request $request)
    {
        $this->normalizePhone($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => ['nullable', 'regex:/^\+92[0-9]{10}$/'],
            'class' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
            'roll_number' => 'nullable|integer|min:1',
            'admission_date' => 'nullable|date'
        ]);

        $user = Auth::user();
        $validated['school_id'] = $user->isAdmin() ? $request->input('school_id') : $user->school_id;

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success','Student created successfully');
    }

    public function show(Student $student)
    {
        $this->authorizeSchoolAccess($student->school_id);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $this->authorizeSchoolAccess($student->school_id);

        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();

        $classes = SchoolClass::query()
            ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
            ->orderBy('name')
            ->get();

        $sections = Section::query()
            ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
            ->orderBy('name')
            ->get();

        return view('students.edit', compact('student', 'classes', 'sections'));
    }

    public function update(Request $request, Student $student)
    {
        $this->authorizeSchoolAccess($student->school_id);
        $this->normalizePhone($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => ['nullable', 'regex:/^\+92[0-9]{10}$/'],
            'class' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
            'roll_number' => 'nullable|integer|min:1',
            'admission_date' => 'nullable|date'
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success','Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $this->authorizeSchoolAccess($student->school_id);

        $student->delete();

        return redirect()->route('students.index')
            ->with('success','Student deleted successfully');
    }

    private function authorizeSchoolAccess(?int $schoolId): void
    {
        $user = Auth::user();

        if (!$user->canAccessSchool($schoolId)) {
            abort(403, 'Unauthorized access to this school\'s data.');
        }
    }

    private function normalizePhone(Request $request): void
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $request->input('phone'));

        if ($phone === '') {
            $request->merge(['phone' => null]);
            return;
        }

        if (str_starts_with($phone, '92')) {
            $phone = substr($phone, 2);
        }

        if (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1);
        }

        $request->merge(['phone' => '+92' . $phone]);
    }
}