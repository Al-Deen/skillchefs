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

    // Start pages  Routes
    Route::controller(PageController::class)->prefix('pages')->group(function() {
        Route::get('/',                 'index')->name('pages.index')->middleware('PermissionCheck:page_read');
        Route::get('/create',           'create')->name('pages.create')->middleware('PermissionCheck:page_create');
        Route::post('/store',           'store')->name('pages.store')->middleware('PermissionCheck:page_store');
        Route::get('/edit/{id}',        'edit')->name('pages.edit')->middleware('PermissionCheck:page_update');
        Route::put('/update/{id}',      'update')->name('pages.update')->middleware('PermissionCheck:page_update');
        Route::get('/delete/{id}',      'destroy')->name('pages.destroy')->middleware('PermissionCheck:page_delete');
    });
    // End pages Routes

});
