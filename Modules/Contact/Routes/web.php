<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\ContactController;

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

    // Start Course Category Routes
    Route::controller(ContactController::class)->group(function () {
        Route::prefix('contacts')->group(function () {
            Route::get('/', 'index')->name('admin.contacts.index')->middleware('PermissionCheck:contact_read');
            Route::get('/details/{id}', 'show')->name('admin.contacts.details')->middleware('PermissionCheck:contact_read');
        });
    });
    // End Course Category Routes
});
