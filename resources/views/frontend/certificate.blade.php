@extends('frontend.layouts.master')
@section('title', $data['title'])
@section('content')
    <section class="ot-login-area">
        <div class="container">
            <div class="row gutter-x-120 align-items-center">
                <div class="col-lg-6">
                    <div class="ot-login-card">
                        <div class="title">
                            <h4>{{ $data['title'] }}</h4>
                        </div>

                        @if (@$data['certificate'])
                            <div class="alert alert-success" role="alert">
                                <p>{{ ___('frontend.Certificate_ID') }}: {{ @$data['certificate']->certificate_id }}</p>
                                <p>{{ ___('frontend.Name') }}: {{ @$data['certificate']->user->name }}</p>
                                <p>{{ ___('frontend.Course') }}: {{ @$data['certificate']->enroll->course->title }}</p>
                                <p>{{ ___('frontend.Issue_Date') }}: {{ @$data['certificate']->created_at }}</p>
                            </div>
                        @else
                            <form action="{{ route('front.certificateView') }}" method="GET">
                                <div class="position-relative ot-contact-form mb-24">
                                    <input class="form-control ot-contact-input" name="certificate_id" type="text"
                                        value="{{ @$_GET['certificate_id'] }}" autocomplete="off"
                                        placeholder="{{ ___('frontend.Enter_Certificate_ID') }}"
                                        aria-label="default input example" required>
                                </div>
                                <button class="btn-primary-submit w-100" name="submit"
                                    type="submit">{{ ___('common.Submit') }}</button>

                            </form>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="login-image ">
                        <img src="{{ showImage(gallery('tracking-certificate') , 'frontend/default/login.png') }}"
                            alt="img">
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('scripts')
@endsection
