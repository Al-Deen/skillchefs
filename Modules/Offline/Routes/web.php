<?php

use Illuminate\Support\Facades\Route;
use Modules\Offline\Http\Controllers\OfflineController;

// Route::prefix('offline')->group(function() {
//     Route::get('/', 'OfflineController@index');
// });

// admin routes
Route::prefix('admin')->middleware(['auth.routes'])->group(function () {
    Route::controller(OfflineController::class)->group(function () {
        Route::prefix('offline_payment')->group(function () {
            Route::get('/settings', 'Settings')->name('admin.offline_payment.settings')->middleware('PermissionCheck:offline_payment_settings');
            Route::get('/settings/edit/{id}', 'SettingsEdit')->name('admin.offline_payment.settings_edit')->middleware('PermissionCheck:offline_payment_settings_edit');
            Route::post('/settings/update/{id}', 'SettingsUpdate')->name('admin.offline_payment.settings_update')->middleware('PermissionCheck:offline_payment_settings_edit');

            Route::get('/course/enroll/approval', 'courseApprovalIndex')->name('admin.course.enroll.approval')->middleware('PermissionCheck:course_enroll_approval');
            Route::get('/approve/view/{id}', 'viewCourseApproval')->name('course.enroll.view')->middleware('PermissionCheck:course_enroll_approval_update');
            Route::post('/approve/{id}', 'updateCourseApproval')->name('course.enroll.approve')->middleware('PermissionCheck:course_enroll_approval_update');
            Route::get('/destroy/{id}', 'destroyCourseApproval')->name('course.enroll.destroy')->middleware('PermissionCheck:course_enroll_approval_delete');

            Route::get('/event/enroll/approval', 'eventApprovalIndex')->name('admin.event.enroll.approval')->middleware('PermissionCheck:event_enroll_approval');
            Route::get('/event/approve/view/{id}', 'viewEventApproval')->name('event.enroll.view')->middleware('PermissionCheck:event_enroll_approval_update');
            Route::post('/event/approve/{id}', 'updateEventApproval')->name('event.enroll.approve')->middleware('PermissionCheck:event_enroll_approval_update');
            Route::get('/event/destroy/{id}', 'destroyEventApproval')->name('event.enroll.destroy')->middleware('PermissionCheck:event_enroll_approval_delete');

            Route::get('/package/enroll/approval', 'packageApprovalIndex')->name('admin.package.enroll.approval')->middleware('PermissionCheck:package_enroll_approval');
            Route::get('/package/approve/view/{id}', 'viewPackageApproval')->name('package.enroll.view')->middleware('PermissionCheck:package_enroll_approval_update');
            Route::post('/package/approve/{id}', 'updatePackageApproval')->name('package.enroll.approve')->middleware('PermissionCheck:package_enroll_approval_update');
            Route::get('/package/destroy/{id}', 'destroyPackageApproval')->name('package.enroll.destroy')->middleware('PermissionCheck:package_enroll_approval_delete');
        });
    });
});
