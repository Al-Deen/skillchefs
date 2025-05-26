<?php

use App\Http\Controllers\Panel\Ambassador\AmbassadorController;
use App\Http\Controllers\Panel\Ambassador\EducationController;
use App\Http\Controllers\Panel\Ambassador\SettingsController;
use App\Http\Controllers\Panel\Instructor\AISupportController;
use App\Http\Controllers\Panel\Instructor\AssignmentController;
use App\Http\Controllers\Panel\Instructor\BookController;
use App\Http\Controllers\Panel\Instructor\CourseController;

use App\Http\Controllers\Panel\Instructor\ExperienceController;
use App\Http\Controllers\Panel\Instructor\FinancialController;
use App\Http\Controllers\Panel\Instructor\InstructorController;
use App\Http\Controllers\Panel\Instructor\LessonController;
use App\Http\Controllers\Panel\Instructor\NoticeBoardController;
use App\Http\Controllers\Panel\Instructor\PaymentMethodController;
use App\Http\Controllers\Panel\Instructor\QuestionController;
use App\Http\Controllers\Panel\Instructor\SectionController;

use App\Http\Controllers\Panel\Instructor\SupportController;
use App\Http\Controllers\Panel\InvoiceController;
use Illuminate\Support\Facades\Route;

// instructor Dashboard Related routes
Route::prefix('ambassador')->middleware(['ambassador', 'auth'])->group(function () {
    Route::controller(AmbassadorController::class)->group(function () {
        Route::post('/logout', 'logout')->name('ambassador.logout');
    });
});
Route::prefix('ambassador')->middleware(['ambassador', 'auth'])->group(function () {

    Route::controller(AmbassadorController::class)->group(function () {
        Route::get('/profile', 'profile')->name('ambassador.profile');
        //dashboard route start
        Route::get('/dashboard', 'dashboard')->name('ambassador.dashboard');
//        Route::post('monthly-sales', 'monthlySales')->name('instructor.monthly_sales');
//        //dashboard route end
//
//        Route::get('/upload-course', 'uploadCourse')->name('instructor.upload_course');
//
//        Route::get('/playlist', 'playlist')->name('instructor.playlist');
//        Route::get('/course-activity', 'courseActivity')->name('instructor.course_activity');
//
//        Route::get('/financial-summary', 'financialSummary')->name('instructor.financial_summary');
//        Route::get('/notification', 'notification')->name('instructor.notification');
//
//        // Ambassador setting
        Route::prefix('setting')->group(function () {
            Route::controller(SettingsController::class)->group(function () {
                Route::get('profile/{slug?}', 'setting')->name('ambassador.setting');
                Route::post('/update-profile', 'updateProfile')->name('ambassador.update_profile');
                Route::post('update-password', 'updatePassword')->name('ambassador.update_password');

//                Route::get('add-skills', 'addSkill')->name('instructor.add.skill');
//                Route::post('store-skills', 'storeSkill')->name('instructor.store.skill');
            });

            // Instructor education
            Route::controller(EducationController::class)->group(function () {
                // add institute
                Route::get('add-institute', 'addInstitute')->name('ambassador.addInstitute');
                Route::post('store-institute', 'storeInstitute')->name('ambassador.store.institute');
                Route::get('edit-institute/{key}', 'editInstitute')->name('ambassador.edit.institute');
                Route::post('update-institute/{key}', 'updateInstitute')->name('ambassador.update.institute');
                Route::get('delete-institute/{key}', 'deleteInstitute')->name('ambassador.delete.institute');
            });
            // Instructor education

            // Instructor experience
//            Route::controller(ExperienceController::class)->group(function () {
//                // add institute
//                Route::get('add-experience', 'addExperience')->name('instructor.add.experience');
//                Route::post('store-experience', 'storeExperience')->name('instructor.store.experience');
//                Route::get('edit-experience/{key}', 'editExperience')->name('instructor.edit.experience');
//                Route::post('update-experience/{key}', 'updateExperience')->name('instructor.update.experience');
//                Route::get('delete-experience/{key}', 'deleteExperience')->name('instructor.delete.experience');
//            });
            // Instructor experience

        });
    });

});
// End instructor Dashboard Related routes

//Route::controller(AmbassadorController::class)->group(function () {
//    Route::get('/instractors', 'index')->name('instractors');
//    Route::get('/instructor-details', 'details')->name('instructorDetails');
//});
