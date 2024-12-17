<?php

use App\Http\Controllers\Admin\ConsultancyController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TestCenterController;
use Illuminate\Support\Facades\Route;

Route::get('/home',[HomeController::class,'index'])->name('admin.home');


Route::middleware(['auth.consultancy'])->group(function () {
    Route::resource('consultancy', ConsultancyController::class);
});

Route::middleware(['auth.test_center'])->group(function () {
    Route::resource('test_center', TestCenterController::class);
});

