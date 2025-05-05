<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Panel\Student\StudentAuthController;
use App\Http\Controllers\Panel\Instructor\InstructorAuthController;



// common auth routes
Route::controller(AuthController::class)->group(function () {

    // social google Login
    Route::get('auth/redirection/{provider}', 'authProviderRedirect')->name('auth.redirection');
    Route::get('auth/{provider}-callback', 'socialAuthentication')->name('auth.callback');

    Route::get('sign-in',          'signIn')->name('frontend.signIn');
    Route::post('/sign-in',        'signInPost')->name('student.sign_in_post');



    Route::get('verify-email/{email}',                  'verifyEmail')->name('frontend.verify_email');
    // reset password
    Route::get('forgot-password',                       'forgotPassword')->name('frontend.forgot_password');
    Route::post('forgot-password',                      'forgotPasswordPost')->name('frontend.forgot_password_post');

    Route::get('reset-password/{email}',        'resetPassword')->name('frontend.reset_password');
    Route::post('reset-password',               'resetPasswordPost')->name('frontend.reset_password_post');

    Route::middleware(['auth'])->group(function () {
        Route::get('/verification', 'verify')->name('verification.notice');
        // for email & otp type
        Route::get('/email/send/verify/{type}/{id}', 'sendVerify')->name('send.verification.verify')->middleware(['throttle:6,1']);
        // otp match for phone number verify
        Route::post('/email/verify/otp_match', 'verifyPhoneNumber')->name('verify.otp_verification');

    });
});
// common auth routes

// Students Auth related routes
Route::controller(StudentAuthController::class)->group(function () {

    Route::get('/sign-up',                              'signUp')->name('student.sign_up');
    Route::post('/sign-up',                             'signUpPost')->name('student.sign_up_post');
});
//  Students Auth related routes





// instructors Auth related routes
Route::controller(InstructorAuthController::class)->prefix('instructor')->group(function () {
    Route::get('/become-instructor',                            'becomeInstructor')->name('becomeInstructor');
    Route::post('/sign-up',                                     'signUp')->name('instructor.sign_up');
});
//  instructors Auth related routes
