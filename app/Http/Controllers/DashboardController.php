<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $totalStudents = Student::count();
        $absentStudentList = Student::with([
            'schoolClass',
            'studentSection',
        ])
            ->whereHas('attendances', function ($attendanceQuery) use ($today) {
                $attendanceQuery
                    ->whereDate('date', $today)
                    ->where('status', 'absent');
            })
            ->orderBy('roll_number')
            ->orderBy('name')
            ->get()
            ->values();

        $presentStudents = Attendance::whereDate('date', $today)
            ->where('status', 'present')
            ->count();

        $unpaidStudentList = Fee::with([
            'student.schoolClass',
            'student.studentSection',
        ])
            ->where('status', 'unpaid')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->get()
            ->unique('student_id')
            ->values();

        $partialStudentList = Fee::with([
            'student.schoolClass',
            'student.studentSection',
        ])
            ->where('status', 'partial')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->get()
            ->unique('student_id')
            ->values();

        $absentStudents = $absentStudentList->count();
        $unpaidFees = $unpaidStudentList->count();
        $partialFees = $partialStudentList->count();
        $pendingFees = $unpaidFees + $partialFees;
        $studentsClasses = SchoolClass::count();

        return view('dashboard', compact(
            'totalStudents',
            'presentStudents',
            'absentStudents',
            'unpaidFees',
            'partialFees',
            'pendingFees',
            'absentStudentList',
            'unpaidStudentList',
            'partialStudentList',
            'studentsClasses'
        ));
    }
}
