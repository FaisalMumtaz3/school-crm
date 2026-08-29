<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
    protected Collection $teachers;

    public function __construct(Collection $teachers)
    {
        $this->teachers = $teachers;
    }

    /*
    |--------------------------------------------------------------------------
    | Records
    |--------------------------------------------------------------------------
    */

    public function collection()
    {
        return $this->teachers;
    }

    /*
    |--------------------------------------------------------------------------
    | Excel Headings
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'ID',
            'Teacher Name',
            'Father Name',
            'Phone',
            'Qualification',
            'Subject',
            'Salary',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Excel Row
    |--------------------------------------------------------------------------
    */

    public function map($teacher): array
    {
        return [
            $teacher->id,
            $teacher->name,
            $teacher->father_name,
            $teacher->phone,
            $teacher->qualification,
            $teacher->subject,
            $teacher->salary,
        ];
    }
}