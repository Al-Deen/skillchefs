@extends('frontend.layouts.auth_master')
@section('title', @$data['title'])
@section('content')
    <!-- login area S t a r t  -->
    <section class="ot-login-area">
        <div class="container">
            <div class="row gutter-x-120 align-items-center">
                <div class="col-lg-6">
                    <div class="ot-login-card">
                        <div class="logo">
                            {{ lightLogo() }}
                        </div>
                        {{-- alert message --}}

                        @if (session('danger'))
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <strong>{{ session('danger') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- Email Verify --}}
                        @if(($data['verification'] === "1" || $data['verification'] === "3") && !auth()->user()->email_verified_at)
                        <div class="title">
                            <h4>{{ @$data['email_title'] }}</h4>
                        </div>
                        <!-- Form -->
                        <a class="btn-primary-submit w-100" href="{{ $data['email_url'] }}">{{ $data['email_button'] }}</a>
                        @endif

                        {{-- SMS OTP Verify --}}
                        @if($data['verification'] === "2" || $data['verification'] === "3" && !auth()->user()->phone_verified_at)
                        <div class="title">
                            <h4>{{ @$data['otp_title'] }}</h4>
                        </div>
                        <!-- Form -->
                        <form action="{{ route('verify.otp_verification') }}" method="POST">
                            @csrf
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="exampleInputEmail1" class="ot-contact-label">
                                    {{ ___('common.OTP Code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control ot-contact-input" name="otp" type="text"
                                    placeholder="{{ ___('student.Enter OTP Code') }}" aria-label="default input example">
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                        rewrew
                                    </div>
                                @if ($errors->has('otp'))
                                    <span class="text-danger">{{ $errors->first('otp') }}</span>
                                @endif
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn-primary-submit" >{{ ___('auth.Submit') }}</button>
                            </div>
                        </form>
                        <a class="btn-primary-submit w-100 mt-3" href="{{ $data['otp_url'] }}">{{ $data['otp_button'] }}</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="login-image ">
                        <img src="{{ @showImage(gallery('verify-email'), 'frontend/default/login.png') }}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of Login -->

@endsection
