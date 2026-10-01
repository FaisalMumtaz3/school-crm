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
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('schools', SchoolController::class);
    Route::get('schools/{school}/permissions', [SchoolController::class, 'permissions'])->name('schools.permissions');
    Route::put('schools/{school}/permissions', [SchoolController::class, 'updatePermissions'])->name('schools.permissions.update');

    Route::resource('users', UserController::class);
});

// School routes (school_admin and staff)
Route::middleware(['auth', 'verified', 'school'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/students/export', [ExportController::class, 'students'])->name('students.export');
    Route::get('/teachers/export', [ExportController::class, 'teachers'])->name('teachers.export');

    // Students: index/show -> view, create/store -> create, edit/update -> edit, destroy -> delete
    Route::get('/students', [StudentController::class, 'index'])->name('students.index')->middleware('permission:students,view');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create')->middleware('permission:students,create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store')->middleware('permission:students,create');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show')->middleware('permission:students,view');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('permission:students,edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update')->middleware('permission:students,edit');
    Route::patch('/students/{student}', [StudentController::class, 'update'])->name('students.update')->middleware('permission:students,edit');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('permission:students,delete');

    // Teachers
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index')->middleware('permission:teachers,view');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create')->middleware('permission:teachers,create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store')->middleware('permission:teachers,create');
    Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show')->middleware('permission:teachers,view');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit')->middleware('permission:teachers,edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update')->middleware('permission:teachers,edit');
    Route::patch('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update')->middleware('permission:teachers,edit');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy')->middleware('permission:teachers,delete');

    // Classes
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index')->middleware('permission:classes,view');
    Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create')->middleware('permission:classes,create');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store')->middleware('permission:classes,create');
    Route::get('/classes/{schoolClass}', [ClassController::class, 'show'])->name('classes.show')->middleware('permission:classes,view');
    Route::get('/classes/{schoolClass}/edit', [ClassController::class, 'edit'])->name('classes.edit')->middleware('permission:classes,edit');
    Route::put('/classes/{schoolClass}', [ClassController::class, 'update'])->name('classes.update')->middleware('permission:classes,edit');
    Route::patch('/classes/{schoolClass}', [ClassController::class, 'update'])->name('classes.update')->middleware('permission:classes,edit');
    Route::delete('/classes/{schoolClass}', [ClassController::class, 'destroy'])->name('classes.destroy')->middleware('permission:classes,delete');

    // Sections
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index')->middleware('permission:sections,view');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create')->middleware('permission:sections,create');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store')->middleware('permission:sections,create');
    Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show')->middleware('permission:sections,view');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit')->middleware('permission:sections,edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update')->middleware('permission:sections,edit');
    Route::patch('/sections/{section}', [SectionController::class, 'update'])->name('sections.update')->middleware('permission:sections,edit');
    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy')->middleware('permission:sections,delete');

    // Fees
    Route::prefix('fees')
        ->name('fees.')
        ->group(function () {
            Route::get('/', [FeeController::class, 'index'])->name('index')->middleware('permission:fees,view');
            Route::get('/create', [FeeController::class, 'create'])->name('create')->middleware('permission:fees,create');
            Route::post('/', [FeeController::class, 'store'])->name('store')->middleware('permission:fees,create');
        });

    Route::get('/reports/fees', [FeeController::class, 'report'])->name('reports.fees')->middleware('permission:reports,view');

    // Attendances
    Route::prefix('attendances')
        ->name('attendances.')
        ->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index')->middleware('permission:attendance,view');
            Route::get('/create', [AttendanceController::class, 'create'])->name('create')->middleware('permission:attendance,create');
            Route::post('/', [AttendanceController::class, 'store'])->name('store')->middleware('permission:attendance,create');
            Route::get('/show', [AttendanceController::class, 'show'])->name('show')->middleware('permission:attendance,view');
        });
});

require __DIR__.'/auth.php';