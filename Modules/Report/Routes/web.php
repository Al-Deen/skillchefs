<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ReportController;

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

Route::prefix('admin/report')->middleware(['auth.routes'])->group(function () {

    Route::controller(ReportController::class)->group(function () {

        Route::get('student-engagement', 'studentEngagement')->name('report.student-engagement')->middleware('PermissionCheck:report_student_engagement');
        Route::get('student-engagement/export', 'studentEngagementExport')->name('report.student-engagement.export')->middleware('PermissionCheck:report_student_engagement_export');

        Route::get('instructor-engagement', 'instructorEngagement')->name('report.instructor-engagement')->middleware('PermissionCheck:report_instructor_engagement');
        Route::get('instructor-engagement/export', 'instructorEngagementExport')->name('report.instructor-engagement.export')->middleware('PermissionCheck:report_instructor_engagement_export');

        Route::get('purchase-history', 'purchaseHistory')->name('report.purchase-history')->middleware('PermissionCheck:report_purchase_history');
        Route::get('purchase-history/export', 'purchaseHistoryExport')->name('report.purchase-history.export')->middleware('PermissionCheck:report_purchase_history_export');

        Route::get('course-completion', 'courseCompletion')->name('report.course-completion')->middleware('PermissionCheck:report_course_completion');
        Route::get('course-completion/export', 'courseCompletionExport')->name('report.course-completion.export')->middleware('PermissionCheck:report_course_completion_export');

        Route::get('student-performance', 'studentPerformance')->name('report.student-performance')->middleware('PermissionCheck:report_student_performance');
        Route::get('student-performance/export', 'studentPerformanceExport')->name('report.student-performance.export')->middleware('PermissionCheck:report_student_performance_export');

        Route::get('transaction', 'transaction')->name('report.admin_transaction')->middleware('PermissionCheck:report_admin_transaction');
        Route::get('transaction/export', 'transactionExport')->name('report.admin_transaction.export')->middleware('PermissionCheck:report_admin_transaction_export');

    });

});
