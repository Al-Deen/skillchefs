@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->


    <!-- get-in touch S t a r t-->
    <section class="ot-courses-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-tittle mb-30 text-center">
                        <h2 class="title text-capitalize font-600 position-relative">{{ ___('frontend.get_in_touch!') }}</h2>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="d-flex align-items-center  mb-32">
                        <div class="contact-icon radius-4 badge-secondary-soft mr-24">
                            <i class="ri-mail-line"></i>
                        </div>
                        <div class="contact-info ">
                            <h5 class="text-18 font-600 mb-6">{{ ___('frontend.Email Address') }}</h5>
                            <p class="text-16 font-400">{{ Setting('email_address') }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center  mb-32">
                        <div class="contact-icon radius-4 badge-secondary-soft mr-24">
                            <i class="ri-community-line"></i>
                        </div>
                        <div class="contact-info ">
                            <h5 class="text-18 font-600 mb-6">{{ ___('frontend.Office Address') }}</h5>
                            <p class="text-16 font-400">{{ Setting('office_address') }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center  mb-32">
                        <div class="contact-icon radius-4 badge-secondary-soft mr-24">
                            <i class="ri-phone-line"></i>
                        </div>
                        <div class="contact-info ">
                            <h5 class="text-18 font-600 mb-6">{{ ___('frontend.phone number') }}</h5>
                            <p class="text-16 font-400">{{ Setting('phone_number') }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center  mb-32">
                        <div class="contact-icon radius-4 badge-secondary-soft mr-24">
                            <i class="ri-time-line"></i>
                        </div>
                        <div class="contact-info ">
                            <h5 class="text-18 font-600 mb-6">{{ ___('frontend.office hours') }}</h5>
                            <p class="text-16 font-400"><span class="text-16 font-400">{{ Setting('office_hours') }}</p>
                        </div>
                    </div>
                </div>
                <div class="offset-xl-2 col-xl-6">
                    <div class="position-relative">
                        <form action="{{ route('frontend.contact_us.store') }}" method="post">
                            @csrf
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="name" class="ot-contact-label">{{ ___('frontend.Name') }}</label>
                                <input class="form-control ot-contact-input" type="text"
                                    placeholder="{{ ___('frontend.enter_your_name') }}" name="name" id="name"
                                    aria-label="default input example">

                                @error('name')
                                    <div id="error" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="email"
                                    class="ot-contact-label">{{ ___('frontend.Email') }}</label>
                                <input class="form-control ot-contact-input" type="email"
                                    placeholder="{{ ___('frontend.enter_your_email') }}" name="email" id="email"
                                    aria-label="default input example">
                                @error('email')
                                    <div id="error" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="subject"
                                    class="ot-contact-label">{{ ___('frontend.Subject') }}</label>
                                <input class="form-control ot-contact-input" type="subject" id="subject"
                                    placeholder="{{ ___('frontend.enter_your_subject') }}" name="subject"
                                    aria-label="default input example">
                                @error('subject')
                                    <div id="error" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <div class="position-relative ot-contact-form mb-24">
                                <label for="message"
                                    class="ot-contact-label">{{ ___('frontend.Message') }}</label>
                                <textarea class="ot-contact-textarea" placeholder="{{ ___('frontend.enter_your_message') }}" name="message"
                                    id="message" cols="10" rows="8"></textarea>
                                @error('message')
                                    <div id="error" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button class="btn-primary-submit">{{ ___('frontend.Send_Message') }}</button>
                        </form>
                        <div class="form-icon position-absolute">
                            <img src="{{ asset('frontend') }}/assets/images/icon/arrow.png" alt="img">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of get-in touch-->

    <!-- Map S t a r t -->
    <div class="map-area bottom-padding">
        <div class="container">
            <div class="col-lg-12">
                <div class="map-wrapper">
                    <iframe src="<?= Setting('application_map') ?>" width="600" height="450"
                        allowfullscreen="" loading="lazy" width="100%" height="370px"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of Map -->


@endsection
@section('scripts')

@endsection
