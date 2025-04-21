<?php

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



Route::prefix('admin')->middleware(['auth.routes'])->group(function() {

    // Start brand  Routes
    Route::controller(BrandController::class)->prefix('brand')->group(function() {
        Route::get('/',                 'index')->name('brand.index')->middleware('PermissionCheck:brand_read');
        Route::get('/create',           'create')->name('brand.create')->middleware('PermissionCheck:brand_create');
        Route::post('/store',           'store')->name('brand.store')->middleware('PermissionCheck:brand_store');
        Route::get('/edit/{id}',        'edit')->name('brand.edit')->middleware('PermissionCheck:brand_update');
        Route::put('/update/{id}',      'update')->name('brand.update')->middleware('PermissionCheck:brand_update');
        Route::get('/delete/{id}',      'destroy')->name('brand.destroy')->middleware('PermissionCheck:brand_delete');
    });
    // End brand Routes

});
