<?php

namespace App\Http\Controllers;

use App\DataTables\SectionDataTable;
use App\Models\Section;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(SectionDataTable $table)
    {
        $tableData = $table->viewData();

        if (request()->ajax()) {
            return view(
                'sections.partials.SectionDataTable',
                $tableData
            );
        }

        return view(
            'sections.index',
            $tableData
        );
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view('sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
        ]);

        $exists = Section::where('class_id', $validated['class_id'])
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'This section already exists in the selected class.',
                ])
                ->withInput();
        }

        Section::create($validated);

        return redirect()
            ->route('sections.index')
            ->with('success', 'Section created successfully');
    }

    public function show(Section $section)
    {
        $section->load('schoolClass');

        return view(
            'sections.show',
            compact('section')
        );
    }

    public function edit(Section $section)
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view(
            'sections.edit',
            compact('section', 'classes')
        );
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
        ]);

        $exists = Section::where('class_id', $validated['class_id'])
            ->where('name', $validated['name'])
            ->where('id', '!=', $section->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'This section already exists in the selected class.',
                ])
                ->withInput();
        }

        $section->update($validated);

        return redirect()
            ->route('sections.index')
            ->with('success', 'Section updated successfully');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()
            ->route('sections.index')
            ->with('success', 'Section deleted successfully');
    }
}
