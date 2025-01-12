<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdmitCardController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ConsultancyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ExamDateController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TestCenterController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\StaticPage\AboutController;
use App\Http\Controllers\StaticPage\FooterController;
use App\Http\Controllers\StaticPage\HeaderController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
Route::get('/chart', [HomeController::class, 'showApplicantCountPerMonthChart'])->name('chart.show');
Route::post('/change-student-status', [StudentController::class, 'changeStatus'])->name('student.changeStatus');

// =======check if the status of consultancy or test center is active or disabled======
Route::middleware(['auth', 'check.consultancy.test_center'])->group(function () {

    Route::resource('notice', NoticeController::class);
    // ==========role admin can access the below routes===========
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('test_center', TestCenterController::class);
        Route::post('/test-center/consultancies', [TestCenterController::class, 'fetchConsultancies'])->name('test_center.consultancies');
        Route::post('/disable-test-center', [TestCenterController::class, 'disableTestCenter'])->name('disable.test_center');
        Route::post('/enable-test-center', [TestCenterController::class, 'enableTestCenter'])->name('enable.test_center');
        Route::resource('exam_date', ExamDateController::class);
        Route::resource('testimonial', TestimonialController::class);
        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
        Route::post('/applicants/export', [StudentController::class, 'exportApplicants'])->name('applicants.export');
        Route::post('/applicant-result/import', [ResultController::class, 'import'])->name('results.import');
        Route::post('/applicant-exam-code/import', [StudentController::class, 'import'])->name('exam-code.import');
        Route::resource('blog', BlogController::class);
        Route::get('/contact', [ContactController::class, 'index'])->name('admin.contact');
        Route::delete('/contact/{slug}', [ContactController::class, 'destroy'])->name('contact.destroy');
        Route::get('/contact/{id}', [ContactController::class, 'show'])->name('contact.show');

        // static Pages
        Route::resource('header', HeaderController::class);
        Route::resource('about', AboutController::class);
        Route::resource('footer', FooterController::class);
        Route::resource('faq', FaqController::class);
        Route::resource('account', AccountController::class);
    });

    // =========accessible by test centers and admin only============
    Route::group(['middleware' => ['role:admin|test_center_manager']], function () {
        Route::resource('consultancy', ConsultancyController::class);
        Route::get('/pending-consultancy', [ConsultancyController::class, 'getPendingConsultancy'])->name('pending.consultancy');
        Route::post('/disable-consultancy', [ConsultancyController::class, 'disableConsultancy'])->name('disable.consultancy');
        Route::post('/enable-consultancy', [ConsultancyController::class, 'enableConsultancy'])->name('enable.consultancy');
    });

    // =======accessible by consultancy, admin and test_center_manager===============
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

    // ===========accessible by consultancy manager only===============
    Route::group(['middleware' => ['role:consultancy_manager|test_center_manager']], function () {
        Route::get('/upload-receipt', [StudentController::class, 'uploadReceipt'])->name('upload.receipt');
        Route::post('/upload-receipt', [StudentController::class, 'storeReceiptInfo'])->name('store.receipt');
    });
});
