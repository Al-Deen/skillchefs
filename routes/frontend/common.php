<?php

use App\Http\Controllers\Frontend\BookmarkController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SelectController;
use Illuminate\Support\Facades\Route;

Route::prefix('frontend')->middleware(['auth'])->group(function () {

    // start bookmark
    Route::controller(BookmarkController::class)->group(function () {
        Route::get('bookmark', 'bookmark')->name('frontend.bookmark'); // student course
        Route::get('bookmark/remove/{course_id}', 'bookmarkRemove'); // student course
        Route::get('bookmark/added/{course_id}', 'bookmarkStore'); // student course
    });
    // end bookmark

});

// select data by ajax
Route::post('ajax-instructor-list', [SelectController::class, 'instructorList'])->name('ajax-instructor-list');
Route::post('ajax-categories-list', [SelectController::class, 'categoriesList'])->name('ajax-categories-list');

// change language
Route::post('change-language', [SelectController::class, 'changeLanguage'])->name('change-language');

// start share profile
Route::get('in/{username}', [ProfileController::class, 'profile'])->name('share.profile');
