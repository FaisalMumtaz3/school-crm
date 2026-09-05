<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FeeController;
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

    Route::get('/classes/{schoolClass}/sections',[ClassController::class, 'sections'])
        ->name('classes.sections');

    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    // Route::resource('attendance', StudentController::class);
    // Route::resource('fees', StudentController::class);
    Route::resource('classes', ClassController::class)->parameters([
        'classes' => 'schoolClass']);
    Route::resource('sections', SectionController::class);

    Route::prefix('fees')
    ->name('fees.')
    ->group(function () {

        Route::get('/', [
            FeeController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            FeeController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            FeeController::class,
            'store'
        ])->name('store');
    });

    Route::get('/reports/fees', [
        FeeController::class,
        'report'
    ])->name('reports.fees');

    Route::prefix('attendances')
    ->name('attendances.')
    ->group(function () {

        Route::get('/', [
            AttendanceController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            AttendanceController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            AttendanceController::class,
            'store'
        ])->name('store');

        Route::get('/show', [
            AttendanceController::class,
            'show'
        ])->name('show');
    });
    
});

require __DIR__.'/auth.php';

