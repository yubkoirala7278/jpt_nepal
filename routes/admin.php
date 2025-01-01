<?php

use App\Http\Controllers\Admin\AdmitCardController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ConsultancyController;
use App\Http\Controllers\Admin\ExamDateController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TestCenterController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
Route::resource('notice', NoticeController::class);

// ==========role admin can access the below routes===========
Route::middleware(['role:admin'])->group(function () {
    Route::resource('test_center', TestCenterController::class);
    Route::resource('exam_date', ExamDateController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::post('/applicants/export', [StudentController::class, 'exportApplicants'])->name('applicants.export');
    Route::post('/applicant-result/import', [ResultController::class, 'import'])->name('results.import');
});

// =========accessible by test centers and admin only============
Route::group(['middleware' => ['role:admin|test_center_manager']], function () {
    Route::resource('consultancy', ConsultancyController::class);
});

// =======accessible by consultancy and admin only===============
Route::group(['middleware' => ['role:admin|consultancy_manager|test_center_manager']], function () {
    Route::get('/student/pending-applicants', [StudentController::class, 'getPendingStudents'])->name('student.pending');
    Route::get('/student/approved-applicants', [StudentController::class, 'getApprovedStudents'])->name('student.approved');
    Route::resource('student', StudentController::class);
    Route::put('/student/status/{slug}', [StudentController::class, 'updateStatus'])->name('update.status');
    Route::post('/student/upload-admit-card/{slug}', [StudentController::class, 'uploadAdmitCard'])
        ->name('student.uploadAdmitCard.store');
    Route::get('/admit-card', [AdmitCardController::class, 'index'])->name('admin.admit-card');
    Route::get('/applicant-result', [ResultController::class, 'index'])->name('admin.applicant-result');
    Route::post('/applicant-result-export', [ResultController::class, 'export'])->name('admin.applicant-result-export');
});
