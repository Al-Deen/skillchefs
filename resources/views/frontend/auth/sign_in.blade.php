@extends('frontend.layouts.auth_master')
@section('title', @$data['title'])
@section('content')
    <section class="ot-login-area" id="ot_login_area">
        <div class="container">
            <div class="row gutter-x-120 align-items-center">
                <div class="col-lg-6">
                    <div class="ot-login-card">
                        <div class="logo">
                            {{ lightLogo() }}
                        </div>
                        <div class="title">
                            <h4>{{ ___('student.Sign In') }}</h4>
                        </div>
                        {{-- // error message --}}
                        @if (session('email_verify'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ session('email_verify') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('danger'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ session('danger') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('student.sign_in_post') }}" method="POST" id="studentSignIn">
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="exampleInputEmail1" class="ot-contact-label">
                                    {{ ___('student.Email Address') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control ot-contact-input" name="email" type="text"
                                    placeholder="{{ ___('student.Enter Email') }}" aria-label="default input example">
                                <span class="text-danger custom-error-text" id="error_email"></span>
                            </div>

                            <div class="position-relative ot-contact-form mb-24">
                                <label for="exampleInputEmail1" class="ot-contact-label">
                                    {{ ___('student.Password') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control ot-contact-input" name="password" type="password"
                                    placeholder="*******" aria-label="default input example">
                                <span class="text-danger custom-error-text" id="error_password"></span>
                            </div>
                            <div class="remember-me">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" value="programming" name="city" />
                                    <small>{{ ___('auth.Remember Me') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                                <div class="forget-section">
                                    <a href="{{ route('frontend.forgot_password') }}" class="forget-pass">
                                        <span>{{ ___('auth.Forgot password?') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn-primary-submit btn-login"
                                    id="studentSignInButton">{{ ___('auth.Sign In') }}</button>
                            </div>

                        </form>
                        <div class="login-footer">
                            <div class="create-account">
                                <p>{{ ___('auth.New User?') }} <a
                                        href="{{ route('student.sign_up') }}"><span>{{ ___('auth.Create an account') }}</span></a>
                                </p>
                            </div>
                            @if (module('SocialLogin') &&
                                    (setting('google_setup') || setting('facebook_setup') || setting('github_setup') || setting('linkedin_setup')))
                                <div class="sign-with">
                                    <p>{{ ___('auth.Or_Sign_in_with') }}</p>
                                    <ul class="icon-login-section">
                                        @if (setting('google_setup'))
                                            <li class="icon-login">
                                                <a href="{{ route('socialLogin.googleRedirect') }}"><i
                                                        class="ri-google-fill"></i></a>
                                            </li>
                                        @endif
                                        @if (setting('facebook_setup'))
                                            <li class="icon-login">
                                                <a href="{{ route('socialLogin.facebookRedirect') }}"><i
                                                        class="ri-facebook-fill"></i></a>
                                            </li>
                                        @endif
                                        @if (setting('github_setup'))
                                            <li class="icon-login">
                                                <a href="{{ route('socialLogin.githubRedirect') }}"><i
                                                        class="ri-github-fill"></i></a>
                                            </li>
                                        @endif
                                        @if (setting('linkedin_setup'))
                                            <li class="icon-login">
                                                <a href="{{ route('socialLogin.linkedinRedirect') }}"> <i
                                                        class="ri-linkedin-fill"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>

                        @if (\Config::get('app.APP_DEMO'))
                            {{-- // demo login form --}}
                            <div class=" mt-40  justify-content-center align-items-center">
                                <div class="row">
                                    <div class="col-xl-4 col-md-6 col-sm-12">
                                        <form action="{{ route('login.auth') }}" method="post"
                                            class="form d-flex justify-content-center align-items-start flex-column mb-10">
                                            @csrf
                                            <input name="email" type="hidden" value="instructor@onest.com">
                                            <input name="password" type="hidden" value="123456">
                                            <input name="g-recaptcha-response" type="hidden" value="123456">
                                            <button type="submit" class="btn-primary-submit btn-out w-100 pl-0 pr-0"
                                                value="Login">{{ ___('common.instructor') }}</button>
                                        </form>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-12">
                                        <form action="{{ route('login.auth') }}" method="post"
                                            class="form d-flex justify-content-center align-items-start flex-column mb-10">
                                            @csrf
                                            <input name="email" type="hidden" value="organization@onest.com">
                                            <input name="password" type="hidden" value="123456">
                                            <button type="submit" class="btn-primary-submit w-100 pl-0 pr-0"
                                                value="Login">{{ ___('organization.Organization') }}</button>
                                        </form>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-12">
                                        <form action="{{ route('login.auth') }}" method="post"
                                            class="form d-flex justify-content-center align-items-start flex-column mb-10">
                                            @csrf
                                            <input name="email" type="hidden" value="student@onest.com">
                                            <input name="password" type="hidden" value="123456">
                                            <button type="submit" class="btn-primary-submit w-100 pl-0 pr-0"
                                                value="Login">{{ ___('common.student') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- // demo login form --}}
                        @endif
                    </div>


                </div>




                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="login-image ">
                        <img src="{{ showImage(gallery('sign-in'), 'frontend/default/login.png') }}" alt="img">
                    </div>
                </div>


            </div>
        </div>

    </section>

@endsection
