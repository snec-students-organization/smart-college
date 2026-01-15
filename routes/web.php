<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Shared Lookup Routes
Route::middleware('auth')->group(function () {
    Route::get('lookup/classes/{class}/sections', [\App\Http\Controllers\Admin\ClassController::class, 'getSections'])->name('lookup.sections');
    Route::get('lookup/classes/{class}/subjects', [\App\Http\Controllers\Admin\ClassController::class, 'getSubjects'])->name('lookup.subjects');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Academic Management
    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);
    Route::get('classes', [\App\Http\Controllers\Admin\ClassController::class, 'index'])->name('classes.index');
    Route::post('classes', [\App\Http\Controllers\Admin\ClassController::class, 'store'])->name('classes.store');
    Route::delete('classes/{class}', [\App\Http\Controllers\Admin\ClassController::class, 'destroy'])->name('classes.destroy');
    Route::post('classes/{class}/sections', [\App\Http\Controllers\Admin\ClassController::class, 'storeSection'])->name('classes.sections.store');
    Route::delete('sections/{section}', [\App\Http\Controllers\Admin\ClassController::class, 'destroySection'])->name('classes.sections.destroy');

    Route::post('classes/{class}/sections', [\App\Http\Controllers\Admin\ClassController::class, 'storeSection'])->name('classes.sections.store');
    Route::delete('sections/{section}', [\App\Http\Controllers\Admin\ClassController::class, 'destroySection'])->name('classes.sections.destroy');


    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class)->only(['index', 'store', 'destroy']);

    // Library Management
    Route::get('library/books', [\App\Http\Controllers\Admin\LibraryController::class, 'index'])->name('library.index');
    Route::post('library/books', [\App\Http\Controllers\Admin\LibraryController::class, 'store'])->name('library.store');
    Route::delete('library/books/{book}', [\App\Http\Controllers\Admin\LibraryController::class, 'destroy'])->name('library.destroy');
    
    Route::get('library/circulation', [\App\Http\Controllers\Admin\LibraryController::class, 'circulationIndex'])->name('library.circulation');
    Route::get('library/issue', [\App\Http\Controllers\Admin\LibraryController::class, 'issueBookCreate'])->name('library.issue.create');
    Route::post('library/issue', [\App\Http\Controllers\Admin\LibraryController::class, 'issueBookStore'])->name('library.issue.store');
    Route::post('library/return/{issue}', [\App\Http\Controllers\Admin\LibraryController::class, 'returnBook'])->name('library.return');

    // Fee Management
    Route::get('fees', [\App\Http\Controllers\Admin\FeeController::class, 'index'])->name('fees.index');
    Route::post('fees', [\App\Http\Controllers\Admin\FeeController::class, 'store'])->name('fees.store');
    Route::delete('fees/{fee}', [\App\Http\Controllers\Admin\FeeController::class, 'destroy'])->name('fees.destroy');

    Route::get('fees/collect', [\App\Http\Controllers\Admin\FeeController::class, 'collectionIndex'])->name('fees.collect.index');
    Route::get('fees/student-fees', [\App\Http\Controllers\Admin\FeeController::class, 'collectShow'])->name('fees.collect.show');
    Route::post('fees/payment', [\App\Http\Controllers\Admin\FeeController::class, 'storePayment'])->name('fees.payment.store');

    // Timetable Management
    Route::resource('timetable', \App\Http\Controllers\Admin\TimetableController::class);
    Route::post('timetable/assign-teacher', [\App\Http\Controllers\Admin\TimetableController::class, 'assignClassTeacher'])->name('timetable.assign-teacher');
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\TeacherController::class, 'dashboard'])->name('dashboard');
    
    // Attendance
    Route::get('/attendance', [\App\Http\Controllers\TeacherController::class, 'attendanceIndex'])->name('attendance.index');
    Route::get('/attendance/create', [\App\Http\Controllers\TeacherController::class, 'attendanceCreate'])->name('attendance.create');
    Route::post('/attendance', [\App\Http\Controllers\TeacherController::class, 'attendanceStore'])->name('attendance.store');

    // Marks
    Route::get('/marks', [\App\Http\Controllers\TeacherController::class, 'marksIndex'])->name('marks.index');
    Route::get('/marks/list', [\App\Http\Controllers\TeacherController::class, 'marksList'])->name('marks.list');
    Route::get('/marks/create', [\App\Http\Controllers\TeacherController::class, 'marksCreate'])->name('marks.create');
    Route::post('/marks', [\App\Http\Controllers\TeacherController::class, 'marksStore'])->name('marks.store');

    // Profile Setup
    Route::get('/profile-setup', [\App\Http\Controllers\TeacherController::class, 'profile'])->name('profile.setup');
    Route::post('/profile-setup', [\App\Http\Controllers\TeacherController::class, 'updateProfile'])->name('profile.update');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [\App\Http\Controllers\StudentController::class, 'attendance'])->name('attendance');
    Route::get('/marks', [\App\Http\Controllers\StudentController::class, 'marks'])->name('marks');
    Route::get('/fees', [\App\Http\Controllers\StudentController::class, 'fees'])->name('fees');
});

// Parent Routes
Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\ParentController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
