@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')


    <!-- instructor Create new Course -->
    <section class="create-new-course" id="course_step">
        <!-- MultiStep S t a r t-->
        <div class="row" id="edit_course" data-val="{{ ($data['course']->id) }}">
            <div class="col-lg-12">
                <div class="multiStep-wrapper mb-50 mt-20">
                    <!-- Step listing -->
                    <ul class="step-list-wrapper">

                        <li class="edit_course single-step current-items" data-val="1" data-toggle="tooltip" title="{{ ___('instructor.Course Curriculum') }}">
                            <span class="single-step-icon">
                                <i class="ri-book-open-line"></i>
                            </span>
                        </li>
                        <li class="edit_course single-step completed" data-val="2" data-toggle="tooltip" title="{{ ___('instructor.Assignment') }}">
                            <span class="single-step-icon">
                                <i class="ri-file-list-3-line"></i>
                            </span>
                        </li>
                        <li class="edit_course single-step completed" data-val="3" data-toggle="tooltip" title="{{ ___('instructor.NoticeBoard') }}">
                            <span class="single-step-icon">
                                <i class="ri-notification-badge-line"></i>
                            </span>
                        </li>
                        <li class="edit_course single-step completed" data-val="4" data-toggle="tooltip" title="{{ ___('instructor.General') }}">
                            <span class="single-step-icon">
                                <i class="ri-folder-add-line"></i>
                            </span>
                        </li>
                        <li class="edit_course single-step completed" data-val="5" data-toggle="tooltip" title="{{ ___('instructor.Course Price') }}">
                            <span class="single-step-icon">
                                <i class="ri-currency-line"></i>
                            </span>
                        </li>
                        <li class="edit_course single-step completed" data-val="6" data-toggle="tooltip" title="{{ ___('instructor.Course Media') }}">
                            <span class="single-step-icon">
                                <i class="ri-image-line"></i>
                            </span>
                        </li>
                        <li class="edit_course single-step completed" data-val="7" data-toggle="tooltip" title="{{ ___('instructor.Course_SEO') }}">
                            <span class="single-step-icon">
                                <i class="ri-price-tag-3-line"></i>
                            </span>
                        </li>
                        <li class="edit_course single-step completed" data-val="8" data-toggle="tooltip" title="{{ ___('instructor.Course_Complete') }}">
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
                            {{ ___('instructor.Preview') }} </button>
                        <button class="btn-primary-fill" type="submit" id="next-btn"> {{ ___('instructor.Save & Next') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MultiStep End -->
        <form action="{{ route('instructor.course.update', $data['course']->slug) }}" method="POST"
            enctype="multipart/form-data" id="form_values">
            @csrf
            <!-- start course curiculum -->
            @include('panel.instructor.partials.course.edit.curriculam')
            <!-- end course curiculum -->
            <!-- start course assignment -->
            @include('panel.instructor.partials.course.edit.assignment')
            <!-- end course assignment -->
            <!-- start course noticeBoard -->
            @include('panel.instructor.partials.course.edit.noticeboard')
            <!-- end course noticeBoard -->
            <!-- start general info -->
            @include('panel.instructor.partials.course.edit.genral_info')
            <!-- end general info -->

            <!-- start price -->
            @include('panel.instructor.partials.course.edit.price')
            <!-- end price -->

            <!-- start media -->
            @include('panel.instructor.partials.course.edit.media')
            <!-- end media -->
            <!-- start seo -->
            @include('panel.instructor.partials.course.edit.seo')
            <!-- end seo -->
            <!-- Single Step Content 04 -->
            <div class="step-wrapper-contents">

            </div>
        </form>

    </section>
    <!-- End-of Create new Course -->

@endsection
@section('scripts')
    <script src="{{ url('frontend/js/instructor/__course.js') }}"></script>
@endsection
