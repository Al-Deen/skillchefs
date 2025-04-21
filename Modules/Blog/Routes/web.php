<?php
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


Route::prefix('admin')->middleware(['auth.routes'])->group(function() {

    // Start blog Category Routes
    Route::controller(BlogCategoryController::class)->prefix('blog-category')->group(function() {
        Route::get('/',                 'index')->name('blog-category.index')->middleware('PermissionCheck:blog_category_read');
        Route::get('/create',           'create')->name('blog-category.create')->middleware('PermissionCheck:blog_category_create');
        Route::post('/store',           'store')->name('blog-category.store')->middleware('PermissionCheck:blog_category_store');
        Route::get('/edit/{id}',        'edit')->name('blog-category.edit')->middleware('PermissionCheck:blog_category_update');
        Route::put('/update/{id}',      'update')->name('blog-category.update')->middleware('PermissionCheck:blog_category_update');
        Route::get('/delete/{id}',      'destroy')->name('blog-category.destroy')->middleware('PermissionCheck:blog_category_delete');
    });
    // End blog Category Routes

    // Start blog  Routes
    Route::controller(BlogController::class)->prefix('blog')->group(function() {
        Route::get('/',                 'index')->name('blog.index')->middleware('PermissionCheck:blog_read');
        Route::get('/create',           'create')->name('blog.create')->middleware('PermissionCheck:blog_create');
        Route::post('/store',           'store')->name('blog.store')->middleware('PermissionCheck:blog_store');
        Route::get('/edit/{id}',        'edit')->name('blog.edit')->middleware('PermissionCheck:blog_update');
        Route::put('/update/{id}',      'update')->name('blog.update')->middleware('PermissionCheck:blog_update');
        Route::get('/delete/{id}',      'destroy')->name('blog.destroy')->middleware('PermissionCheck:blog_delete');
    });
    // End blog Routes

});
