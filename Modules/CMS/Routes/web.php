<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\DiscountCourseController;
use Modules\CMS\Http\Controllers\FeaturedCourseController;
use Modules\CMS\Http\Controllers\FooterMenuController;
use Modules\CMS\Http\Controllers\HomeSectionController;
use Modules\CMS\Http\Controllers\TestimonialController;

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

    // Start pages  Routes
    Route::controller(HomeSectionController::class)->prefix('home-section-setting')->group(function () {
        Route::get('/', 'index')->name('home_section.setting.index')->middleware('PermissionCheck:home_section_settings_read');
        Route::get('/app', 'appHomeSection')->name('app_home_section.setting.index')->middleware('PermissionCheck:home_section_settings_read');
        Route::get('/create/{type}', 'create')->name('home_section.setting.create')->middleware('PermissionCheck:home_section_settings_create');
        Route::post('/store/{type}', 'store')->name('home_section.setting.store')->middleware('PermissionCheck:home_section_settings_store');
        Route::get('/edit/{id}', 'edit')->name('home_section.setting.edit')->middleware('PermissionCheck:home_section_settings_update');
        Route::post('/update/{id}', 'update')->name('home_section.setting.update')->middleware('PermissionCheck:home_section_settings_update');
        Route::get('/delete/{id}', 'destroy')->name('home_section.setting.delete')->middleware('PermissionCheck:home_section_settings_delete');
    });
    // End pages Routes

    // footer menu Routes start
    Route::controller(FooterMenuController::class)->prefix('footer-menu')->group(function () {
        Route::get('/', 'index')->name('footer-menu.index')->middleware('PermissionCheck:footer_menu_read');
        Route::get('/create', 'create')->name('footer-menu.create')->middleware('PermissionCheck:footer_menu_create');
        Route::post('/store', 'store')->name('footer-menu.store')->middleware('PermissionCheck:footer_menu_store');
        Route::get('/edit/{id}', 'edit')->name('footer-menu.edit')->middleware('PermissionCheck:footer_menu_update');
        Route::post('/update/{id}', 'update')->name('footer-menu.update')->middleware('PermissionCheck:footer_menu_update');
        Route::get('/delete/{id}', 'destroy')->name('footer-menu.destroy')->middleware('PermissionCheck:footer_menu_delete');
    });
    Route::controller(FooterMenuLinkController::class)->prefix('footer-menu-link')->group(function () {
        Route::get('/create/{footer_menu_id}', 'create')->name('footer-menu-link.create')->middleware('PermissionCheck:footer_menu_create');
        Route::post('/store/{footer_menu_id}', 'store')->name('footer-menu-link.store')->middleware('PermissionCheck:footer_menu_store');
        Route::get('/edit/{footer_menu_id}/{id}', 'edit')->name('footer-menu-link.edit')->middleware('PermissionCheck:footer_menu_update');
        Route::post('/update/{footer_menu_id}/{id}', 'update')->name('footer-menu-link.update')->middleware('PermissionCheck:footer_menu_update');
        Route::get('/delete/{footer_menu_id}/{id}', 'destroy')->name('footer-menu-link.destroy')->middleware('PermissionCheck:footer_menu_delete');
    });
    // footer menu Routes end

    // testimonial Routes start
    Route::controller(TestimonialController::class)->prefix('testimonial')->group(function () {
        Route::get('/', 'index')->name('admin.testimonial.index')->middleware('PermissionCheck:testimonial_read');
        Route::get('/create', 'create')->name('admin.testimonial.create')->middleware('PermissionCheck:testimonial_create');
        Route::post('/store', 'store')->name('admin.testimonial.store')->middleware('PermissionCheck:testimonial_store');
        Route::get('/edit/{id}', 'edit')->name('admin.testimonial.edit')->middleware('PermissionCheck:testimonial_update');
        Route::post('/update/{id}', 'update')->name('admin.testimonial.update')->middleware('PermissionCheck:testimonial_update');
        Route::get('/delete/{id}', 'destroy')->name('admin.testimonial.destroy')->middleware('PermissionCheck:testimonial_delete');
    });

    // featured course Routes start
    Route::controller(FeaturedCourseController::class)->prefix('featured-course')->group(function () {
        Route::get('/', 'index')->name('admin.featured-course.index')->middleware('PermissionCheck:featured_course_list');
        Route::get('/create', 'create')->name('admin.featured-course.create')->middleware('PermissionCheck:featured_course_create');
        Route::post('/select/course', 'selectCourse')->name('admin.featured-course.select')->middleware('PermissionCheck:featured_course_create');
        Route::post('/store', 'store')->name('admin.featured-course.store')->middleware('PermissionCheck:featured_course_store');        
        Route::get('/edit/{id}', 'edit')->name('admin.featured-course.edit')->middleware('PermissionCheck:featured_course_update');
        Route::post('/update/{id}', 'update')->name('admin.featured-course.update')->middleware('PermissionCheck:featured_course_update');
        Route::get('/delete/{id}', 'destroy')->name('admin.featured-course.destroy')->middleware('PermissionCheck:featured_course_delete');
    });

    // discount course Routes start
    Route::controller(DiscountCourseController::class)->prefix('discount-course')->group(function () {
        Route::get('/', 'index')->name('admin.discount-course.index')->middleware('PermissionCheck:discount_course_list');
        Route::get('/create', 'create')->name('admin.discount-course.create')->middleware('PermissionCheck:discount_course_create');
        Route::post('/select/course', 'selectCourse')->name('admin.discount-course.select')->middleware('PermissionCheck:discount_course_create');
        Route::post('/store', 'store')->name('admin.discount-course.store')->middleware('PermissionCheck:discount_course_store');
        Route::get('/edit/{id}', 'edit')->name('admin.discount-course.edit')->middleware('PermissionCheck:discount_course_update');
        Route::post('/update/{id}', 'update')->name('admin.discount-course.update')->middleware('PermissionCheck:discount_course_update');
        Route::get('/delete/{id}', 'destroy')->name('admin.discount-course.destroy')->middleware('PermissionCheck:discount_course_delete');
    });
    // discount course Routes end


    // Start image gallery Routes
    Route::controller(ImageGalleryController::class)->prefix('image-gallery')->group(function () {
        Route::get('/', 'index')->name('admin.image_gallery.index')->middleware('PermissionCheck:image_gallery_read');
        Route::get('/edit/{id}', 'edit')->name('admin.image_gallery.edit')->middleware('PermissionCheck:image_gallery_update');
        Route::post('/update/{id}', 'update')->name('admin.image_gallery.update')->middleware('PermissionCheck:image_gallery_update');
    });

});
