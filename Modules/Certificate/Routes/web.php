<?php

use Illuminate\Support\Facades\Route;
use Modules\Certificate\Http\Controllers\CertificateGenerateController;

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

    Route::controller(CertificateGenerateController::class)->prefix('certificate')->group(function () {
        Route::get('/', 'index')->name('admin.certificate.index')->middleware('PermissionCheck:certificate_list');
        Route::get('/view/{id}', 'certificateView')->name('admin.certificate.view')->middleware('PermissionCheck:certificate_view');
        Route::get('/download/{id}', 'certificateDownload')->name('admin.certificate.download')->middleware('PermissionCheck:certificate_download');
    });

    Route::controller(CertificateTemplateController::class)->prefix('certificate')->group(function () {
        Route::get('/template', 'index')->name('admin.certificate.template.index')->middleware('PermissionCheck:certificate_template_list');
        Route::get('/template/create', 'create')->name('admin.certificate.template.create')->middleware('PermissionCheck:certificate_template_create');
        Route::post('/template/store', 'store')->name('admin.certificate.template.store')->middleware('PermissionCheck:certificate_template_store');
        Route::get('/template/edit/{id}', 'edit')->name('admin.certificate.template.edit')->middleware('PermissionCheck:certificate_template_edit');
        Route::post('/template/update/{id}', 'update')->name('admin.certificate.template.update')->middleware('PermissionCheck:certificate_template_edit');
        Route::get('/template/delete/{id}', 'destroy')->name('admin.certificate.template.delete')->middleware('PermissionCheck:certificate_template_delete');
    });
});
