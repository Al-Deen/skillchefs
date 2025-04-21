<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\CourseDetailsController;
use Modules\Api\Http\Controllers\PaymentController;

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

Route::middleware(['auth:sanctum'])->prefix('api/v1')->group(function () {
    Route::get('/', 'ApiController@index');
    // Route::get('/student/course/{slug}', [CourseDetailsController::class, 'courseLearn']);
});
Route::prefix('api/v1')->group(function () {
    Route::get('/student/course/{course_id}/{user_id}/learn/lecture', [CourseDetailsController::class, 'course']);
    Route::get('/student/course/{course_id}/{user_id}/learn/lecture/{lesson_id}', [CourseDetailsController::class, 'courseLearn']);
});

Route::prefix('api/v1')->group(function () {
    Route::get('/checkout/{course_id}/{user_id}', [PaymentController::class, 'checkout'])->name('api.checkout');
    Route::get('/checkout/payment/{user_id}/{course_id}/{payment_name}', [PaymentController::class, 'payment'])->name('api.checkout.payment');
    Route::get('/payment-list', [PaymentController::class, 'paymentList']);

    Route::get('payment/done', [PaymentController::class, 'done'])->name('webview_payment.done');
    Route::get('payment/fail', [PaymentController::class, 'fail'])->name('webview_payment.fail');
    Route::get('payment/cancel', [PaymentController::class, 'cancel'])->name('webview_payment.cancel');
});

Route::controller(PaymentController::class)->prefix('api/payments')->group(function () {
    Route::get('verify/{method}', 'verify')->name('api.payment.verify');
    Route::post('verify/{method}', 'verify')->name('api.payment.verifyPost');
    Route::get('status', 'status')->name('api.payment.status');
});
