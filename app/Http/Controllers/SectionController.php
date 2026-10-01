<?php

namespace App\Http\Controllers;

use App\DataTables\SectionDataTable;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $validated['school_id'] = $user->isAdmin() ? $request->input('school_id') : $user->school_id;

        $exists = Section::where('name', $validated['name'])
            ->where('school_id', $validated['school_id'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'This section already exists in the selected school.',
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
        $this->authorizeSchoolAccess($section->school_id);

        return view(
            'sections.show',
            compact('section')
        );
    }

    public function edit(Section $section)
    {
        $this->authorizeSchoolAccess($section->school_id);

        return view(
            'sections.edit',
            compact('section')
        );
    }

    public function update(Request $request, Section $section)
    {
        $this->authorizeSchoolAccess($section->school_id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exists = Section::where('name', $validated['name'])
            ->where('school_id', $section->school_id)
            ->where('id', '!=', $section->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'This section already exists in the selected school.',
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
        $this->authorizeSchoolAccess($section->school_id);

        $section->delete();

        return redirect()
            ->route('sections.index')
            ->with('success', 'Section deleted successfully');
    }

    private function authorizeSchoolAccess(?int $schoolId): void
    {
        $user = Auth::user();

        if (!$user->canAccessSchool($schoolId)) {
            abort(403, 'Unauthorized access to this school\'s data.');
        }
    }
}