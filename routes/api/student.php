<?php

use Illuminate\Support\Facades\Route;

use Modules\Api\Http\Controllers\AppController;
use Modules\Api\Http\Controllers\ProfileController;
use Modules\Api\Http\Controllers\BookmarkController;
use Modules\Api\Http\Controllers\AssignmentController;
use App\Http\Controllers\Api\V1\Student\AuthController;
use App\Http\Controllers\Api\V1\Student\NoteController;
use App\Http\Controllers\Api\V1\Student\QuizController;
use Modules\Api\Http\Controllers\CertificateController;
use App\Http\Controllers\Api\V1\Student\ReviewController;
use App\Http\Controllers\Api\V1\Student\StudentController;
use App\Http\Controllers\Api\V1\Student\DashboardController;
use App\Http\Controllers\Api\V1\Student\EducationController;
use App\Http\Controllers\Api\V1\Student\ExperienceController;
use App\Http\Controllers\Api\V1\Guest\CourseCategoryController;



// Students Auth related routes
Route::controller(AuthController::class)->prefix('v1')->group(function () {

    Route::post('/registration',                            'signUpPost')->name('student.api.sign_up_post');
    Route::post('/sign-in',                                 'signInPost')->name('student.api.sign_in_post');

    Route::post('student/verify-email',                     'verifyEmail')->name('student.api.verify_email');
    // reset password
    Route::post('student/forgot-password',                  'forgotPassword')->name('student.api.forgot_password');
    Route::post('student/verify-otp',                       'verifyOTP')->name('student.api.verifyOTP');

    Route::post('student/reset-password',                   'resetPassword')->name('student.api.reset_password');

});
//  Students Auth related routes


// Student Dashboard Related routes
Route::get('v1/student/dashboard',                          [AppController::class, 'dashboard'])->middleware('auth:sanctum')->name('page.api.about');


Route::prefix('v1/student')->middleware(['auth:sanctum'])->group(function () {

    // phone number verification
    Route::controller(AuthController::class)->group(function () {
        Route::post('/verify-phone',                     'verifyPhone')->name('student.api.verify_phone');
        Route::post('/resend-otp-phone',                 'resentOTPForPhone')->name('student.api.resend_otp_phone');
    });

    
    Route::controller(StudentController::class)->group(function () {

        Route::get('/profile',                              'profile')->name('student.api.profile');
        Route::get('/my-profile',                           'myProfile')->name('student.api.my_profile');

        // start  course learn
        Route::get('courses',                               'courses')->name('student.api.course'); // student course
        Route::get('course/{slug}/learn/lecture/{lesson_id}', 'courseLearn')->name('student.api.course.learn'); // student course
        Route::post('course-lecture-progress', 'courseEnrollProgress'); // student enroll course progress
        Route::post('course-tab-load', 'tabLoad'); // student enroll course progress
        // end  course learn

        // start course activity
        Route::get('/course-activities',                    'courseActivities')->name('student.api.course_activities');
        // end course activity

        // start leader board
        Route::get('/leader-board',                         'leaderBoard')->name('student.api.leader_board');
        // end leader board

        Route::get('/my-learning',                          'myLearning')->name('student.api.my_learning');
        Route::post('/logout',                              'logout')->name('student.api.logout');

    });

    // start bookmark
    Route::middleware(['auth:sanctum'])->controller(BookmarkController::class)->prefix('bookmark')->group(function(){
        Route::get('/',                                      'bookmark')->name('student.api.bookmark');
        Route::get('/update/{course_id}',                    'bookmarkUpdate');
    });
    // end bookmark

    // course note
    Route::controller(NoteController::class)->prefix('note')->group(function () {
        Route::get('note/create/{lesson_id}',               'noteCreate')->name('student.api.note.create'); // student enroll course progress
        Route::post('note/store/{lesson_id}',               'noteStore')->name('student.api.note.store'); // student enroll course progress
        Route::get('note/edit/{id}',                        'noteEdit')->name('student.api.note.edit'); // student enroll course progress
        Route::post('note/update/{id}',                     'noteUpdate')->name('student.api.note.update'); // student enroll course progress
        Route::get('note/delete/{id}',                      'noteDelete')->name('student.api.note.delete'); // student enroll course progress
    });
    // course note

    // course assignment
    // Route::controller(AssignmentController::class)->prefix('assignment')->group(function () {
    //     Route::get('assignment/details/{enroll_id}/{assignment_id}',        'assignmentDetails')->name('student.api.assignment.details'); // student enroll course progress
    //     Route::post('assignment/store/{lesson_id}/{assignment_id}',         'assignmentStore')->name('student.api.assignment.store'); // student enroll course
    //     Route::get('assignment/download/{enroll_id}/{assignment_id}',       'assignmentDownload')->name('student.api.assignment.download'); // student enroll course progress
    // });
    // course assignment

    // student course review
    Route::controller(ReviewController::class)->prefix('review')->group(function () {
        Route::get('review/create/{course_id}',             'reviewCreate')->name('student.api.review.create'); // student enroll course progress
        Route::post('review/store/{course_id}',             'reviewStore')->name('student.api.review.store'); // student enroll course progress
        Route::get('review/edit/{id}',                      'reviewEdit')->name('student.api.review.edit'); // student enroll course progress
        Route::post('review/update/{id}',                   'reviewUpdate')->name('student.api.review.update'); // student enroll course progress
        Route::get('review/delete/{id}',                    'reviewDelete')->name('student.api.review.delete'); // student enroll course progress
    });

    Route::controller(QuizController::class)->prefix('quiz')->group(function () {
        Route::get('quiz/{lesson_id}',                      'quiz')->name('student.api.quiz'); // student enroll course progress
        Route::get('quiz/start/{lesson_id}',                'quizStart')->name('student.api.quiz.start'); // student enroll course progress
        Route::get('question-load/{quiz_id}',               'questionLoad'); // student enroll course progress
        Route::post('question-submit',                      'quizSubmit')->name('student.api.quiz.submit'); // student enroll course progress
        Route::get('answer-list/{lesson_id}',               'answerList')->name('student.api.answer.list'); // student enroll course progress
        Route::get('question-up/{quiz_id}',                 'questionUp'); // student enroll course progress
    });

    // student setting
    Route::prefix('setting')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::post('/update-profile',                  'updateProfile')->name('student.api.update_profile');
            Route::post('/update-password',                 'updatePassword')->name('student.api.update_password');

            Route::get('add-skills',                        'addSkill')->name('student.api.add.skill');
            Route::post('store-skills',                     'storeSkill')->name('student.api.store.skill');
        });

        // student education
        Route::controller(EducationController::class)->group(function () {
            // add institute
            Route::post('store-institute',                  'storeInstitute')->name('student.api.store.institute');
            Route::get('edit-institute/{key}',              'editInstitute')->name('student.api.edit.institute');
            Route::post('update-institute/{key}',           'updateInstitute')->name('student.api.update.institute');
            Route::get('delete-institute/{key}',            'deleteInstitute')->name('student.api.delete.institute');
        });
        // student education
        // student experience
        Route::controller(ExperienceController::class)->group(function () {
            // add institute
            Route::get('add-experience',                     'addExperience')->name('student.api.add.experience');
            Route::post('store-experience',                  'storeExperience')->name('student.api.store.experience');
            Route::get('edit-experience/{key}',              'editExperience')->name('student.api.edit.experience');
            Route::post('update-experience/{key}',           'updateExperience')->name('student.api.update.experience');
            Route::get('delete-experience/{key}',            'deleteExperience')->name('student.api.delete.experience');
        });
        // student experience

    });
    // Assignment
    Route::controller(AssignmentController::class)->prefix('assignment')->group(function () {
        Route::get('/',                                 'index');
        Route::get('/{id}/details',                     'assignmentDetails');
        Route::post('/store/{assignment_id}',           'assignmentStore');
    });
    // Assignment

    // Certificates
    Route::controller(CertificateController::class)->prefix('certificate')->group(function () {
        Route::get('/',                          'index');
        Route::get('/download/{id}',              'certificateDownload');

    });
    // Certificates
});

// Student Dashboard Related routes



