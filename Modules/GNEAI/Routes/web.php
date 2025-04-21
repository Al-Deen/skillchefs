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

Route::prefix('admin')->middleware(['auth.routes'])->group(function () {
    Route::controller(GNEAIController::class)->group(function () {
        Route::get('ai-support', 'index')->name('admin.ai-support.index')->middleware(['PermissionCheck:ai_support']);
        Route::post('ai-support/search', 'search')->name('admin.ai-support.search')->middleware(['PermissionCheck:ai_support_find']);
    });
});
