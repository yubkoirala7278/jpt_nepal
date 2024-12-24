<?php

use App\Http\Controllers\Admin\ConsultancyController;
use App\Http\Controllers\Admin\ExamDateController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TestCenterController;
use Illuminate\Support\Facades\Route;

Route::get('/home',[HomeController::class,'index'])->name('admin.home');


// ========accessible by admin only==========
Route::middleware(['auth.test_center'])->group(function () {
    Route::resource('test_center', TestCenterController::class);
    Route::resource('exam_date', ExamDateController::class);
});

// =========accessible by test centers and admin only============
Route::middleware(['auth.consultancy'])->group(function () {
    Route::resource('consultancy', ConsultancyController::class);
});

// =======accessible by consultancy and admin only===============
Route::middleware(['auth.student'])->group(function () {
    Route::get('/student/pending-applicants', [StudentController::class, 'getPendingStudents'])->name('student.pending');
    Route::get('/student/approved-applicants', [StudentController::class, 'getApprovedStudents'])->name('student.approved');
    Route::resource('student',StudentController::class);
    Route::put('/student/status/{slug}', [StudentController::class, 'updateStatus'])->name('update.status');
    Route::post('/student/upload-admit-card/{slug}', [StudentController::class, 'uploadAdmitCard'])
    ->name('student.uploadAdmitCard.store');
});


