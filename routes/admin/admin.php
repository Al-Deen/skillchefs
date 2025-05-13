<?php

use App\Http\Controllers\Backend\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MyProfileController;
use App\Http\Controllers\Backend\AuthenticationController;


 // auth routes
 Route::group(['middleware' => ['auth.routes', 'admin']], function () {

    // dashboard routes
    Route::get('dashboard',       [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');
    Route::get('admin/revenue',         [App\Http\Controllers\Backend\DashboardController::class, 'revenue'])->name('revenue');
    Route::get('admin/sales',         [App\Http\Controllers\Backend\DashboardController::class, 'sales'])->name('sales');
    Route::post('logout',         [App\Http\Controllers\Backend\AuthenticationController::class, 'logout'])->name('logout');

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/',                 'index')->name('roles.index')->middleware('PermissionCheck:role_read');
        Route::get('/create',           'create')->name('roles.create')->middleware('PermissionCheck:role_create');
        Route::post('/store',           'store')->name('roles.store')->middleware('PermissionCheck:role_create');
        Route::get('/edit/{id}',        'edit')->name('roles.edit')->middleware('PermissionCheck:role_update');
        Route::put('/update/{id}',      'update')->name('roles.update')->middleware('PermissionCheck:role_update');
        Route::get('/delete/{id}',   'delete')->name('roles.delete')->middleware('PermissionCheck:role_delete');
    });

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/',                 'index')->name('users.index')->middleware('PermissionCheck:user_read');
        Route::get('/create',           'create')->name('users.create')->middleware('PermissionCheck:user_create');
        Route::post('/store',           'store')->name('users.store')->middleware('PermissionCheck:user_create');
        Route::get('/edit/{id}',        'edit')->name('users.edit')->middleware('PermissionCheck:user_update');
        Route::put('/update/{id}',      'update')->name('users.update')->middleware('PermissionCheck:user_update');
        Route::get('/delete/{id}',   'delete')->name('users.delete')->middleware('PermissionCheck:user_delete');

        Route::get('/change-role',      'changeRole')->name('change.role');
        Route::post('/status',      'status')->name('users.status');
        Route::delete('/{id}',      'deletes')->name('users.deletes');
    });

    Route::controller(MyProfileController::class)->prefix('my')->group(function () {
        Route::get('/profile',              'profile')->name('my.profile');
        Route::get('/profile/edit',         'edit')->name('my.profile.edit');
        Route::put('/profile/update',       'update')->name('my.profile.update');

        Route::get('/password/update',      'passwordUpdate')->name('passwordUpdate');
        Route::put('/password/update/store', 'passwordUpdateStore')->name('passwordUpdateStore');
    });

    Route::controller(LanguageController::class)->prefix('languages')->group(function () {
        Route::get('/',                         'index')->name('languages.index')->middleware('PermissionCheck:language_read');
        Route::get('/create',                   'create')->name('languages.create')->middleware('PermissionCheck:language_create');
        Route::post('/store',                   'store')->name('languages.store')->middleware('PermissionCheck:language_create');
        Route::get('/edit/{id}',                'edit')->name('languages.edit')->middleware('PermissionCheck:language_update');
        Route::put('/update/{id}',              'update')->name('languages.update')->middleware('PermissionCheck:language_update');
        Route::delete('/delete/{id}',           'delete')->name('languages.delete')->middleware('PermissionCheck:language_delete');

        Route::get('/terms/{id}',               'terms')->name('languages.edit.terms')->middleware('PermissionCheck:language_update_terms');
        Route::put('/update/terms/{code}',      'termsUpdate')->name('languages.update.terms')->middleware('PermissionCheck:language_update_terms');
        Route::get('/change-module',            'changeModule')->name('languages.change.module');

        Route::get('/change',                   'changeLanguage')->name('languages.change');
    });

    Route::controller(SettingController::class)->prefix('/')->group(function () {

        Route::get('/general-settings',             'generalSettings')->name('settings.general-settings')->middleware('PermissionCheck:general_settings_read');
        Route::post('/general-settings',            'updateGeneralSetting')->name('settings.general-settings')->middleware('PermissionCheck:general_settings_update');

        Route::get('/seo-setting',              'seoSetting')->name('settings.seo_setting')->middleware('PermissionCheck:seo_settings_read');
        Route::post('/seo-setting-update',       'seoSettingUpdate')->name('settings.seo_setting_update')->middleware("PermissionCheck:seo_settings_update");

        Route::get('/twilio-settings',             'twilioSettings')->name('settings.twilio-settings')->middleware('PermissionCheck:general_settings_read');
        Route::post('/twilio-settings',            'updateTwilioSetting')->name('settings.twilio-settings')->middleware('PermissionCheck:general_settings_update');

        Route::get('/storage-setting',              'storageSetting')->name('settings.storagesetting')->middleware('PermissionCheck:storage_settings_read');
        Route::put('/storage-setting-update',       'storageSettingUpdate')->name('settings.storageSettingUpdate')->middleware("PermissionCheck:storage_settings_update");


        Route::get('/email-setting',                 'mailSetting')->name('settings.mail-setting')->middleware('PermissionCheck:email_settings_read');
        Route::post('/email-setting',                'updateMailSetting')->name('settings.mail-setting')->middleware('PermissionCheck:email_settings_update');

        //Theme Change
        Route::post('/change-theme',                 'changeTheme')->name('changeTheme');
    });


     Route::prefix('admin')->middleware(['auth.routes','admin'])->group(function () {
         Route::controller(BookController::class)->group(function () {
                 Route::get('/book/index', 'index')->name('book.index');
                 Route::get('/book/create', 'create')->name('book.create');
                 Route::post('/book/store', 'store')->name('book.store');
                 Route::get('/book/edit/{id}', 'edit')->name('book.edit');
                 Route::put('/update/{id}', 'update')->name('book.update');
                 Route::get('/delete/{id}', 'destroy')->name('course-category.destroy');
                 Route::get('/view/book-short-file/{id}', 'shortFilePDFView')->name('book.short-file.view');
                 Route::get('/view/full-file-book/{id}', 'fullFilePDFView')->name('book.fullfile.view');
                 Route::get('/delete-book/{id}', 'delete')->name('book.destroy');
         });

     });

});
