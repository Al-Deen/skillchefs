<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentMethodController;

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

Route::prefix('admin')->middleware(['auth.routes'])->group(function () {

    // Start payment method  Routes
    Route::controller(PaymentMethodController::class)->prefix('payment-method')->group(function () {
        Route::get('/', 'index')->name('payment_method.index')->middleware('PermissionCheck:payment_method_read');
        Route::get('/edit/{id}', 'edit')->name('payment_method.edit')->middleware('PermissionCheck:payment_method_update');
        Route::post('/update/{id}', 'update')->name('payment_method.update')->middleware('PermissionCheck:payment_method_update');
        Route::get('/delete/{id}', 'destroy')->name('payment_method.destroy')->middleware('PermissionCheck:payment_method_delete');
    });
    // End payment method Routes

});
