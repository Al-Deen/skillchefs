<?php

use Illuminate\Support\Facades\Route;
use Modules\Instructor\Http\Controllers\EducationController;
use Modules\Instructor\Http\Controllers\ExperienceController;
use Modules\Instructor\Http\Controllers\InstructorController;
use Modules\Instructor\Http\Controllers\PaymentController;
use Modules\Instructor\Http\Controllers\SkillController;

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
    Route::prefix('instructor')->group(function () {
        Route::controller(InstructorController::class)->group(function () {
            Route::get('/list', 'index')->name('admin.instructor.index')->middleware('PermissionCheck:instructor_list');
            Route::get('/requests', 'requests')->name('admin.instructor.requests')->middleware('PermissionCheck:instructor_request_list');
            Route::get('/suspended', 'suspends')->name('admin.instructor.suspends')->middleware('PermissionCheck:instructor_suspend_list');

            Route::get('/create', 'create')->name('admin.instructor.create')->middleware('PermissionCheck:instructor_create');
            Route::post('/store', 'store')->name('admin.instructor.store')->middleware('PermissionCheck:instructor_store');
            Route::get('/edit/{id}/{slug}', 'edit')->name('admin.instructor.edit')->middleware('PermissionCheck:instructor_update');
            Route::post('/update/{id}/{slug}', 'update')->name('admin.instructor.update')->middleware('PermissionCheck:instructor_update');
            Route::get('/login/{id}', 'login')->name('admin.instructor.login')->middleware('PermissionCheck:instructor_login');

            Route::get('/approve/{id}', 'approve')->name('admin.instructor.approve')->middleware('PermissionCheck:instructor_approve');
            Route::get('/suspend/{id}', 'suspend')->name('admin.instructor.suspend')->middleware('PermissionCheck:instructor_suspend');
            Route::get('/re-activate/{id}', 'reActivate')->name('admin.instructor.re_activate')->middleware('PermissionCheck:instructor_re_activate');
        });

        // Instructor education
        Route::controller(EducationController::class)->group(function () {
            // add institute
            Route::get('add-institute/{id}', 'addInstitute')->name('admin.instructor.addInstitute')->middleware('PermissionCheck:instructor_add_institute');
            Route::post('store-institute/{id}', 'storeInstitute')->name('admin.instructor.store.institute')->middleware('PermissionCheck:instructor_store_institute');
            Route::get('edit-institute/{key}/{id}', 'editInstitute')->name('admin.instructor.edit.institute')->middleware('PermissionCheck:instructor_update_institute');
            Route::post('update-institute/{key}/{id}', 'updateInstitute')->name('admin.instructor.update.institute')->middleware('PermissionCheck:instructor_update_institute');
            Route::get('delete-institute/{key}/{id}', 'deleteInstitute')->name('admin.instructor.delete.institute')->middleware('PermissionCheck:instructor_delete_institute');
        });
        // Instructor education

        // Instructor experience
        Route::controller(ExperienceController::class)->group(function () {
            // add institute
            Route::get('add-experience/{id}', 'addExperience')->name('admin.instructor.add.experience')->middleware('PermissionCheck:instructor_add_experience');
            Route::post('store-experience/{id}', 'storeExperience')->name('admin.instructor.store.experience')->middleware('PermissionCheck:instructor_store_experience');
            Route::get('edit-experience/{key}/{id}', 'editExperience')->name('admin.instructor.edit.experience')->middleware('PermissionCheck:instructor_update_experience');
            Route::post('update-experience/{key}/{id}', 'updateExperience')->name('admin.instructor.update.experience')->middleware('PermissionCheck:instructor_update_experience');
            Route::get('delete-experience/{key}/{id}', 'deleteExperience')->name('admin.instructor.delete.experience')->middleware('PermissionCheck:instructor_delete_experience');
        });
        // Instructor experience

        // instructor skill
        Route::controller(SkillController::class)->group(function () {
            Route::get('add-skill/{id}', 'addSkill')->name('admin.instructor.add.skill')->middleware('PermissionCheck:instructor_add_skill');
            Route::post('store-skill/{id}', 'storeSkill')->name('admin.instructor.store.skill')->middleware('PermissionCheck:instructor_store_skill');
        });

        //payout request list
        Route::controller(PayoutController::class)->group(function () {
            Route::get('/payout-list', 'index')->name('admin.instructor.payout.index')->middleware('PermissionCheck:instructor_payout_list');
            Route::get('/payout-requests', 'requests')->name('admin.instructor.payout.request')->middleware('PermissionCheck:instructor_payout_request_list');
            Route::get('/unpaid-payout-list', 'unpaid')->name('admin.instructor.payout.unpaid')->middleware('PermissionCheck:instructor_unpaid_payout_list');
            Route::get('/rejected-payout-list', 'rejected')->name('admin.instructor.payout.rejected')->middleware('PermissionCheck:instructor_rejected_payout_list');

            Route::get('/payout-details/{id}', 'details')->name('admin.instructor.payout.details')->middleware('PermissionCheck:instructor_payout_details');

            Route::get('/payout-requests/{id}/approve', 'approve')->name('admin.instructor.payout.approve')->middleware('PermissionCheck:instructor_payout_request_approve');
            Route::get('/payout-requests/{id}/reject', 'reject')->name('admin.instructor.payout.reject')->middleware('PermissionCheck:instructor_payout_request_reject');
            Route::post('/make-reject-payout/{id}', 'makeRejectPayout')->name('admin.instructor.payout.reject.make')->middleware('PermissionCheck:instructor_payout_request_reject');

        });
        //payout request list

        // payment history
        Route::controller(PaymentController::class)->group(function () {
            Route::get('/make-payment/{id}', 'payment')->name('admin.instructor.payout.payment')->middleware('PermissionCheck:instructor_make_payout');
        });

    });
});

Route::controller(PaymentController::class)->prefix('admin-payments')->group(function () {
    Route::any('verify/{method}', 'verify')->name('admin.payment.verify');
    Route::get('status', 'status')->name('admin.payment.status');
});
