<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CourseController;


Route::controller(CourseController::class)->prefix('web/v1/courses')->group(function () {
    Route::get('/breadcrumb',                       'breadcrumb')->name('courses.breadcrumb');
    Route::get('/course-list',                      'courseList')->name('courses.courseList');
});
