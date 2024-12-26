<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AdmitCardController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/blog',[BlogController::class,'index'])->name('blog');
Route::get('/blog-detail/{slug}',[BlogController::class,'blogDetails'])->name('blog-detail');
Route::get('/admit-card',[AdmitCardController::class,'index'])->name('admit-card');
Route::get('/applicant-result',[AdmitCardController::class,'getApplicantResult'])->name('applicant-result');
Route::get('/about',[AboutController::class,'index'])->name('about');
Route::get('/contact',[ContactController::class,'index'])->name('contact');