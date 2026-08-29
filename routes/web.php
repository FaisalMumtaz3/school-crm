<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/students/export', [ExportController::class, 'students'])->name('students.export');
    Route::get('/teachers/export', [ExportController::class, 'teachers'])->name('teachers.export');

    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    // Route::resource('attendance', StudentController::class);
    // Route::resource('fees', StudentController::class);
    Route::resource('classes', ClassController::class)->parameters([
        'classes' => 'schoolClass']);
    Route::resource('sections', SectionController::class);
});

require __DIR__.'/auth.php';

