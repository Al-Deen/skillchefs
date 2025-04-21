@extends('frontend.layouts.auth_master')
@section('title', @$data['title'])
@section('content')
    <!-- LOGIN::START  -->
    <section class="ot-login-area" id="ot_registration_area">
        <div class="container">
            <div class="row gutter-x-120 align-items-center">
                <div class="col-lg-6">
                    <div class="ot-login-card">
                        <div class="logo">
                            {{ lightLogo() }}
                        </div>
                        <div class="title">
                            <h4>{{ ___('student.Sign Up') }}</h4>
                        </div>
                        <form action="{{ route('student.sign_up_post') }}" method="POST" id="studentSignUp">
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="exampleInputEmail1" class="ot-contact-label">
                                    {{ ___('student.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control ot-contact-input" name="name" type="text"
                                    placeholder="{{ ___('student.Enter name') }}" aria-label="default input example">
                                <span class="text-danger custom-error-text" id="error_name"></span>

                            </div>
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
                                    {{ ___('student.Phone Number') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control ot-contact-input" name="phone" type="number"
                                    placeholder="{{ ___('student.Enter Phone Number') }}"
                                    aria-label="default input example">
                                <span class="text-danger custom-error-text" id="error_phone"></span>

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

                            <div class="position-relative ot-contact-form mb-24">
                                <label for="exampleInputEmail1" class="ot-contact-label">
                                    {{ ___('student.Confirm Password') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control ot-contact-input" name="password_confirmation" type="password"
                                    placeholder="*******" aria-label="default input example">
                                <span class="text-danger custom-error-text" id="error_password_confirmation"></span>
                            </div>
                            <div class="position-relative ot-contact-form mb-40">
                                <div class="remember-me terms-condition mb-0">
                                    <label>
                                        <input class="ot-checkbox" type="checkbox" value="programming" name="agree" />
                                        <small>{{ ___('student.I agree to all the') }}
                                            <a
                                                href="{{ route('frontend.page.link', ['privacy-policy', encryptFunction(1)]) }}"><span>{{ ___('student.Terms and Conditions') }}</span></a>
                                        </small>
                                        <span class="ot-checkmark"></span>
                                    </label>
                                </div>
                                <span class="text-danger custom-error-text" id="error_agree"></span>
                            </div>
                            <div class="d-grid">
                                <a type="button" class="btn-primary-submit"
                                    id="studentSignUpButton">{{ ___('student.Sign Up') }}</a>
                            </div>
                        </form>
                        <div class="login-footer">
                            <div class="create-account">
                                <p>{{ ___('student.Already have an account?') }} <a
                                        href="{{ route('frontend.signIn') }}"><span>{{ ___('auth.Sign In') }}</span></a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="login-image ">
                        <img src="{{ @showImage(gallery('sign-up'), 'frontend/default/login.png') }}" alt="img">
                    </div>
                </div>
            </div>


        </div>

    </section>


    <!-- LOGIN::END  -->

@endsection
