<?php

use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// ====Auth===============
Auth::routes([
    'register' => false, // Disable registration
    'verify' => false,   // Disable email verification
]);
// ====End of Auth=======


// ========Frontend==============
require __DIR__ . '/public.php';
// =======End of Frontend========


// ===========Backend============
Route::middleware(['auth.admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        require __DIR__ . '/admin.php';
    });
});
// =======end of Backend====


// =====handle wrong url======
Route::redirect('/{any}', '/', 301);
//=======end of handling wrong url===



// storage link
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    dd('storage linked');
});

// clear cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize');
    dd("Application cache cleared!");
});
