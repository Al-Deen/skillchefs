<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\Guest\HomeController;
use App\Http\Controllers\Api\V1\ApiFrontendController;
use App\Http\Controllers\Api\V1\Guest\CourseController;
use App\Http\Controllers\Api\V1\Student\CartController;
use App\Http\Controllers\Api\V1\Student\AboutController;
use App\Http\Controllers\Api\V1\Student\CheckoutController;
use App\Http\Controllers\Api\V1\Student\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group( function () {
    Route::get('/user', [AuthController::class, 'user']);
});

//  start home api
Route::middleware(['auth:sanctum'])->controller(HomeController::class)->prefix('v1')->group(function () {
    Route::get('/home',                                       'index');
    Route::get('/slider/{id}/details',                        'sliderDetails');
});

Route::controller(CartController::class)->prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/carts',                                        'index')->name('cart.api.list');
    Route::post('/cart/store',                                  'store')->name('cart.api.store');
    Route::post('/cart/destroy',                                'destroy')->name('cart.api.delete');
});

Route::controller(CheckoutController::class)->prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/carts/checkout',                               'checkout')->name('cart.api.checkout');
});

Route::controller(AboutController::class)->prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/about-us',                                        'index')->name('page.api.about');
});

//  end home api




include_route_files(__DIR__ . '/ajax/');
include_route_files(__DIR__ . '/api/');
