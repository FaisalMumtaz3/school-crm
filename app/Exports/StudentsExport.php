<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected Collection $students;

    public function __construct(Collection $students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Student Name',
            'Father Name',
            'Roll Number',
            'Class',
            'Section',
            'Phone',
            'Admission Date',
        ];
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->name,
            $student->father_name,
            $student->roll_number,
            $student->class,
            $student->section,
            $student->phone,
            $student->admission_date
                ? Carbon::parse($student->admission_date)->format('d M Y')
                : '',
        ];
    }
}