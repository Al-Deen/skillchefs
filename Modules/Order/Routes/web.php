<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\EnrollController;

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

    Route::controller(EnrollController::class)->prefix('enroll')->group(function () {
        Route::get('/', 'index')->name('admin.enroll.index')->middleware('PermissionCheck:enroll_list');
        Route::get('/payment_detail/{order_item_id}', 'adminPaymentDetail')->name('admin.payment_detail.view')->middleware('PermissionCheck:enroll_invoice');
        Route::get('/view/{id}', 'adminInvoice')->name('admin.invoice.view')->middleware('PermissionCheck:enroll_invoice');
    });

});
