@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--Bradcam S t a r t -->

    <!-- End-of Breadcrumb-->
    <div class="multi-step-form section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="become-instractor-form">
                        <form action="{{ route('instructor.sign_up') }}" method="POST">
                            @csrf
                            <div class="form-card mb-12">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="position-relative ot-contact-form mb-24">
                                            <label for="exampleInputEmail1"
                                                class="ot-contact-label">{{ ___('instructor.Name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input
                                                class="form-control ot-contact-input @error('name') is-invalid @enderror "
                                                name="name" type="text" value="{{old('name')}}"
                                                placeholder="{{ ___('instructor.Enter name') }}">
                                            @error('name')
                                                <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="position-relative ot-contact-form mb-24">
                                            <label for="exampleInputEmail1"
                                                class="ot-contact-label">{{ ___('instructor.Email') }}<span
                                                    class="text-danger">*</span></label>
                                            <input
                                                class="form-control ot-contact-input @error('email') is-invalid @enderror"
                                                name="email" type="email" value="{{old('email')}}"
                                                placeholder="{{ ___('instructor.Enter email address') }}">
                                            @error('email')
                                                <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="position-relative ot-contact-form mb-24">
                                            <label for="exampleInputEmail1"
                                                class="ot-contact-label">{{ ___('instructor.Phone') }}</label>
                                            <input
                                                class="form-control ot-contact-input @error('phone') is-invalid @enderror"
                                                name="phone" type="text" value="{{old('phone')}}"
                                                placeholder="{{ ___('instructor.Enter phone') }}">
                                            @error('phone')
                                                <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="position-relative ot-contact-form mb-24">
                                            <label for="exampleInputEmail1"
                                                class="ot-contact-label">{{ ___('instructor.Password') }}<span
                                                    class="text-danger">*</span></label>
                                            <input
                                                class="form-control ot-contact-input @error('password') is-invalid @enderror"
                                                name="password" type="password"
                                                placeholder="{{ ___('instructor.Enter Password') }}">
                                            @error('password')
                                                <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="position-relative ot-contact-form mb-24">
                                            <label for="exampleInputEmail1"
                                                class="ot-contact-label">{{ ___('instructor.Confirm Password') }}<span
                                                    class="text-danger">*</span></label>
                                            <input
                                                class="form-control ot-contact-input @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" type="password" placeholder="*******"
                                                aria-label="default input example">
                                            @error('password_confirmation')
                                                <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- save buttons  -->
                            <div class="d-flex">
                                <button class="next action-button btn-primary-fill">
                                    {{ ___('instructor.Submit') }}
                                </button>
                            </div>
                        </form>

                        <div class="create-account mt-20">
                            <p>{{ ___('student.Already have an account?') }} <a
                                    href="{{ route('frontend.signIn') }}"><span>{{ ___('auth.Sign In') }}</span></a> </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
