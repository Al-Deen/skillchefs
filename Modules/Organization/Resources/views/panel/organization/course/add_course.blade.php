@extends('organization::panel.organization.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!-- instructor Create new Course -->
    <section class="create-new-course">
        <!-- MultiStep S t a r t-->
        <div class="row">
            <div class="col-lg-12">
                <div class="multiStep-wrapper mb-50 mt-20">
                    <!-- Step listing -->
                    <ul class="step-list-wrapper">
                        <li class="single-step current-items" data-toggle="tooltip" title="{{ ___('organization.General') }}">
                            <span class="single-step-icon">
                                <i class="ri-folder-add-line"></i>
                            </span>
                        </li>
                        <li class="single-step" data-toggle="tooltip" title="{{ ___('organization.Course Price') }}">
                            <span class="single-step-icon">
                                <i class="ri-currency-line"></i>
                            </span>
                        </li>
                        <li class="single-step" data-toggle="tooltip" title="{{ ___('organization.Course Media') }}">
                            <span class="single-step-icon">
                                <i class="ri-image-line"></i>
                            </span>
                        </li>
                        <li class="single-step" data-toggle="tooltip" title="{{ ___('organization.Course_SEO') }}">
                            <span class="single-step-icon">
                                <i class="ri-price-tag-3-line"></i>
                            </span>
                        </li>
                        <li class="single-step" data-toggle="tooltip" title="{{ ___('organization.Course_Instructor') }}">
                            <span class="single-step-icon">
                                <i class="ri-user-3-line"></i>
                            </span>
                        </li>
                        <li class="single-step">
                            <span class="single-step-icon">
                                <i class="ri-check-line"></i>
                            </span>
                        </li>
                    </ul>
                </div>
                <!-- Next - Previus -->
                <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20 pb-20">
                    <!-- Section Tittle -->
                    <div class="section-tittle-two">
                        <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    </div>
                    <div class="d-flex aling-items-center flex-wrap gap-10 mb-20">
                        <button class="btn-primary-outline" type="button" id="previous-btn">
                            {{ ___('organization.Preview') }} </button>
                        <button class="btn-primary-fill" type="submit" id="next-btn"> {{ ___('organization.Save & Next') }} </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MultiStep End -->
        <form action="{{ route('organization.course.store') }}" method="POST" enctype="multipart/form-data" id="form_values">
            @csrf

             <!-- start general info -->
             @include('organization::panel.organization.partials.course.add.genral_info')
             <!-- end general info -->

             <!-- start price -->
             @include('organization::panel.organization.partials.course.add.price')
             <!-- end price -->

             <!-- start media -->
             @include('organization::panel.organization.partials.course.add.media')
             <!-- end media -->
             <!-- start seo -->
             @include('organization::panel.organization.partials.course.add.seo')
            <!-- end seo -->
             <!-- start course instructor -->
             @include('organization::panel.organization.partials.course.add.instructor')
            <!-- end course instructor -->
            <!-- Single Step Content 04 -->
            <div class="step-wrapper-contents">

            </div>
        </form>

    </section>
    <!-- End-of Create new Course -->

    <!-- Modal Custom -->

@endsection
@section('scripts')
    <script src="{{ url('modules/organization/js/__course.js') }}"></script>

    <!-- organization scripts -->
    <script src="{{ asset('modules/organization/js/app.js') }}"></script>
    <!-- organization scripts end -->
@endsection
