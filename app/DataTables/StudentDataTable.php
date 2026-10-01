<?php

namespace App\DataTables;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'studentSection',
                'school',
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

        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();

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
                ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
                ->orderBy('name')
                ->get(),

            /*
             * Sections dropdown
             */
            'sections' => Section::query()
                ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
                ->orderBy('name')
                ->get(),

            /*
             * Active filters
             */
            'filters' => $filters,

            /*
             * Is Admin
             */
            'isAdmin' => $isAdmin,

            /*
             * Table columns
             */
            'columns' => $this->columns($isAdmin),
        ];
    }

    /*
     * Single source of truth for fields displayed
     * in the student table.
     */
    public function columns(bool $isAdmin = false): array
    {
        $columns = [
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
                'key' => 'studentSection.name',
                'label' => 'Section',
            ],
        ];

        if ($isAdmin) {
            array_unshift($columns, [
                'key' => 'school.name',
                'label' => 'School',
            ]);
        }

        return $columns;
    }
}