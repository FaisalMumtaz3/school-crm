<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if (!$user->school_id) {
            abort(403, 'No school assigned to your account. Please contact administrator.');
        }

        return $this->schoolDashboard($user->school_id);
    }

    private function adminDashboard()
    {
        $today = now()->toDateString();

        $totalSchools = School::count();
        $activeSchools = School::where('status', 'active')->count();
        $totalStudents = Student::count();
        $totalTeachers = \App\Models\Teacher::count();

        $absentStudentList = Student::with([
            'schoolClass',
            'studentSection',
            'school',
        ])
            ->whereHas('attendances', function ($attendanceQuery) use ($today) {
                $attendanceQuery
                    ->whereDate('date', $today)
                    ->where('status', 'absent');
            })
            ->orderBy('roll_number')
            ->orderBy('name')
            ->limit(10)
            ->get();

        $presentStudents = Attendance::whereDate('date', $today)
            ->where('status', 'present')
            ->count();

        $unpaidStudentList = Fee::with([
            'student.schoolClass',
            'student.studentSection',
            'student.school',
        ])
            ->where('status', 'unpaid')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->unique('student_id')
            ->values();

        $partialStudentList = Fee::with([
            'student.schoolClass',
            'student.studentSection',
            'student.school',
        ])
            ->where('status', 'partial')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->unique('student_id')
            ->values();

        $absentStudents = $absentStudentList->count();
        $unpaidFees = $unpaidStudentList->count();
        $partialFees = $partialStudentList->count();
        $pendingFees = $unpaidFees + $partialFees;
        $studentsClasses = SchoolClass::count();

        return view('dashboard', compact(
            'totalSchools',
            'activeSchools',
            'totalStudents',
            'totalTeachers',
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

    private function schoolDashboard(int $schoolId)
    {
        $today = now()->toDateString();

        $totalStudents = Student::where('school_id', $schoolId)->count();
        $totalTeachers = \App\Models\Teacher::where('school_id', $schoolId)->count();
        $totalClasses = SchoolClass::where('school_id', $schoolId)->count();

        $absentStudentList = Student::with([
            'schoolClass',
            'studentSection',
        ])
            ->where('school_id', $schoolId)
            ->whereHas('attendances', function ($attendanceQuery) use ($today) {
                $attendanceQuery
                    ->whereDate('date', $today)
                    ->where('status', 'absent');
            })
            ->orderBy('roll_number')
            ->orderBy('name')
            ->limit(10)
            ->get();

        $presentStudents = Attendance::where('school_id', $schoolId)
            ->whereDate('date', $today)
            ->where('status', 'present')
            ->count();

        $unpaidStudentList = Fee::with([
            'student.schoolClass',
            'student.studentSection',
        ])
            ->where('school_id', $schoolId)
            ->where('status', 'unpaid')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->unique('student_id')
            ->values();

        $partialStudentList = Fee::with([
            'student.schoolClass',
            'student.studentSection',
        ])
            ->where('school_id', $schoolId)
            ->where('status', 'partial')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->unique('student_id')
            ->values();

        $absentStudents = $absentStudentList->count();
        $unpaidFees = $unpaidStudentList->count();
        $partialFees = $partialStudentList->count();
        $pendingFees = $unpaidFees + $partialFees;
        $studentsClasses = $totalClasses;

        return view('dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'studentsClasses',
            'presentStudents',
            'absentStudents',
            'unpaidFees',
            'partialFees',
            'pendingFees',
            'absentStudentList',
            'unpaidStudentList',
            'partialStudentList',
        ));
    }
}