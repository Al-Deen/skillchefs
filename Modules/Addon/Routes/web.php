<?php

use Illuminate\Support\Facades\Route;
use Modules\Addon\Http\Controllers\AddonController;

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
    Route::controller(AddonController::class)->prefix('addon')->group(function () {
        Route::get('/list', 'index')->name('admin.addon.index')->middleware('PermissionCheck:addon_list');
        Route::get('/create', 'create')->name('admin.addon.create')->middleware('PermissionCheck:addon_create');
        Route::post('/store', 'store')->name('admin.addon.store')->middleware('PermissionCheck:addon_store');
        Route::get('/edit/{id}', 'edit')->name('admin.addon.edit')->middleware('PermissionCheck:addon_update');
        Route::post('/update/{id}', 'update')->name('admin.addon.update')->middleware('PermissionCheck:addon_update');
        Route::get('/status/{id}', 'status')->name('admin.addon.status')->middleware('PermissionCheck:addon_update');
    });
});
