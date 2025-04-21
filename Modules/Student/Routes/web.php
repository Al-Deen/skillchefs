<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\StudentController;

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
    Route::prefix('student')->group(function () {
        Route::controller(StudentController::class)->group(function () {
            Route::get('/list', 'index')->name('admin.student.index')->middleware('PermissionCheck:student_list');

            Route::get('/create', 'create')->name('admin.student.create')->middleware('PermissionCheck:student_create');
            Route::post('/store', 'store')->name('admin.student.store')->middleware('PermissionCheck:student_store');
            Route::get('/edit/{id}/{slug}', 'edit')->name('admin.student.edit')->middleware('PermissionCheck:student_update');
            Route::post('/update/{id}/{slug}', 'update')->name('admin.student.update')->middleware('PermissionCheck:student_update');
            Route::get('/login/{id}', 'login')->name('admin.student.login')->middleware('PermissionCheck:student_login');

            Route::get('/suspend/{id}', 'suspend')->name('admin.student.suspend')->middleware('PermissionCheck:student_suspend');
            Route::get('/re-activate/{id}', 'reActivate')->name('admin.student.re_activate')->middleware('PermissionCheck:student_re_activate');
        });

        // student education
        Route::controller(EducationController::class)->group(function () {
            // add institute
            Route::get('add-institute/{id}', 'addInstitute')->name('admin.student.addInstitute')->middleware('PermissionCheck:student_add_institute');
            Route::post('store-institute/{id}', 'storeInstitute')->name('admin.student.store.institute')->middleware('PermissionCheck:student_store_institute');
            Route::get('edit-institute/{key}/{id}', 'editInstitute')->name('admin.student.edit.institute')->middleware('PermissionCheck:student_update_institute');
            Route::post('update-institute/{key}/{id}', 'updateInstitute')->name('admin.student.update.institute')->middleware('PermissionCheck:student_update_institute');
            Route::get('delete-institute/{key}/{id}', 'deleteInstitute')->name('admin.student.delete.institute')->middleware('PermissionCheck:student_delete_institute');
        });
        // student education

        // student experience
        Route::controller(ExperienceController::class)->group(function () {
            // add institute
            Route::get('add-experience/{id}', 'addExperience')->name('admin.student.add.experience')->middleware('PermissionCheck:student_add_experience');
            Route::post('store-experience/{id}', 'storeExperience')->name('admin.student.store.experience')->middleware('PermissionCheck:student_store_experience');
            Route::get('edit-experience/{key}/{id}', 'editExperience')->name('admin.student.edit.experience')->middleware('PermissionCheck:student_update_experience');
            Route::post('update-experience/{key}/{id}', 'updateExperience')->name('admin.student.update.experience')->middleware('PermissionCheck:student_update_experience');
            Route::get('delete-experience/{key}/{id}', 'deleteExperience')->name('admin.student.delete.experience')->middleware('PermissionCheck:student_delete_experience');
        });
        // student experience

        // student skill
        Route::controller(SkillController::class)->group(function () {
            Route::get('add-skill/{id}', 'addSkill')->name('admin.student.add.skill')->middleware('PermissionCheck:student_add_skill');
            Route::post('store-skill/{id}', 'storeSkill')->name('admin.student.store.skill')->middleware('PermissionCheck:student_store_skill');
        });

    });
});
