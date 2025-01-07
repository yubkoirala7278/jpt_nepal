<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AdmitCardController;
use App\Http\Controllers\Frontend\AgentController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NoticeController;
use App\Http\Controllers\Frontend\RegistrationController;
use App\Http\Controllers\Frontend\ResourcesController;
use App\Http\Controllers\Frontend\TestDetailController;
use App\Http\Controllers\Frontend\TestLevelController;
use Illuminate\Support\Facades\Route;


Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/blog',[BlogController::class,'index'])->name('blog');
Route::get('/blog-detail/{slug}',[BlogController::class,'blogDetails'])->name('blog-detail');
Route::get('/admit-card',[AdmitCardController::class,'index'])->name('admit-card');
Route::post('/my-admit-card',[AdmitCardController::class,'getAdmitCard'])->name('my-admit-card');
Route::get('/applicant-result',[AdmitCardController::class,'getApplicantResult'])->name('applicant-result');
Route::post('/my-result',[AdmitCardController::class,'getResult'])->name('my-result');
Route::get('/about',[AboutController::class,'index'])->name('about');
Route::get('/contact',[ContactController::class,'index'])->name('contact');
Route::post('/contact',[ContactController::class,'store'])->name('contact.store');
Route::get('/test-center',[TestDetailController::class,'index'])->name('test.detail');
Route::get('/registration',[TestDetailController::class,'registration'])->name('registration');
Route::get('/resources',[ResourcesController::class,'index'])->name('resources');
Route::get('/notice',[NoticeController::class,'index'])->name('notice');
Route::get('/notice-detail/{slug}',[NoticeController::class,'getNoticeDetail'])->name('notice.detail');
Route::post('/test-center-detail',[HomeController::class,'getTestCenterDetails'])->name('test-center-details');
Route::get('/registration',[RegistrationController::class,'index'])->name('student.register');
Route::post('/student/validate', [RegistrationController::class, 'validateForm'])->name('public.student.validate');
Route::post('/registration',[RegistrationController::class,'store'])->name('public.student.store');
Route::get('/agent-registration',[AgentController::class,'index'])->name('agent.register');
Route::post('/agent-registration',[AgentController::class,'store'])->name('agent.store');
Route::get('/test-levels',[TestLevelController::class,'index'])->name('test-levels');