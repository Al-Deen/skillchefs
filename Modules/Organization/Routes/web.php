<?php

use Illuminate\Support\Facades\Route;
use Modules\Organization\Http\Controllers\AISupportController;
use Modules\Organization\Http\Controllers\AssignmentController;
use Modules\Organization\Http\Controllers\CourseController;
use Modules\Organization\Http\Controllers\EducationController;
use Modules\Organization\Http\Controllers\ExperienceController;
use Modules\Organization\Http\Controllers\FinancialController;
use Modules\Organization\Http\Controllers\InstructorController;
use Modules\Organization\Http\Controllers\InvoiceController;
use Modules\Organization\Http\Controllers\LessonController;
use Modules\Organization\Http\Controllers\NoticeBoardController;
use Modules\Organization\Http\Controllers\OrganizationController;
use Modules\Organization\Http\Controllers\OrganizationFrontController;
use Modules\Organization\Http\Controllers\OrganizationPanelController;
use Modules\Organization\Http\Controllers\PaymentMethodController;
use Modules\Organization\Http\Controllers\QuestionController;
use Modules\Organization\Http\Controllers\SectionController;
use Modules\Organization\Http\Controllers\SettingsController;

// Route::prefix('organization')->group(function() {
//     Route::get('/', 'OrganizationController@index');
// });

Route::prefix('organization')->middleware(['organization', 'auth'])->group(function () {
    Route::controller(OrganizationPanelController::class)->group(function () {
        Route::post('/logout', 'logout')->name('organization.logout');
    });
});
Route::prefix('organization')->middleware(['organization', 'auth', 'verified'])->group(function () {
    Route::controller(OrganizationPanelController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('organization.dashboard')->middleware('verified');
        Route::post('monthly-sales', 'monthlySales')->name('organization.monthly_sales');
        Route::get('/profile', 'profile')->name('organization.profile');

        // instructor list routes
        Route::prefix('instructor')->group(function () {
            Route::get('/', 'instructorIndex')->name('organization.instructor');
            Route::get('/add', 'instructorCreate')->name('organization.instructor.add');
            Route::post('/store', 'instructorStore')->name('organization.instructor.store');
            Route::get('/edit/{id}/{slug}', 'instructorEdit')->name('organization.instructor.edit');
            Route::post('/update-profile/{id}', 'updateInstructorProfile')->name('organization.instructor.update_profile');
            Route::post('/update-password/{id}', 'updateInstructorPassword')->name('organization.instructor.update_password');
            Route::get('/add-skills/{id}', 'addInstructorSkill')->name('organization.instructor.add.skill');
            Route::post('/store-skills/{id}', 'storeInstructorSkill')->name('organization.instructor.store.skill');
            Route::get('/approve/{id}', 'instructorApprove')->name('organization.instructor.approve');
            Route::get('/suspend/{id}', 'instructorSuspend')->name('organization.instructor.suspend');
            Route::get('/delete/{id}', 'instructorDelete')->name('organization.instructor.delete');
        });
    });
    // instructor list routes
    // Instructor education
    Route::controller(EducationController::class)->group(function () {
        // add institute
        Route::get('add-institute/{id}', 'addInstitute')->name('organization.instructor.addInstitute');
        Route::post('store-institute/{id}', 'storeInstitute')->name('organization.instructor.store.institute');
        Route::get('edit-institute/{key}/{id}', 'editInstitute')->name('organization.instructor.edit.institute');
        Route::post('update-institute/{key}/{id}', 'updateInstitute')->name('organization.instructor.update.institute');
        Route::get('delete-institute/{key}/{id}', 'deleteInstitute')->name('organization.instructor.delete.institute');
    });
    // Instructor education end
    // Instructor experience
    Route::controller(ExperienceController::class)->group(function () {
        // add institute
        Route::get('add-experience/{id}', 'addExperience')->name('organization.instructor.add.experience');
        Route::post('store-experience/{id}', 'storeExperience')->name('organization.instructor.store.experience');
        Route::get('edit-experience/{key}/{id}', 'editExperience')->name('organization.instructor.edit.experience');
        Route::post('update-experience/{key}/{id}', 'updateExperience')->name('organization.instructor.update.experience');
        Route::get('delete-experience/{key}/{id}', 'deleteExperience')->name('organization.instructor.delete.experience');
    });
    // Instructor experience end
    // instructor list routes end

    // organization setting
    Route::prefix('setting')->group(function () {
        Route::controller(SettingsController::class)->group(function () {
            Route::get('profile/{slug?}', 'setting')->name('organization.setting');
            Route::post('/update-profile', 'updateProfile')->name('organization.update_profile');
            Route::post('update-password', 'updatePassword')->name('organization.update_password');

            Route::get('add-skills', 'addSkill')->name('organization.add.skill');
            Route::post('store-skills', 'storeSkill')->name('organization.store.skill');
        });
    });

    // ai support route
    Route::controller(AISupportController::class)->prefix('ai-support')->group(function () {
        Route::get('/', 'index')->name('organization.ai_support');
        Route::post('/search', 'search')->name('organization.ai_support.search');
    });

    // start course
    Route::controller(CourseController::class)->group(function () {
        Route::get('/my-courses', 'courses')->name('organization.courses');
        Route::get('/add-course', 'addCourse')->name('organization.add_course');
        Route::post('/store-course', 'storeCourse')->name('organization.course.store');
        Route::get('/edit-course/{slug}', 'editCourse')->name('organization.course.edit');
        Route::post('/update-course/{slug}', 'updateCourse')->name('organization.course.update');
        Route::get('/delete-course/{id}', 'deleteCourse')->name('organization.course.delete');
        // review
        Route::get('/course-review', 'courseReviews')->name('organization.course_reviews');
        // enrollments
        Route::get('/enrolled-students', 'enrolledStudent')->name('organization.enrolled_students');
        Route::get('/course-sales', 'sales')->name('organization.course_sales');
    });
    // end course

    // start course section
    Route::controller(SectionController::class)->group(function () {
        Route::get('/add-section/{slug}', 'create')->name('organization.section.add');
        Route::post('/store-section/{slug}', 'store')->name('organization.section.store');
        Route::get('/edit-section/{id}', 'edit')->name('organization.section.edit');
        Route::post('/update-section/{id}', 'update')->name('organization.section.update');
        Route::post('/sortable-section/{id}', 'sortable')->name('organization.section.sortable');
        Route::get('/delete-section/{id}', 'destroy')->name('organization.section.delete');
    });
    // end course section

    // start course lesson
    Route::controller(LessonController::class)->group(function () {
        Route::get('/add-lesson/{id}', 'create')->name('organization.lesson.add');
        Route::post('/store-lesson/{id}', 'store')->name('organization.lesson.store');
        Route::get('/edit-lesson/{id}', 'edit')->name('organization.lesson.edit');
        Route::post('/update-lesson/{id}', 'update')->name('organization.lesson.update');
        Route::post('/sortable-lesson/{id}', 'sortable')->name('organization.lesson.sortable');
        Route::get('/delete-lesson/{id}', 'destroy')->name('organization.lesson.delete');
    });
    // end course lesson

    // start course question
    Route::controller(QuestionController::class)->group(function () {
        Route::get('quiz-list', 'index')->name('organization.quiz.index');
        Route::get('quiz/submission/{id}', 'submission')->name('organization.quiz.submission');
        Route::get('quiz/view/{id}', 'view')->name('organization.quiz.view');

        Route::get('/add-question/{id}', 'create')->name('organization.question.add');
        Route::post('/store-question/{id}', 'store')->name('organization.question.store');
        Route::get('/edit-question/{id}', 'edit')->name('organization.question.edit');
        Route::post('/update-question/{id}', 'update')->name('organization.question.update');
        Route::post('/sortable-question/{id}', 'sortable')->name('organization.question.sortable');
        Route::get('/delete-question/{id}', 'destroy')->name('organization.question.delete');
    });

    // start course assignment
    Route::controller(AssignmentController::class)->group(function () {
        Route::get('assignment-list', 'index')->name('organization.assignment.index');
        Route::get('assignment/submission/{id}', 'submission')->name('organization.assignment.submission');
        Route::get('assignment/review/{id}', 'review')->name('organization.assignment.review');
        Route::post('assignment/marks/{id}', 'marks')->name('organization.assignment.marks');
        Route::get('assignment/download/{assignment_id}', 'assignmentDownload')->name('organization.assignment.download'); // assignment download
        Route::get('assignment/submission-download/{assignment_id}', 'assignmentSubmissionDownload')->name('organization.assignment_submission.download'); // assignment submission download

        Route::get('assignment-view/{id}', 'view')->name('organization.assignment.view');
        Route::get('/add-assignment/{id}', 'create')->name('organization.assignment.add');
        Route::post('/store-assignment/{id}', 'store')->name('organization.assignment.store');
        Route::get('/edit-assignment/{id}', 'edit')->name('organization.assignment.edit');
        Route::post('/update-assignment/{id}', 'update')->name('organization.assignment.update');
        Route::get('/delete-assignment/{id}', 'destroy')->name('organization.assignment.delete');
        Route::get('course/assignment/{id}', 'ajaxAssignment')->name('ajax.organization.course.assignment'); // course assignment ajax
    });
    // end course assignment

    // start course noticeboard
    Route::controller(NoticeBoardController::class)->group(function () {
        Route::get('/add-noticeboard/{id}', 'create')->name('organization.noticeboard.add');
        Route::post('/store-noticeboard/{id}', 'store')->name('organization.noticeboard.store');
        Route::get('/edit-noticeboard/{id}', 'edit')->name('organization.noticeboard.edit');
        Route::post('/update-noticeboard/{id}', 'update')->name('organization.noticeboard.update');
        Route::get('/delete-noticeboard/{id}', 'destroy')->name('organization.noticeboard.delete');
        Route::get('course/noticeboard/{id}', 'ajaxNoticeBoard')->name('ajax.organization.course.noticeboard'); // course assignment ajax
    });
    // end course noticeboard

    // start financial
    Route::prefix('financial')->group(function () {
        Route::controller(FinancialController::class)->group(function () {
            Route::get('/sales-report/course', 'salesReport')->name('organization.sales_report.course');
            Route::get('sales-report/course/download', 'salesReportDownload')->name('organization.sales_report.course.download');
            Route::get('/payouts', 'payoutsList')->name('organization.payouts_list');
            Route::get('/payout-request', 'payoutRequest')->name('organization.payout_request');
            Route::post('/payout-request', 'payoutRequestStore')->name('organization.payout_request.store');
            Route::get('/payout-details/{id}', 'payoutDetails')->name('organization.payout_details');

        });
        // end financial
        // start organization payment method
        Route::controller(PaymentMethodController::class)->prefix('payment-settings')->group(function () {
            Route::get('/', 'payoutSettings')->name('organization.payout_settings');
            Route::get('/add', 'create')->name('organization.payment_method.add');
            Route::post('/store', 'store')->name('organization.payment_method.store');
            Route::get('/edit/{id}', 'edit')->name('organization.payment_method.edit');
            Route::post('/update/{id}', 'update')->name('organization.payment_method.update');
            Route::get('/delete/{id}', 'destroy')->name('organization.payment_method.delete');
        });
    });

    Route::controller(InvoiceController::class)->prefix('invoice')->group(function () {
        Route::get('/organization/view/{id}', 'organizationView')->name('organization.invoice.view');
        Route::get('/download/{id}', 'download')->name('organization.invoice.download');
    });
});

// instructor routes
Route::prefix('instructor')->middleware(['instructor', 'auth', 'verified'])->group(function () {
    Route::controller(InstructorController::class)->group(function () {
        Route::prefix('organization')->group(function () {
            Route::get('/courses', 'index')->name('instructor.organization.courses');
        });
    });
});

// admin settings routes
Route::prefix('admin')->middleware(['auth.routes'])->group(function () {
    Route::controller(OrganizationController::class)->group(function () {
        // organization routes
        Route::prefix('organization')->group(function () {
            Route::get('/requests', 'requestIndex')->name('organization.admin.requests')->middleware('PermissionCheck:organization_request_list');
            Route::get('/suspended', 'suspendIndex')->name('organization.admin.suspends')->middleware('PermissionCheck:organization_suspend_list');
            Route::get('/', 'index')->name('organization.admin.index')->middleware('PermissionCheck:organization_read');
            Route::get('/create', 'create')->name('organization.admin.create')->middleware('PermissionCheck:organization_create');
            Route::post('/store', 'store')->name('organization.admin.store')->middleware('PermissionCheck:organization_store');
            Route::get('/login/{id}', 'login')->name('admin.organization.login')->middleware('PermissionCheck:organization_login');

            Route::get('/edit/{id}/{slug}', 'edit')->name('organization.admin.edit')->middleware('PermissionCheck:organization_update');
            Route::post('/update/{id}/{slug}', 'update')->name('organization.admin.update')->middleware('PermissionCheck:organization_update');

            Route::get('/approve/{id}', 'approve')->name('organization.admin.approve')->middleware('PermissionCheck:organization_approve');
            Route::get('/suspend/{id}', 'suspend')->name('organization.admin.suspend')->middleware('PermissionCheck:organization_suspend');
            Route::get('/re-activate/{id}', 'reActivate')->name('organization.admin.re_activate')->middleware('PermissionCheck:organization_re_activate');
            Route::get('/delete/{id}', 'destroy')->name('organization.admin.destroy')->middleware('PermissionCheck:organization_delete');

            Route::get('add-skill/{id}', 'addSkill')->name('organization.admin.add.skill')->middleware('PermissionCheck:organization_add_skill');
            Route::post('store-skill/{id}', 'storeSkill')->name('organization.admin.store.skill')->middleware('PermissionCheck:organization_store_skill');
        });
    });
});

// frontend
Route::controller(OrganizationFrontController::class)->prefix('organization')->group(function () {
    Route::get('details/{name}/{id}', 'details')->name('frontend.organization.details');
    Route::get('/become-organization', 'becomeOrganization')->name('frontend.organization.create');
    Route::post('/organization-store', 'signUp')->name('frontend.organization.store');
});
// frontend end
