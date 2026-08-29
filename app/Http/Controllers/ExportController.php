<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\StudentsExport;
use App\Exports\TeachersExport;

class ExportController extends Controller
{
    public function students(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Student Export Query
        |--------------------------------------------------------------------------
        */

        $query = Student::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('roll_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Class
        |--------------------------------------------------------------------------
        */

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        /*
        |--------------------------------------------------------------------------
        | Section
        |--------------------------------------------------------------------------
        */

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        /*
        |--------------------------------------------------------------------------
        | Custom Export Columns
        |--------------------------------------------------------------------------
        */

        $students = $query
            ->select([
                'id',
                'name',
                'father_name',
                'roll_number',
                'class',
                'section',
                'phone',
                'admission_date',
            ])
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Download
        |--------------------------------------------------------------------------
        */

        return Excel::download(
            new StudentsExport($students),
            'students-' . now()->format('Y-m-d-H-i-s') . '.xlsx'
        );
    }

    public function teachers(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Teacher Export Query
        |--------------------------------------------------------------------------
        */

        $query = Teacher::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('qualification', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Subject Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        /*
        |--------------------------------------------------------------------------
        | Qualification Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('qualification')) {
            $query->where('qualification', $request->qualification);
        }

        /*
        |--------------------------------------------------------------------------
        | Custom Export Columns
        |--------------------------------------------------------------------------
        */

        $teachers = $query
            ->select([
                'id',
                'name',
                'father_name',
                'phone',
                'qualification',
                'subject',
                'salary',
            ])
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Download Excel
        |--------------------------------------------------------------------------
        */

        return Excel::download(
            new TeachersExport($teachers),
            'teachers-' . now()->format('Y-m-d-H-i-s') . '.xlsx'
        );
    }
}