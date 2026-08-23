<?php

namespace App\Http\Controllers;

use App\DataTables\TeacherDataTable;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(TeacherDataTable $table): View
    {
        $tableData = $table->viewData();

        if (request()->ajax()) {
            return view('teachers.partials.TeacherDataTable', $tableData);
        }

        return view('teachers.index', $tableData);
    }

    public function create(): View
    {
        return view('teachers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->normalizePhone($request);

        Teacher::create($request->validate($this->rules()));

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully');
    }

    public function show(Teacher $teacher): View
    {
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher): View
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $this->normalizePhone($request);

        $teacher->update($request->validate($this->rules()));

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully');
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => ['nullable', 'regex:/^\+92[0-9]{10}$/'],
            'qualification' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:100',
            'salary' => 'nullable|numeric|min:0|max:9999999999.99',
            'joining_date' => 'nullable|date',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after_or_equal:contract_start_date',
        ];
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

        $request->merge(['phone' => '+92'.$phone]);
    }
}
