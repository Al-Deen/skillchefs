<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\CourseDetailsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\InstructorController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\SelectController;
use Illuminate\Support\Facades\Route;

// start sign inz

Route::get('/', [HomeController::class, 'index'])->name('home');

// start courses
Route::get('/courses', [CourseController::class, 'index'])->name('courses');
// filter courses
Route::get('courses/filter', [CourseController::class, 'filterCourse']);
// end courses
// start search
Route::get('search', [CourseController::class, 'searchFilter'])->name('frontend.search');
// end search
// start category
Route::get('category', [CourseController::class, 'category'])->name('frontend.category');
// end category
Route::get('/certificate', [HomeController::class, 'certificateView'])->name('front.certificateView');
Route::get('/certificate-tracking', [HomeController::class, 'certificateTrack'])->name('front.certificate');
// start course details
Route::get('course-details/{slug}', [CourseDetailsController::class, 'index'])->name('frontend.courseDetails');
// end course details

// start course cart add
Route::controller(CartController::class)->prefix('cart')->group(function () {
    Route::get('/', 'index')->name('cart.index');
    Route::get('add', 'add')->name('cart.add');
    Route::get('remove/{id}', 'remove')->name('cart.remove')->middleware('auth');
});
// end course cart add

// start course checkout
Route::controller(CheckoutController::class)->prefix('checkout')->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('checkout.index');
    Route::post('payment', 'payment')->name('checkout.payment');
});

// end course checkout

Route::controller(PaymentController::class)->prefix('payments')->group(function () {
    Route::get('verify/{method}', 'verify')->name('payment.verify');
    Route::post('verify/{method}', 'verify')->name('payment.verifyPost');
    Route::get('status', 'status')->name('payment.status');
});

Route::controller(PaymentController::class)->prefix('package_payments')->group(function () {
    Route::get('verify/{method}', 'packageVerify')->name('payment.package_verify');
    Route::post('verify/{method}', 'packageVerify')->name('payment.package_verifyPost');
    Route::get('status', 'packageStatus')->name('payment.package_status');
});

Route::controller(PaymentController::class)->prefix('event_payments')->group(function () {
    Route::get('verify/{method}', 'eventVerify')->name('payment.event_verify');
    Route::post('verify/{method}', 'eventVerify')->name('payment.event_verifyPost');
    Route::get('status', 'eventStatus')->name('payment.event_status');
});

// start select list
Route::controller(SelectController::class)->prefix('select')->group(function () {
    Route::post('country-list', 'countryList');
});

// end select list

// Route::post('checkout',            [CheckoutController::class,'store'])->name('frontend.checkout.store');

// end course cart add

Route::get('/course-details', [CourseDetailsController::class, 'index'])->name('courseDetails');

Route::controller(ContactController::class)->prefix('contact')->group(function () {
    Route::get('/us', 'index')->name('frontend.contact_us');
    Route::post('/', 'store')->name('frontend.contact_us.store');
});
Route::controller(PageController::class)->group(function () {
    Route::get('/page/{slug}', 'page')->name('frontend.page.link');
    Route::get('/about-us', 'aboutUs')->name('frontend.about_us');
    Route::get('/privacy-policy', 'privacyPolicy')->name('frontend.privacy_policy');
    Route::get('/terms-conditions', 'termsConditions')->name('frontend.terms_and_conditions');
});

//Blog related routes
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/{id}/details', [BlogController::class, 'details'])->name('blog_details');
//Blog related routes

// start instructor
Route::controller(InstructorController::class)->prefix('instructor')->group(function () {
    Route::get('/list', 'index')->name('frontend.instructor');
    Route::get('/filter', 'filterInstructor');
    Route::get('details/{name}/{id}', 'details')->name('frontend.instructor.details');
});

/**
 * ::::::::::::::  Ajax Routes Start ::::::::::::::
 */
Route::controller(HomeController::class)->prefix('home/ajax')->group(function () {
    Route::get('/menu-categories', 'menuCategories'); // best selling courses
    Route::get('/home-sliders', 'homeSliders')->name('homepage.homeSliders'); // home slider
    Route::get('/featured-courses', 'featuredCourses')->name('homepage.featuredCourses'); // featured courses
    Route::get('/latest-courses', 'latestCourses')->name('homepage.latestCourses'); // latest courses
    Route::get('/best-rated-courses', 'bestRatedCourses'); // best rated courses
    Route::get('/most-popular-courses', 'mostPopularCourses'); // best selling courses
    Route::get('/discount-courses', 'discountCourses'); // best selling courses

    Route::get('/popular-category', 'popularCategory')->name('homepage.popularCategory');
    Route::get('/become-an-instructor', 'becomeAnInstructor')->name('homepage.becomeAnInstructor');
    Route::get('/educational-events', 'educationalEvents')->name('homepage.educationalEvents');
    Route::get('/blogs', 'blogs')->name('homepage.blogs');
    Route::get('/testimonials', 'testimonials')->name('homepage.testimonials');
    Route::get('/brands', 'brands')->name('homepage.brands');
});
/**
 * ::::::::::::::  Ajax Routes End ::::::::::::::
 */
