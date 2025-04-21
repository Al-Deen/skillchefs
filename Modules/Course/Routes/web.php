<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\QuestionController;
use Modules\Course\Http\Controllers\ReviewController;

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

    // Start Course Category Routes
    Route::controller(CourseCategoryController::class)->group(function () {
        Route::prefix('category')->group(function () {
            Route::get('/', 'index')->name('course-category.index')->middleware('PermissionCheck:course_category_read');
            Route::post('/list', 'list')->name('course-category.list')->middleware('PermissionCheck:course_category_read');
            Route::get('/create', 'create')->name('course-category.create')->middleware('PermissionCheck:course_category_create');
            Route::post('/store', 'store')->name('course-category.store')->middleware('PermissionCheck:course_category_store');
            Route::get('/edit/{id}', 'edit')->name('course-category.edit')->middleware('PermissionCheck:course_category_update');
            Route::put('/update/{id}', 'update')->name('course-category.update')->middleware('PermissionCheck:course_category_update');
            Route::get('/delete/{id}', 'destroy')->name('course-category.destroy')->middleware('PermissionCheck:course_category_delete');
        });

        // popular category
        Route::get('/popular-categories', 'popular')->name('course-category.popular')->middleware('PermissionCheck:popular_course_category_list');
        Route::get('/popular-category-created', 'popularCreated')->name('popular-course-category.created')->middleware('PermissionCheck:popular_course_category_added');
        Route::post('/popular-category-store', 'popularStore')->name('popular-course-category.store')->middleware('PermissionCheck:popular_course_category_added');
        Route::get('/popular-categories-deleted/{id}', 'popularDelete')->name('popular-course-category.delete')->middleware('PermissionCheck:popular_course_category_deleted');
        // popular category
    });
    // End Course Category Routes

    // Start Course Routes
    Route::prefix('course')->group(function () {
        Route::get('/', 'CourseController@index')->name('course.index')->middleware('PermissionCheck:course_read');
        Route::get('/create', 'CourseController@create')->name('course.create')->middleware('PermissionCheck:course_create');
        Route::post('/store', 'CourseController@store')->name('course.store')->middleware('PermissionCheck:course_store');
        // course update feature wise
        Route::get('/edit/{id}', 'CourseController@edit')->name('course.edit')->middleware('PermissionCheck:course_update');
        Route::get('content/{id}/{type}', 'CourseController@addContent')->name('course.addContent')->middleware('PermissionCheck:course_update');
        // course update feature wise
        //ajax course data
        Route::post('/ajax/list', 'CourseController@list')->name('course.list')->middleware('PermissionCheck:course_read');
        // start course assignment create
        Route::prefix('assignment')->group(function () {
            Route::get('list/{id}', 'AssignmentController@index')->name('course.assignment.index')->middleware('PermissionCheck:course_assignment_list');
            Route::get('create/{id}', 'AssignmentController@create')->name('course.assignment.create')->middleware('PermissionCheck:course_assignment_create');
            Route::post('store/{id}', 'AssignmentController@store')->name('course.assignment.store')->middleware('PermissionCheck:course_assignment_store');
            Route::get('edit/{id}', 'AssignmentController@edit')->name('course.assignment.edit')->middleware('PermissionCheck:course_assignment_update');
            Route::put('update/{id}', 'AssignmentController@update')->name('course.assignment.update')->middleware('PermissionCheck:course_assignment_update');
            Route::get('delete/{id}', 'AssignmentController@destroy')->name('course.assignment.destroy')->middleware('PermissionCheck:course_assignment_delete');
        });
        // end course assignment create
        // start course notice board create
        Route::prefix('notice-board')->group(function () {
            Route::get('list/{id}', 'NoticeBoardController@index')->name('course.notice-board.index')->middleware('PermissionCheck:course_noticeboard_list');
            Route::get('create/{id}', 'NoticeBoardController@create')->name('course.notice-board.create')->middleware('PermissionCheck:course_noticeboard_create');
            Route::post('store/{id}', 'NoticeBoardController@store')->name('course.notice-board.store')->middleware('PermissionCheck:course_noticeboard_store');
            Route::get('edit/{id}', 'NoticeBoardController@edit')->name('course.noticeboard.edit')->middleware('PermissionCheck:course_noticeboard_update');
            Route::put('update/{id}', 'NoticeBoardController@update')->name('course.noticeboard.update')->middleware('PermissionCheck:course_noticeboard_update');
            Route::get('delete/{id}', 'NoticeBoardController@destroy')->name('course.notice-board.destroy')->middleware('PermissionCheck:course_noticeboard_delete');
            // end course notice board create
        });
        Route::prefix('curriculum')->group(function () {
            Route::get('list/{id}', 'SectionController@index')->name('course.curriculum.index')->middleware('PermissionCheck:course_curriculum');
            Route::get('create/{id}', 'SectionController@create')->name('course.curriculum.create')->middleware('PermissionCheck:course_curriculum_create');
            Route::post('store/{id}', 'SectionController@store')->name('course.curriculum.store')->middleware('PermissionCheck:course_curriculum_store');
            Route::get('edit/{id}', 'SectionController@edit')->name('course.curriculum.edit')->middleware('PermissionCheck:course_curriculum_update');
            Route::post('update/{id}', 'SectionController@update')->name('course.curriculum.update')->middleware('PermissionCheck:course_curriculum_update');
            Route::get('delete/{id}', 'SectionController@destroy')->name('course.curriculum.destroy')->middleware('PermissionCheck:course_curriculum_delete');
        });
        Route::prefix('lesson')->group(function () {
            Route::get('list/{id}', 'LessonController@index')->name('course.lesson.index')->middleware('PermissionCheck:course_lesson');
            Route::get('create/{id}', 'LessonController@create')->name('course.lesson.create')->middleware('PermissionCheck:course_lesson_create');
            Route::post('store/{id}', 'LessonController@store')->name('course.lesson.store')->middleware('PermissionCheck:course_lesson_store');
            Route::get('edit/{id}', 'LessonController@edit')->name('course.lesson.edit')->middleware('PermissionCheck:course_lesson_update');
            Route::post('update/{id}', 'LessonController@update')->name('course.lesson.update')->middleware('PermissionCheck:course_lesson_update');
            Route::get('delete/{id}', 'LessonController@destroy')->name('course.lesson.destroy')->middleware('PermissionCheck:course_lesson_delete');
        });
        Route::prefix('quiz')->group(function () {
            Route::get('list/{id}', 'QuizController@index')->name('course.quiz.index')->middleware('PermissionCheck:course_quiz_list');
            Route::get('create/{id}', 'QuizController@create')->name('course.quiz.create')->middleware('PermissionCheck:course_quiz_create');
            Route::post('store/{id}', 'QuizController@store')->name('course.quiz.store')->middleware('PermissionCheck:course_quiz_store');
            Route::get('edit/{id}', 'QuizController@edit')->name('course.quiz.edit')->middleware('PermissionCheck:course_quiz_update');
            Route::post('update/{id}', 'QuizController@update')->name('course.quiz.update')->middleware('PermissionCheck:course_quiz_update');
            Route::get('delete/{id}', 'QuizController@destroy')->name('course.quiz.destroy')->middleware('PermissionCheck:course_quiz_delete');
        });

        Route::put('/update/{id}', 'CourseController@update')->name('course.update')->middleware('PermissionCheck:course_update');
        Route::get('/delete/{id}', 'CourseController@destroy')->name('course.destroy')->middleware('PermissionCheck:course_delete');

        Route::prefix('ajax')->group(function () {
            Route::get('course/assignment/{id}', 'AssignmentController@ajaxAssignment')->name('course.get-assignment')->middleware('PermissionCheck:course_read'); // course assignment ajax
            Route::get('course/notice-board/{id}', 'NoticeBoardController@ajaxNoticeBoard')->name('course.get-noticeboard')->middleware('PermissionCheck:course_read'); // course assignment ajax
        });
    });

    Route::controller(AssignmentController::class)->prefix('assignment')->group(function () {
        Route::get('list', 'assignmentList')->name('course.assignment_list.index')->middleware('PermissionCheck:course_assignment_list');
        Route::get('submission-list/{id}', 'assignmentSubmissionList')->name('course.assignment_submission_list.index')->middleware('PermissionCheck:course_assignment_submission_list');
        Route::get('submission-view/{id}', 'assignmentSubmissionView')->name('course.assignment_submission_view.index')->middleware('PermissionCheck:course_assignment_submission_view');
        Route::get('submission-view/{id}', 'assignmentSubmissionView')->name('course.assignment_submission_view.index')->middleware('PermissionCheck:course_assignment_submission_view');

        Route::post('/marks/{id}', 'marks')->name('admin.assignment.marks');
        Route::get('/download/{assignment_id}', 'assignmentDownload')->name('admin.assignment.download'); // assignment download
        Route::get('/submission-download/{assignment_id}', 'assignmentSubmissionDownload')->name('admin.assignment_submission.download'); // assignment submission download
    });
    Route::controller(QuestionController::class)->prefix('quiz')->group(function () {
        Route::get('list', 'index')->name('admin.quiz.index')->middleware('PermissionCheck:course_quiz_list');
        Route::get('submission-list/{id}', 'submission')->name('admin.quiz.submission')->middleware('PermissionCheck:course_quiz_submission_list');
        Route::get('view/{id}', 'view')->name('admin.quiz.view')->middleware('PermissionCheck:course_quiz_submission_view');
    });
    Route::controller(QuestionController::class)->prefix('question')->group(function () {
        Route::get('list/{id}', 'questionList')->name('admin.question.list');
        Route::get('/add-question/{id}', 'create')->name('admin.question.add');
        Route::post('/store-question/{id}', 'store')->name('admin.question.store');
        Route::get('/edit-question/{id}', 'edit')->name('admin.question.edit');
        Route::post('/update-question/{id}', 'update')->name('admin.question.update');
        Route::post('/sortable-question/{id}', 'sortable')->name('admin.question.sortable');
        Route::get('/delete-question/{id}', 'destroy')->name('admin.question.delete');

    });

    // review route
    Route::controller(ReviewController::class)->prefix('review')->group(function () {
        Route::get('list', 'index')->name('admin.review.index')->middleware('PermissionCheck:review_list');
    });
    // review route

});
