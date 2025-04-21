@extends('frontend.layouts.auth_master')
@section('title', @$data['title'])
@section('content')


    <section class="ot-login-area">
        <div class="container">
            <div class="row gutter-x-120 align-items-center">
                <div class="col-lg-6">
                    <div class="ot-login-card">
                        <div class="logo">
                            {{ lightLogo() }}
                        </div>
                        <div class="title">
                            <h4>{{ ___('auth.Forgot Password') }}</h4>
                        </div>

                        @if (session('danger'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

                        <form action="{{ route('frontend.forgot_password_post') }}" method="POST">
                            @csrf
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="exampleInputEmail1"  class="ot-contact-label">
                                    {{ ___('auth.Email Address') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control ot-contact-input" name="email" type="text"
                                    value="{{ old('email') }}" placeholder="{{ ___('auth.Enter Email') }}"
                                    aria-label="default input example" required>
                            </div>
                            <button class="btn-primary-submit w-100" name="submit"
                                type="submit">{{ ___('auth.Reset') }}</button>

                        </form>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="login-image ">
                        <img src="{{ @showImage(gallery('forgot-password'), 'frontend/default/login.png') }}"
                            alt="img">
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
