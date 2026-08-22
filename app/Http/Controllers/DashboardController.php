<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //$totalUsers = User::count();
        //$latestUsers = User::latest()->take(5)->get();
        $totalStudents = 300;
        $presentStudents = 280;
        $pendingStudentsfees = 30;
        $studentsClasses = 12;
        return view('dashboard', compact('totalStudents','presentStudents','pendingStudentsfees','studentsClasses'));
    }
}
