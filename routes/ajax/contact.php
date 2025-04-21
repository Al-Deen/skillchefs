<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ContactController;

Route::controller(ContactController::class)->prefix('web/v1/contact')->group(function () {
    Route::get('/get-in-touch',             'getInTouch')->name('contact.getInTouch');
    Route::get('/social-link',              'socialLink')->name('contact.socialLink');
    Route::get('/map',                      'map')->name('contact.map');
});