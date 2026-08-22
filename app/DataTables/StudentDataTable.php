<?php

namespace App\DataTables;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentDataTable
{
    public function __construct(private readonly Request $request)
    {
    }

    public function viewData(): array
    {
        $filters = $this->request->validate([
            'search' => 'nullable|string|max:100',
            'class' => 'nullable|string|max:50',
            'section' => 'nullable|string|max:10',
        ]);

        $studentsQuery = Student::query();

        $studentsQuery->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($studentQuery) use ($search) {
                $studentQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('roll_number', 'like', "%{$search}%");
            });
        });

        $studentsQuery->when($filters['class'] ?? null, fn ($query, $class) => $query->where('class', $class));
        $studentsQuery->when($filters['section'] ?? null, fn ($query, $section) => $query->where('section', $section));

        return [
            'students' => $studentsQuery->latest()->paginate(10)->withQueryString(),
            'classes' => Student::query()->whereNotNull('class')->distinct()->orderBy('class')->pluck('class'),
            'sections' => Student::query()->whereNotNull('section')->distinct()->orderBy('section')->pluck('section'),
            'filters' => $filters,
            'columns' => $this->columns(),
        ];
    }

    // This is the single source of truth for fields displayed in the student table.
    public function columns(): array
    {
        return [
            ['key' => 'name', 'label' => 'Student'],
            ['key' => 'father_name', 'label' => 'Father name'],
            // ['key' => 'phone', 'label' => 'Phone'],
            ['key' => 'class', 'label' => 'Class'],
            ['key' => 'section', 'label' => 'Section'],
            // ['key' => 'roll_number', 'label' => 'Roll number'],
            // ['key' => 'admission_date', 'label' => 'Admission date'],
        ];
    }
}
