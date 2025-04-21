<?php

use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Controllers\EventAdminController;
use Modules\Event\Http\Controllers\EventCategoryController;
use Modules\Event\Http\Controllers\EventCheckoutController;
use Modules\Event\Http\Controllers\EventController;
use Modules\Event\Http\Controllers\EventHomeController;
use Modules\Event\Http\Controllers\EventInvoiceController;
use Modules\Event\Http\Controllers\EventReportController;
use Modules\Event\Http\Controllers\EventScheduleController;
use Modules\Event\Http\Controllers\OrganizerController;
use Modules\Event\Http\Controllers\SpeakerController;
use Modules\Event\Http\Controllers\StudentEventController;
use Modules\Event\Http\Controllers\EventFinancialController;
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

// Frontend
Route::prefix('event')->group(function () {
    Route::get('details/{slug}', [EventHomeController::class, 'show'])->name('event.home.details');
});
// start subscription checkout
Route::controller(EventCheckoutController::class)->prefix('event/checkout')->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('frontend.event.checkout.index');
    Route::get('join-event', 'joinEvent')->name('frontend.event.join.event');
    Route::post('payment', 'payment')->name('frontend.event.checkout.payment');
});

// Home
Route::controller(EventHomeController::class)->group(function () {
    Route::get('event', 'eventList')->name('event.home.event.list');
    Route::get('ajax-event-list', 'ajaxEventList')->name('event_ajax.event.list');
    Route::get('ajax-event-home', 'ajaxHomeEvent')->name('event.home.ajax.event.list');
});

// Admin Panel Routes
Route::prefix('admin/event')->middleware(['auth.routes'])->group(function () {
    // Start Event Routes
    Route::prefix('manage')->group(function () {
        Route::get('/', [EventAdminController::class, 'index'])->name('event.admin.manage.index')->middleware('PermissionCheck:event_manage_read');
        Route::get('/delete/{id}', [EventAdminController::class, 'destroy'])->name('event.admin.manage.destroy')->middleware('PermissionCheck:event_manage_delete');
        Route::get('/swipe-featured/{id}', [EventAdminController::class, 'swipeFeatured'])->name('event.admin.manage.swipeFeatured')->middleware('PermissionCheck:event_manage_featured_manage');
        Route::get('/swipe-status/{id}', [EventAdminController::class, 'swipeActive'])->name('event.admin.manage.swipeActive')->middleware('PermissionCheck:event_manage_status_manage');
        Route::controller(EventAdminController::class)->group(function () {
            // course approval routes
            Route::get('/requested', 'requestedIndex')->name('event.admin.requested_event')->middleware('PermissionCheck:requested_event_list');
            Route::get('/approved', 'approvedIndex')->name('event.admin.approved_event')->middleware('PermissionCheck:approved_event_list');
            Route::get('/rejected', 'rejectedIndex')->name('event.admin.rejected_event')->middleware('PermissionCheck:rejected_event_list');
            Route::get('/approve/{course_id}', 'approve')->name('event.admin.approve')->middleware('PermissionCheck:event_approve');
            Route::get('/reject/{course_id}', 'reject')->name('event.admin.reject')->middleware('PermissionCheck:event_reject');

            Route::get('/create', 'create')->name('event.admin.create')->middleware('PermissionCheck:event_create');
            Route::post('/store', 'store')->name('event.admin.store')->middleware('PermissionCheck:event_store');
            Route::get('/edit/{id}/detail', 'edit')->name('event.admin.edit')->middleware('PermissionCheck:event_update');
            Route::post('/update/{id}/detail', 'update')->name('event.admin.update')->middleware('PermissionCheck:event_update');
            Route::get('/delete/{id}', 'destroy')->name('event.admin.destroy')->middleware('PermissionCheck:event_delete');

            // speaker add from event edit
            Route::get('/index/{id}/speakers', 'speakerTab')->name('event.admin.speaker.index')->middleware('PermissionCheck:event_update');
            Route::get('/create/{id}/speakers', 'createSpeaker')->name('event.admin.speaker.create')->middleware('PermissionCheck:event_update');
            Route::post('/store/{id}/speakers', 'storeSpeaker')->name('event.admin.speaker.store')->middleware('PermissionCheck:event_update');
            Route::get('/edit/{id}/speakers', 'editSpeaker')->name('event.admin.speaker.edit')->middleware('PermissionCheck:event_update');
            Route::post('/update/{id}/speakers', 'updateSpeaker')->name('event.admin.speaker.update')->middleware('PermissionCheck:event_update');
            Route::get('/delete/{id}/speakers', 'destroySpeaker')->name('event.admin.speaker.destroy')->middleware('PermissionCheck:event_delete');

            // organizer add from event edit
            Route::get('/index/{id}/organizers', 'organizerTab')->name('event.admin.organizer.index')->middleware('PermissionCheck:event_update');
            Route::get('/create/{id}/organizers', 'createOrganizer')->name('event.admin.organizer.create')->middleware('PermissionCheck:event_update');
            Route::post('/store/{id}/organizers', 'storeOrganizer')->name('event.admin.organizer.store')->middleware('PermissionCheck:event_update');
            Route::get('/edit/{id}/organizers', 'editOrganizer')->name('event.admin.organizer.edit')->middleware('PermissionCheck:event_update');
            Route::post('/update/{id}/organizers', 'updateOrganizer')->name('event.admin.organizer.update')->middleware('PermissionCheck:event_update');
            Route::get('/delete/{id}/organizers', 'destroyOrganizer')->name('event.admin.organizer.destroy')->middleware('PermissionCheck:event_delete');

            // schedules add from event edit
            Route::get('/index/{id}/schedules', 'scheduleTab')->name('event.admin.schedule.index')->middleware('PermissionCheck:event_update');
            Route::get('/create/{id}/schedules', 'createSchedule')->name('event.admin.schedule.create')->middleware('PermissionCheck:event_update');
            Route::post('/store/{id}/schedules', 'storeSchedule')->name('event.admin.schedule.store')->middleware('PermissionCheck:event_update');
            Route::get('/edit/{id}/schedules', 'editSchedule')->name('event.admin.schedule.edit')->middleware('PermissionCheck:event_update');
            Route::post('/update/{id}/schedules', 'updateSchedule')->name('event.admin.schedule.update')->middleware('PermissionCheck:event_update');
            Route::get('/delete/{id}/schedules', 'destroySchedule')->name('event.admin.schedule.destroy')->middleware('PermissionCheck:event_delete');

            // schedule timeline add from event edit
            Route::get('/index/{id}/schedules_timeline', 'scheduleTimelineTab')->name('event.admin.schedules_timeline.index')->middleware('PermissionCheck:event_update');
            Route::get('/create/{id}/schedules_timeline', 'createScheduleTimeline')->name('event.admin.schedules_timeline.create')->middleware('PermissionCheck:event_update');
            Route::post('/store/{id}/schedules_timeline', 'storeScheduleTimeline')->name('event.admin.schedules_timeline.store')->middleware('PermissionCheck:event_update');
            Route::get('/edit/{id}/schedules_timeline', 'editScheduleTimeline')->name('event.admin.schedules_timeline.edit')->middleware('PermissionCheck:event_update');
            Route::post('/update/{id}/schedules_timeline', 'updateScheduleTimeline')->name('event.admin.schedules_timeline.update')->middleware('PermissionCheck:event_update');
            Route::get('/delete/{id}/schedules_timeline', 'destroyScheduleTimeline')->name('event.admin.schedules_timeline.destroy')->middleware('PermissionCheck:event_delete');

            Route::get('/purchase_booking', 'purchaseBookingIndex')->name('event.admin.purchase_booking')->middleware('PermissionCheck:purchase_booking');
            Route::get('/purchase_booking/participants/{id}', 'participantsIndex')->name('event.admin.purchase_booking.participants')->middleware('PermissionCheck:purchase_booking');
            Route::get('/purchase_booking/participants/invoice/{id}', 'participantsInvoice')->name('event.admin.purchase_booking.participants_invoice')->middleware('PermissionCheck:purchase_booking');
        });
        // End Event Routes
        // Start Event Category Routes
        Route::prefix('category')->group(function () {
            Route::get('/', [EventCategoryController::class, 'index'])->name('event.category.index')->middleware('PermissionCheck:event_category_read');
            Route::get('/create', [EventCategoryController::class, 'create'])->name('event.category.create')->middleware('PermissionCheck:event_category_create');
            Route::post('/store', [EventCategoryController::class, 'store'])->name('event.category.store')->middleware('PermissionCheck:event_category_store');
            Route::get('/edit/{id}', [EventCategoryController::class, 'edit'])->name('event.category.edit')->middleware('PermissionCheck:event_category_update');
            Route::post('/update/{id}', [EventCategoryController::class, 'update'])->name('event.category.update')->middleware('PermissionCheck:event_category_update');
            Route::get('/delete/{id}', [EventCategoryController::class, 'destroy'])->name('event.category.destroy')->middleware('PermissionCheck:event_category_delete');
        });
        // End Event Category Routes
    });
});
Route::prefix('admin/report')->middleware(['auth.routes'])->group(function () {
    Route::controller(EventReportController::class)->group(function () {
        Route::get('event-booking', 'eventBookingIndex')->name('report.event-booking')->middleware('PermissionCheck:report_event_booking');
        Route::get('event-booking/export', 'eventBookingExport')->name('report.event-booking.export')->middleware('PermissionCheck:report_event_booking_export');
    });
});

// student routes
Route::prefix('student')->middleware(['student', 'auth', 'verified'])->group(function () {
    Route::controller(StudentEventController::class)->group(function () {
        Route::get('/event', 'index')->name('student.event');
        Route::get('/event/details/{id}', 'details')->name('student.event.details.view');
    });
    Route::controller(EventInvoiceController::class)->prefix('event/invoice')->group(function () {
        Route::get('/view/{id}', 'studentInvoice')->name('event.student.invoice.view');
    });
});

// Organization Panel Routes
Route::prefix('panel/event')->middleware(['org.ins', 'auth', 'verified'])->group(function () {
    // Start Event Routes
    Route::get('/', [EventController::class, 'index'])->name('instructor.event.index');
    Route::get('/create', [EventController::class, 'create'])->name('instructor.event.create');
    Route::post('/store', [EventController::class, 'store'])->name('instructor.event.store');
    Route::get('/edit/{id}', [EventController::class, 'edit'])->name('instructor.event.edit');
    Route::post('/update/{id}', [EventController::class, 'update'])->name('instructor.event.update');
    Route::get('/delete/{id}', [EventController::class, 'destroy'])->name('instructor.event.destroy');
    Route::get('/registered', [EventController::class, 'registered'])->name('instructor.event.registered');
    Route::get('/registered/details/{id}', [EventController::class, 'registeredDetails'])->name('instructor.event.registered.details.view');
    // End Event Routes

    Route::prefix('speakers')->group(function () {
        Route::get('/{id}', [SpeakerController::class, 'index'])->name('instructor.event.speaker.index');
        Route::get('/create/{id}', [SpeakerController::class, 'create'])->name('instructor.event.speaker.create');
        Route::post('/store/{id}', [SpeakerController::class, 'store'])->name('instructor.event.speaker.store');
        Route::get('/edit/{id}', [SpeakerController::class, 'edit'])->name('instructor.event.speaker.edit');
        Route::post('/update/{id}', [SpeakerController::class, 'update'])->name('instructor.event.speaker.update');
        Route::get('/delete/{id}', [SpeakerController::class, 'destroy'])->name('instructor.event.speaker.destroy');
    });

    Route::prefix('organizers')->group(function () {
        Route::get('/{id}', [OrganizerController::class, 'index'])->name('instructor.event.organizer.index');
        Route::get('/create/{id}', [OrganizerController::class, 'create'])->name('instructor.event.organizer.create');
        Route::post('/store/{id}', [OrganizerController::class, 'store'])->name('instructor.event.organizer.store');
        Route::get('/edit/{id}', [OrganizerController::class, 'edit'])->name('instructor.event.organizer.edit');
        Route::post('/update/{id}', [OrganizerController::class, 'update'])->name('instructor.event.organizer.update');
        Route::get('/delete/{id}', [OrganizerController::class, 'destroy'])->name('instructor.event.organizer.destroy');
    });

    Route::prefix('schedule')->group(function () {
        // Start Schedule Routes
        Route::get('/list/{id}', [EventScheduleController::class, 'index'])->name('event.instructor.schedule.index');
        Route::get('/create/{id}', [EventScheduleController::class, 'create'])->name('event.instructor.schedule.create');
        Route::post('/store/{id}', [EventScheduleController::class, 'store'])->name('event.instructor.schedule.store');
        Route::get('/edit/{id}', [EventScheduleController::class, 'edit'])->name('event.instructor.schedule.edit');
        Route::post('/update/{id}', [EventScheduleController::class, 'update'])->name('event.instructor.schedule.update');
        Route::get('/delete/{id}', [EventScheduleController::class, 'destroy'])->name('event.instructor.schedule.destroy');
        // End Schedule Routes

        // Start Schedule List Routes
        Route::get('/create/list/{id}', [EventScheduleController::class, 'listCreate'])->name('event.instructor.schedule.list.create');
        Route::post('/store/list/{id}', [EventScheduleController::class, 'listStore'])->name('event.instructor.schedule.list.store');
        Route::get('/edit/list/{id}', [EventScheduleController::class, 'listEdit'])->name('event.instructor.schedule.list.edit');
        Route::post('/update/list/{id}', [EventScheduleController::class, 'listUpdate'])->name('event.instructor.schedule.list.update');
        Route::get('/delete/list/{id}', [EventScheduleController::class, 'listDestroy'])->name('event.instructor.schedule.list.destroy');
        Route::get('/view/list/{id}', [EventScheduleController::class, 'listView'])->name('event.instructor.schedule.list.view');
        // End Schedule List Routes
    });
    Route::controller(EventInvoiceController::class)->prefix('invoice')->group(function () {
        Route::get('/view/{id}', 'instructorInvoice')->name('event.instructor.invoice.view');
    });

    // event financial report routes
    Route::prefix('financial')->group(function () {
        Route::controller(EventFinancialController::class)->group(function () {
            Route::get('/sales-report/event', 'salesReport')->name('instructor.sales_report.event');
            Route::get('sales-report/event/download', 'salesReportDownload')->name('instructor.sales_report.event.download');
        });
    });

});
