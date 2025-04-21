<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CartController;


Route::controller(CartController::class)->prefix('web/v1/cart')->group(function () {
    Route::get('/breadcrumb',                       'breadcrumb')->name('cart.breadcrumb');
    Route::get('/shopping-cart',                    'shoppingCart')->name('cart.shoppingCart');
    Route::get('/recommended-courses',              'recommendedCourses')->name('cart.recommendedCourses');
});
