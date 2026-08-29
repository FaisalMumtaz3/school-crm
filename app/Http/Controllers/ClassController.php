<?php

namespace App\Http\Controllers;

use App\DataTables\ClassDataTable;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(ClassDataTable $table)
    {
        $tableData = $table->viewData();

        // AJAX requests replace only the table, keeping the page shell in place.
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
            'name' => 'required|string|max:255|unique:classes,name',
        ]);

        SchoolClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully');
    }

    public function show(SchoolClass $schoolClass)
    {
        return view('classes.show', compact('schoolClass'));
    }

    public function edit(SchoolClass $schoolClass)
    {
        return view('classes.edit', compact('schoolClass'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classes,name,' . $schoolClass->id,
        ]);

        $schoolClass->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully');
    }
}
