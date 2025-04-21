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

    // Start Slider  Routes
    Route::controller(SliderController::class)->prefix('slider')->group(function() {
        Route::get('/',                 'index')->name('slider.index')->middleware('PermissionCheck:slider_read');
        Route::get('/create',           'create')->name('slider.create')->middleware('PermissionCheck:slider_create');
        Route::post('/store',           'store')->name('slider.store')->middleware('PermissionCheck:slider_store');
        Route::get('/edit/{id}',        'edit')->name('slider.edit')->middleware('PermissionCheck:slider_update');
        Route::put('/update/{id}',      'update')->name('slider.update')->middleware('PermissionCheck:slider_update');
        Route::get('/delete/{id}',      'destroy')->name('slider.destroy')->middleware('PermissionCheck:slider_delete');
    });
    // End Slider Routes

});
