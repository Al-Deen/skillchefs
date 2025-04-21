<?php

use App\Http\Controllers\Panel\Student\AssignmentController;
use App\Http\Controllers\Panel\Student\CertificateController;
use App\Http\Controllers\Panel\Student\EducationController;
use App\Http\Controllers\Panel\Student\ExperienceController;
use App\Http\Controllers\Panel\Student\NoteController;
use App\Http\Controllers\Panel\Student\QuizController;
use App\Http\Controllers\Panel\Student\ReviewController;
use App\Http\Controllers\Panel\Student\SettingsController;
use App\Http\Controllers\Panel\Student\StudentController;
use Illuminate\Support\Facades\Route;

// Student Dashboard Related routes
Route::prefix('student')->middleware(['student', 'auth'])->group(function () {
    Route::controller(StudentController::class)->group(function () {
        Route::post('/logout', 'logout')->name('student.logout');
    });
});
Route::prefix('student')->middleware(['student', 'auth', 'verified', 'phone_verified'])->group(function () {

    Route::controller(StudentController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('student.dashboard');
        Route::get('/profile', 'profile')->name('student.profile');

        // start  course learn
        Route::get('courses', 'courses')->name('student.course'); // student course
        Route::get('course/{slug}/learn/lecture/{lesson_id}', 'courseLearn')->name('student.course.learn'); // student course
        Route::post('course-lecture-progress', 'courseEnrollProgress'); // student enroll course progress
        Route::post('course-tab-load', 'tabLoad'); // student enroll course progress
        // end  course learn

        // start course activity
        Route::get('/course-activities', 'courseActivities')->name('student.course_activities');
        // end course activity

        // start leader board
        Route::get('/leader-board', 'leaderBoard')->name('student.leader_board');
        // end leader board

        Route::get('/my-learning', 'myLearning')->name('student.my_learning');

    });
    // course note
    Route::controller(NoteController::class)->prefix('note')->group(function () {
        Route::get('note/create/{lesson_id}', 'noteCreate')->name('student.note.create'); // student enroll course progress
        Route::post('note/store/{lesson_id}', 'noteStore')->name('student.note.store'); // student enroll course progress
        Route::get('note/edit/{id}', 'noteEdit')->name('student.note.edit'); // student enroll course progress
        Route::post('note/update/{id}', 'noteUpdate')->name('student.note.update'); // student enroll course progress
        Route::get('note/delete/{id}', 'noteDelete')->name('student.note.delete'); // student enroll course progress
    });
    // course note

    // course assignment
    Route::controller(AssignmentController::class)->prefix('assignment')->group(function () {
        Route::get('assignment/details/{enroll_id}/{assignment_id}', 'assignmentDetails')->name('student.assignment.details'); // student enroll course progress
        Route::post('assignment/store/{lesson_id}/{assignment_id}', 'assignmentStore')->name('student.assignment.store'); // student enroll course
        Route::get('assignment/download/{enroll_id}/{assignment_id}', 'assignmentDownload')->name('student.assignment.download'); // student enroll course progress
    });
    // course assignment

    // student course review
    Route::controller(ReviewController::class)->prefix('review')->group(function () {
        Route::get('review/create/{course_id}', 'reviewCreate')->name('student.review.create'); // student enroll course progress
        Route::post('review/store/{course_id}', 'reviewStore')->name('student.review.store'); // student enroll course progress
        Route::get('review/edit/{id}', 'reviewEdit')->name('student.review.edit'); // student enroll course progress
        Route::post('review/update/{id}', 'reviewUpdate')->name('student.review.update'); // student enroll course progress
        Route::get('review/delete/{id}', 'reviewDelete')->name('student.review.delete'); // student enroll course progress
    });

    Route::controller(QuizController::class)->prefix('quiz')->group(function () {
        Route::get('quiz/{lesson_id}', 'quiz')->name('student.quiz'); // student enroll course progress
        Route::get('quiz/start/{lesson_id}', 'quizStart')->name('student.quiz.start'); // student enroll course progress
        Route::get('question-load/{quiz_id}', 'questionLoad'); // student enroll course progress
        Route::post('question-submit', 'quizSubmit')->name('student.quiz.submit'); // student enroll course progress
        Route::get('answer-list/{lesson_id}', 'answerList')->name('student.answer.list'); // student enroll course progress
        Route::get('question-up/{quiz_id}', 'questionUp'); // student enroll course progress
    });

    // student certificate
    Route::controller(CertificateController::class)->group(function () {
        // start certificates
        Route::get('/certificates', 'certificates')->name('student.certificates');
        Route::get('certificate/download/{enroll_id}', 'certificateDownload')->name('student.certificate.download'); // student enroll course progress
        Route::get('certificate/view/{enroll_id}', 'certificateView')->name('student.certificate.view'); // student enroll course progress
        // end certificates

    });
    // student certificate

    // student setting
    Route::prefix('setting')->group(function () {
        Route::controller(SettingsController::class)->group(function () {
            Route::get('profile/{slug?}', 'setting')->name('student.setting');
            Route::post('/update-profile', 'updateProfile')->name('student.update_profile');
            Route::post('update-password', 'updatePassword')->name('student.update_password');

            Route::get('add-skills', 'addSkill')->name('student.add.skill');
            Route::post('store-skills', 'storeSkill')->name('student.store.skill');
        });

        // student education
        Route::controller(EducationController::class)->group(function () {
            // add institute
            Route::get('add-institute', 'addInstitute')->name('student.addInstitute');
            Route::post('store-institute', 'storeInstitute')->name('student.store.institute');
            Route::get('edit-institute/{key}', 'editInstitute')->name('student.edit.institute');
            Route::post('update-institute/{key}', 'updateInstitute')->name('student.update.institute');
            Route::get('delete-institute/{key}', 'deleteInstitute')->name('student.delete.institute');
        });
        // student education
        // student experience
        Route::controller(ExperienceController::class)->group(function () {
            // add institute
            Route::get('add-experience', 'addExperience')->name('student.add.experience');
            Route::post('store-experience', 'storeExperience')->name('student.store.experience');
            Route::get('edit-experience/{key}', 'editExperience')->name('student.edit.experience');
            Route::post('update-experience/{key}', 'updateExperience')->name('student.update.experience');
            Route::get('delete-experience/{key}', 'deleteExperience')->name('student.delete.experience');
        });
        // student experience

    });
});

// Student Dashboard Related routes
