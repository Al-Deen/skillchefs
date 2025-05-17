<?php

use App\Http\Controllers\Panel\Instructor\AISupportController;
use App\Http\Controllers\Panel\Instructor\AssignmentController;
use App\Http\Controllers\Panel\Instructor\BookController;
use App\Http\Controllers\Panel\Instructor\CourseController;
use App\Http\Controllers\Panel\Instructor\EducationController;
use App\Http\Controllers\Panel\Instructor\ExperienceController;
use App\Http\Controllers\Panel\Instructor\FinancialController;
use App\Http\Controllers\Panel\Instructor\InstructorController;
use App\Http\Controllers\Panel\Instructor\LessonController;
use App\Http\Controllers\Panel\Instructor\NoticeBoardController;
use App\Http\Controllers\Panel\Instructor\PaymentMethodController;
use App\Http\Controllers\Panel\Instructor\QuestionController;
use App\Http\Controllers\Panel\Instructor\SectionController;
use App\Http\Controllers\Panel\Instructor\SettingsController;
use App\Http\Controllers\Panel\Instructor\SupportController;
use App\Http\Controllers\Panel\InvoiceController;
use Illuminate\Support\Facades\Route;

// instructor Dashboard Related routes
Route::prefix('instructor')->middleware(['instructor', 'auth'])->group(function () {
    Route::controller(InstructorController::class)->group(function () {
        Route::post('/logout', 'logout')->name('instructor.logout');
    });
});
Route::prefix('instructor')->middleware(['instructor', 'auth', 'verified', 'phone_verified'])->group(function () {

    Route::controller(InstructorController::class)->group(function () {
        Route::get('/profile', 'profile')->name('instructor.profile');
        //dashboard route start
        Route::get('/dashboard', 'dashboard')->name('instructor.dashboard')->middleware('verified');
        Route::post('monthly-sales', 'monthlySales')->name('instructor.monthly_sales');
        //dashboard route end

        Route::get('/upload-course', 'uploadCourse')->name('instructor.upload_course');

        Route::get('/playlist', 'playlist')->name('instructor.playlist');
        Route::get('/course-activity', 'courseActivity')->name('instructor.course_activity');

        Route::get('/financial-summary', 'financialSummary')->name('instructor.financial_summary');
        Route::get('/notification', 'notification')->name('instructor.notification');

        // Instructor setting
        Route::prefix('setting')->group(function () {
            Route::controller(SettingsController::class)->group(function () {
                Route::get('profile/{slug?}', 'setting')->name('instructor.setting');
                Route::post('/update-profile', 'updateProfile')->name('instructor.update_profile');
                Route::post('update-password', 'updatePassword')->name('instructor.update_password');

                Route::get('add-skills', 'addSkill')->name('instructor.add.skill');
                Route::post('store-skills', 'storeSkill')->name('instructor.store.skill');
            });

            // Instructor education
            Route::controller(EducationController::class)->group(function () {
                // add institute
                Route::get('add-institute', 'addInstitute')->name('instructor.addInstitute');
                Route::post('store-institute', 'storeInstitute')->name('instructor.store.institute');
                Route::get('edit-institute/{key}', 'editInstitute')->name('instructor.edit.institute');
                Route::post('update-institute/{key}', 'updateInstitute')->name('instructor.update.institute');
                Route::get('delete-institute/{key}', 'deleteInstitute')->name('instructor.delete.institute');
            });
            // Instructor education

            // Instructor experience
            Route::controller(ExperienceController::class)->group(function () {
                // add institute
                Route::get('add-experience', 'addExperience')->name('instructor.add.experience');
                Route::post('store-experience', 'storeExperience')->name('instructor.store.experience');
                Route::get('edit-experience/{key}', 'editExperience')->name('instructor.edit.experience');
                Route::post('update-experience/{key}', 'updateExperience')->name('instructor.update.experience');
                Route::get('delete-experience/{key}', 'deleteExperience')->name('instructor.delete.experience');
            });
            // Instructor experience

        });
    });
    // start course
    Route::controller(CourseController::class)->group(function () {

        Route::get('/my-courses', 'courses')->name('instructor.courses');
        Route::get('/add-course', 'addCourse')->name('instructor.add_course');
        Route::post('/store-course', 'storeCourse')->name('instructor.course.store');
        Route::get('/edit-course/{slug}', 'editCourse')->name('instructor.course.edit');
        Route::post('/update-course/{slug}', 'updateCourse')->name('instructor.course.update');
        Route::get('/delete-course/{id}', 'deleteCourse')->name('instructor.course.delete');

        Route::get('/support-course/{slug}', 'supportCourse')->name('instructor.course.support');
        // review
        Route::get('/course-review', 'courseReviews')->name('instructor.course_reviews');
        // enrollments
        Route::get('/enrolled-students', 'enrolledStudent')->name('instructor.enrolled_students');
        Route::get('/course-sales', 'sales')->name('instructor.course_sales');

    });
    // end course

    // start Book section
    Route::controller(BookController::class)->group(function () {
        Route::get('/my-books', 'books')->name('instructor.books');
        Route::get('/add-book', 'addBook')->name('instructor.add_book');
        Route::post('/store-book', 'storeBook')->name('instructor.book.store');
        Route::get('/edit-book/{slug}', 'editBook')->name('instructor.book.edit');
        Route::post('/update-book/{slug}', 'updateBook')->name('instructor.book.update');
        Route::get('/delete-book/{id}', 'deleteBook')->name('instructor.book.delete');
        Route::get('/view/book-short-file/{id}', 'shortFilePDFView')->name('instructor.book.short-file.view');
        Route::get('/view/book-full-file/{id}', 'fullFilePDFView')->name('instructor.book.full-file.view');
    });
    // end Book section





    // start course section
    Route::controller(SectionController::class)->group(function () {
        Route::get('/add-section/{slug}', 'create')->name('instructor.section.add');
        Route::post('/store-section/{slug}', 'store')->name('instructor.section.store');
        Route::get('/edit-section/{id}', 'edit')->name('instructor.section.edit');
        Route::post('/update-section/{id}', 'update')->name('instructor.section.update');
        Route::post('/sortable-section/{id}', 'sortable')->name('instructor.section.sortable');
        Route::get('/delete-section/{id}', 'destroy')->name('instructor.section.delete');
    });
    // end course section

    // start course lesson
    Route::controller(LessonController::class)->group(function () {
        Route::get('/add-lesson/{id}', 'create')->name('instructor.lesson.add');
        Route::post('/store-lesson/{id}', 'store')->name('instructor.lesson.store');
        Route::get('/edit-lesson/{id}', 'edit')->name('instructor.lesson.edit');
        Route::post('/update-lesson/{id}', 'update')->name('instructor.lesson.update');
        Route::post('/sortable-lesson/{id}', 'sortable')->name('instructor.lesson.sortable');
        Route::get('/delete-lesson/{id}', 'destroy')->name('instructor.lesson.delete');
    });
    // end course lesson

    // start course question
    Route::controller(QuestionController::class)->group(function () {
        Route::get('quiz-list', 'index')->name('instructor.quiz.index');
        Route::get('quiz/submission/{id}', 'submission')->name('instructor.quiz.submission');
        Route::get('quiz/view/{id}', 'view')->name('instructor.quiz.view');

        Route::get('/add-question/{id}', 'create')->name('instructor.question.add');
        Route::post('/store-question/{id}', 'store')->name('instructor.question.store');
        Route::get('/edit-question/{id}', 'edit')->name('instructor.question.edit');
        Route::post('/update-question/{id}', 'update')->name('instructor.question.update');
        Route::post('/sortable-question/{id}', 'sortable')->name('instructor.question.sortable');
        Route::get('/delete-question/{id}', 'destroy')->name('instructor.question.delete');
    });

    // start course assignment
    Route::controller(AssignmentController::class)->group(function () {
        Route::get('assignment-list', 'index')->name('instructor.assignment.index');
        Route::get('assignment/submission/{id}', 'submission')->name('instructor.assignment.submission');
        Route::get('assignment/review/{id}', 'review')->name('instructor.assignment.review');
        Route::post('assignment/marks/{id}', 'marks')->name('instructor.assignment.marks');
        Route::get('assignment/download/{assignment_id}', 'assignmentDownload')->name('instructor.assignment.download'); // assignment download
        Route::get('assignment/submission-download/{assignment_id}', 'assignmentSubmissionDownload')->name('instructor.assignment_submission.download'); // assignment submission download

        Route::get('assignment-view/{id}', 'view')->name('instructor.assignment.view');
        Route::get('/add-assignment/{id}', 'create')->name('instructor.assignment.add');
        Route::post('/store-assignment/{id}', 'store')->name('instructor.assignment.store');
        Route::get('/edit-assignment/{id}', 'edit')->name('instructor.assignment.edit');
        Route::post('/update-assignment/{id}', 'update')->name('instructor.assignment.update');
        Route::get('/delete-assignment/{id}', 'destroy')->name('instructor.assignment.delete');
        Route::get('course/assignment/{id}', 'ajaxAssignment')->name('ajax.instructor.course.assignment'); // course assignment ajax
    });
    // end course assignment

    // start course noticeboard
    Route::controller(NoticeBoardController::class)->group(function () {
        Route::get('/add-noticeboard/{id}', 'create')->name('instructor.noticeboard.add');
        Route::post('/store-noticeboard/{id}', 'store')->name('instructor.noticeboard.store');
        Route::get('/edit-noticeboard/{id}', 'edit')->name('instructor.noticeboard.edit');
        Route::post('/update-noticeboard/{id}', 'update')->name('instructor.noticeboard.update');
        Route::get('/delete-noticeboard/{id}', 'destroy')->name('instructor.noticeboard.delete');
        Route::get('course/noticeboard/{id}', 'ajaxNoticeBoard')->name('ajax.instructor.course.noticeboard'); // course assignment ajax
    });
    // end course noticeboard

    Route::controller(SupportController::class)->group(function () {
        Route::get('/add-support/{id}', 'create')->name('instructor.support.add');
        Route::post('/store-support/{id}', 'store')->name('instructor.support.store');
        Route::get('/edit-support/{id}', 'edit')->name('instructor.support.edit');
        Route::post('/update-support/{id}', 'update')->name('instructor.support.update');
        Route::get('/delete-support/{id}', 'destroy')->name('instructor.support.delete');

    });

    // start financial
    Route::prefix('financial')->group(function () {
        Route::controller(FinancialController::class)->group(function () {
            Route::get('/sales-report/course', 'salesReport')->name('instructor.sales_report.course');
            Route::get('sales-report/course/download', 'salesReportDownload')->name('instructor.sales_report.course.download');
            Route::get('/payouts', 'payoutsList')->name('instructor.payouts_list');
            Route::get('/payout-request', 'payoutRequest')->name('instructor.payout_request');
            Route::post('/payout-request', 'payoutRequestStore')->name('instructor.payout_request.store');
            Route::get('/payout-details/{id}', 'payoutDetails')->name('instructor.payout_details');

        });
        // end financial
        // start instructor payment method
        Route::controller(PaymentMethodController::class)->prefix('payment-settings')->group(function () {
            Route::get('/', 'payoutSettings')->name('instructor.payout_settings');
            Route::get('/add', 'create')->name('instructor.payment_method.add');
            Route::post('/store', 'store')->name('instructor.payment_method.store');
            Route::get('/edit/{id}', 'edit')->name('instructor.payment_method.edit');
            Route::post('/update/{id}', 'update')->name('instructor.payment_method.update');
            Route::get('/delete/{id}', 'destroy')->name('instructor.payment_method.delete');
        });
    });

    // ai support route
    Route::controller(AISupportController::class)->prefix('ai-support')->group(function () {
        Route::get('/', 'index')->name('instructor.ai_support');
        Route::post('/search', 'search')->name('instructor.ai_support.search');
    });

    Route::controller(InvoiceController::class)->prefix('invoice')->group(function () {
        Route::get('/instructor/view/{id}', 'instructorView')->name('instructor.invoice.view');
        Route::get('/download/{id}', 'download')->name('instructor.invoice.download');
    });

});
// End instructor Dashboard Related routes

Route::controller(InstructorController::class)->group(function () {
    Route::get('/instractors', 'index')->name('instractors');
    Route::get('/instructor-details', 'details')->name('instructorDetails');
});
