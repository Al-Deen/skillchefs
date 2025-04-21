<?php

use App\Http\Controllers\Backend\AuthenticationController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Select data by ajax

Route::get('/become-student', [FrontendController::class, 'becomeStudent'])->name('becomeStudent');
Route::get('/course-details', [FrontendController::class, 'courseDetails'])->name('courseDetails');
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacyPolicy');

Route::group(['middleware' => 'lang'], function () : void {

    // Non-auth routes 
    Route::group(['middleware' => ['not.auth.routes']], function () {
        // controller namespace
        Route::controller(AuthenticationController::class)->prefix('admin')->group(function () {
            Route::get('login', 'loginPage')->name('login');
            Route::post('login', 'login')->name('login.auth');
            Route::get('register', 'registerPage')->name('register');
            Route::post('register', 'register')->name('register');
            Route::get('verify-email/{email}/{token}', 'verifyEmail')->name('verify-email');

            // reset password
            Route::get('forgot-password', 'forgotPasswordPage')->name('forgot-password');
            Route::post('forgot-password', 'forgotPassword')->name('forgot.password');

            Route::get('reset-password/{email}/{token}', 'resetPasswordPage')->name('reset-password');
            Route::post('reset-password', 'resetPassword')->name('reset.password');
        });
    });

    Route::get('cache-clear', function () {
        Artisan::call('optimize:clear');
        return 'Cache cleared';
    });

    Route::get('link-storage', function () {
        Artisan::call('storage:link');
        return 'Storage linked';
    });

    include_route_files(__DIR__ . '/admin/');
    include_route_files(__DIR__ . '/frontend/');
});


Route::get('test', function () {
  try {
    Artisan::call('module:migrate', [
        'module' => 'Subscription',
        '--force' => true,
    ]);
    Artisan::call('module:seed', [
        'module' => 'Subscription',
    ]);
    Artisan::call('module:publish', [
        'module' => 'Subscription',
    ]);
  } catch (\Throwable $th) {
    dd($th);
  }
});