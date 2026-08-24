<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

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
}