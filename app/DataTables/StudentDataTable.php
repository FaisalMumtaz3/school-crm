<?php

namespace App\DataTables;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class StudentDataTable
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    public function viewData(): array
    {
        $filters = $this->request->validate([
            'search' => 'nullable|string|max:100',
            'class' => 'nullable|integer',
            'section' => 'nullable|integer',
        ]);

        $studentsQuery = Student::query()
            ->with([
                'schoolClass',
                'StudentSection',
            ]);

        /*
         * Search
         */
        $studentsQuery->when(
            $filters['search'] ?? null,
            function ($query, $search) {
                $query->where(function ($studentQuery) use ($search) {
                    $studentQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('father_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('roll_number', 'like', "%{$search}%");
                });
            }
        );

        /*
         * Filter by Class ID
         *
         * Students table column is `class`
         */
        $studentsQuery->when(
            $filters['class'] ?? null,
            fn ($query, $class) =>
                $query->where('class', $class)
        );

        /*
         * Filter by Section ID
         *
         * Students table column is `section`
         */
        $studentsQuery->when(
            $filters['section'] ?? null,
            fn ($query, $section) =>
                $query->where('section', $section)
        );

        return [

            /*
             * Students
             */
            'students' => $studentsQuery
                ->latest()
                ->paginate(10)
                ->withQueryString(),

            /*
             * Classes dropdown
             */
            'classes' => SchoolClass::query()
                ->orderBy('name')
                ->get(),

            /*
             * Sections dropdown
             */
            'sections' => Section::query()
                ->with('schoolClass')
                ->orderBy('name')
                ->get(),

            /*
             * Active filters
             */
            'filters' => $filters,

            /*
             * Table columns
             */
            'columns' => $this->columns(),
        ];
    }

    /*
     * Single source of truth for fields displayed
     * in the student table.
     */
    public function columns(): array
    {
        return [
            [
                'key' => 'name',
                'label' => 'Student',
            ],

            [
                'key' => 'father_name',
                'label' => 'Father name',
            ],

            [
                'key' => 'schoolClass.name',
                'label' => 'Class',
            ],

            [
                'key' => 'StudentSection.name',
                'label' => 'Section',
            ],
        ];
    }
}
