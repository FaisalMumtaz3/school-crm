<?php

namespace App\Http\Controllers;

use App\DataTables\ClassDataTable;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index(ClassDataTable $table)
    {
        $tableData = $table->viewData();

        if (request()->ajax()) {
            return view('classes.partials.ClassDataTable', $tableData);
        }

        return view('classes.index', $tableData);
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $validated['school_id'] = $user->isAdmin() ? $request->input('school_id') : $user->school_id;

        // For admin, check uniqueness across all schools, for school admin check within their school
        if ($user->isAdmin() && $request->filled('school_id')) {
            $exists = SchoolClass::where('name', $validated['name'])
                ->where('school_id', $request->input('school_id'))
                ->exists();
        } else {
            $exists = SchoolClass::where('name', $validated['name'])
                ->where('school_id', $validated['school_id'])
                ->exists();
        }

        if ($exists) {
            return back()
                ->withErrors(['name' => 'This class already exists in the selected school.'])
                ->withInput();
        }

        SchoolClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully');
    }

    public function show(SchoolClass $schoolClass)
    {
        $this->authorizeSchoolAccess($schoolClass->school_id);

        return view('classes.show', compact('schoolClass'));
    }

    public function edit(SchoolClass $schoolClass)
    {
        $this->authorizeSchoolAccess($schoolClass->school_id);

        return view('classes.edit', compact('schoolClass'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $this->authorizeSchoolAccess($schoolClass->school_id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Check uniqueness
        $user = Auth::user();
        if ($user->isAdmin() && $request->filled('school_id')) {
            $exists = SchoolClass::where('name', $validated['name'])
                ->where('school_id', $request->input('school_id'))
                ->where('id', '!=', $schoolClass->id)
                ->exists();
        } else {
            $exists = SchoolClass::where('name', $validated['name'])
                ->where('school_id', $schoolClass->school_id)
                ->where('id', '!=', $schoolClass->id)
                ->exists();
        }

        if ($exists) {
            return back()
                ->withErrors(['name' => 'This class already exists in the selected school.'])
                ->withInput();
        }

        $schoolClass->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $this->authorizeSchoolAccess($schoolClass->school_id);

        $schoolClass->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully');
    }

    private function authorizeSchoolAccess(?int $schoolId): void
    {
        $user = Auth::user();

        if (!$user->canAccessSchool($schoolId)) {
            abort(403, 'Unauthorized access to this school\'s data.');
        }
    }
}