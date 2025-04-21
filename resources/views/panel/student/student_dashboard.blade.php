@extends('panel.student.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- Banner S t a r t-->
    <div class="row justify-content-center">
        <div class="col-xxl-12  col-xl-12 col-lg-12">
            <div class="admin-hero mb-24">
                <h3 class="title font-700 text-white wow fadeInUp" data-wow-delay="0.0s">{{ ___('student.Hey') }}
                    <strong>{{ auth()->user()->name ?? '' }}</strong>,
                    {{ ___('student.Welcome again!') }}
                </h3>
                <p class="pera text-white wow fadeInUp" data-wow-delay="0.2s">{{ ___("student.You've finished") }}
                    <a href="{{ route('student.certificates') }}" class="sub-title text-tertiary">
                        {{ $data['student']->completeEnrollments->count() }} {{ ___('student.Courses') }}. </a>
                    {{ ___('student.Need to discover more?') }}
                </p>
                <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                    <a href="{{ route('student.course') }}" class="fill-btn-white  wow fadeInLeft"
                        data-wow-delay="0.3s">{{ ___('student.Discover Courses') }}</a>
                    <a href="{{ route('student.course_activities') }}" class="outline-btn-white wow fadeInRight"
                        data-wow-delay="0.3s">{{ ___('student.My Activites') }}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of Banner -->

    <!-- my Learning S t a r t-->
    @if (@$data['student']->lastVisited)
        <section class="my-learning section-padding3">
            <!-- Section Tittle -->
            <div class="row justify-content-between align-items-end align-items-center mb-20">
                <div class="col-xl-12">
                    <div
                        class="section-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10 pb-20 gap-15">
                        <h2 class="title font-600">{{ ___('student.The last time you visited') }}</h2>
                        <a href="{{ route('student.course') }}" class="browse-btn">{{ ___('student.See All') }}</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-5">
                    <div class="video-img overly1 mb-10">
                        <img src="{{ showImage(@$data['student']->lastVisited->course->thumbnailImage->original) }}"
                            class="img-cover" alt="img">
                        <!--video icon -->
                        <div class="video-icon video-icon2">
                            <a class="popup-video btn-icon"
                                @if (@$data['student']->lastVisited->course->firstLesson) href="{{ route('student.course.learn', [@$data['student']->lastVisited->course->slug, encryptFunction(@$data['student']->lastVisited->course->firstLesson->id)]) }}" @endif
                                data-animation="bounceIn" data-delay=".4s">
                                <img src="{{ url('frontend/assets/images/icon/play.svg') }}" alt="img">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-7">
                    <div class="my-learning-summary">
                        <h4 class="title line-clamp-2 font-600">{{ @$data['student']->lastVisited->course->title }}</h4>
                        <p class="pear d-inline-block">{{ @$data['student']->lastVisited->course->lessons->count() }}
                            {{ ___('frontend.Lesson') }},
                            {{ minutes_to_hours(@$data['student']->lastVisited->course->course_duration) }}</p>
                        <ul class="ratting d-inline-block">
                            <li>
                                <p class="pera">{{ number_format(@$data['student']->lastVisited->course->rating, 1) }}
                                </p>
                            </li>
                            {{ rating_ui(@$data['student']->lastVisited->course->rating, 12) }}
                            <li>
                                <p class="pera">
                                    ({{ numberFormat(@$data['student']->lastVisited->course->total_review) }})</p>
                            </li>
                        </ul>
                        <!-- user -->
                        <a href="{{ route('frontend.instructor.details', [@$data['student']->lastVisited->course->user->name, @$data['student']->lastVisited->course->user->id]) }}"
                            class="user-profile2 mt-10 mb-28">
                            <div class="user-img">
                                <img src="{{ showImage(@$data['student']->lastVisited->course->user->image->original) }}"
                                    class="img-cover" alt="images">
                            </div>
                            <div class="user-cap">
                                <div class="cap">
                                    <h5 class="title">{{ @$data['student']->lastVisited->course->user->name }} </h5>
                                    <p class="pera">
                                        {{ @$data['student']->lastVisited->course->user->instructor->designation }}</p>
                                </div>
                            </div>
                        </a>
                        <!-- Button -->
                        <div class="d-flex align-items-end">
                            <div class="btn-wrapper">
                                @if (@$data['student']->lastVisited->course->firstLesson)
                                    <a @if (@$data['student']->lastVisited->course->firstLesson) href="{{ route('student.course.learn', [@$data['student']->lastVisited->course->slug, encryptFunction(@$data['student']->lastVisited->course->firstLesson->id)]) }}" @endif
                                        class="btn-primary-outline w-100">{{ ___('student.Start Learning') }}</a>
                                @else
                                    <a href="javascript:void(0)"
                                        class="btn-primary-outline w-100">{{ ___('student.No Lesson') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- End-of Learning -->

    <!-- activity S t a r t -->
    <section class="activity">
        <div class="row">
            <div class="col-xl-12">
                <!-- Progress Bar -->
                <div class="ot-card mb-24 pb-0">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Section Title -->
                            <div class="activity-title mb-30 d-flex justify-content-between flex-wrap align-items-center">
                                <h5 class="title text-title font-600 mb-1mb-200">
                                    {{ ___('student.Overview of your recent learning') }}<span
                                        class="text-paragraph ml-6 mr-6">({{ @$data['student']->completeEnrollments->count() }}
                                        {{ ___('student.Done') }})</span></h5>
                                <a href="{{ route('student.course') }}"
                                    class="font-600 mb-10">{{ ___('student.My Learning') }}</a>
                            </div>
                        </div>
                        @foreach ($data['student']->enrollments()->orderBy('id', 'desc')->take(4)->get() as $enroll)
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="activity-progress">
                                    <!-- Single -->
                                    <div class="single-progress mb-20">
                                        <div class="d-flex justify-content-between mb-15">
                                            <p class="title text-primary">{{ Str::limit(@$enroll->course->title, 100) }}
                                            </p>
                                            <p class="percentage text-tertiary font-600">{{ @$enroll->progress }}%</p>
                                        </div>
                                        <div class="progress height-10 radius-50 mb-6">
                                            <div class="progress-bar @if (@$enroll->progress < 10) bg-danger @elseif(@$enroll->progress > 10 && @$enroll->progress < 50) bg-warning @elseif(@$enroll->progress == 100) bg-success @endif"
                                                role="progressbar" style="width: {{ @$enroll->progress }}%"
                                                aria-valuenow="{{ @$enroll->progress }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-15">
                                            <p class="count text-tertiary">{{ ___('student.Total') }}
                                                {{ count(@$enroll->completed_quizzes ?? []) + count($enroll->completed_lessons ?? []) + count(@$enroll->completed_assignments ?? []) }}
                                                {{ ___('student.done') }}</p>
                                            @if (@$enroll->progress == 100)
                                                <a href="{{ route('student.certificate.view', encryptFunction($enroll->id)) }}"
                                                    class="count text-primary">{{ ___('student.View Certificate') }}</a>
                                            @else
                                                <p class="count text-primary opacity-50 ">
                                                    {{ ___('student.View Certificate') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Single -->
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of activity -->

    <!-- Enrolled Courses -->
    <section class="enrolled-courses top-padding3">
        <!-- Section Tittle -->
        <div class="row justify-content-between align-items-end align-items-center mb-20">
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom pb-8 d-flex align-items-center justify-content-between flex-wrap">
                    <h2 class="title font-600">{{ ___('student.My Enrolled Courses') }}</h2>
                    @if ($data['student']->user->purchaseCourses->count())
                        <a href="{{ route('student.course') }}" class="browse-btn mt-6">{{ ___('student.See All') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-24">

            @forelse ($data['student']->user->purchaseCourses()->orderBy('id', 'desc')->get() as $enroll)
                <div class="col">
                    <div class="my-single-courses white-bg position-relative radius-8 h-calc">
                        <div class="video-img2 overly1">
                            <a href="{{ route('frontend.courseDetails', $enroll->course->slug) }}"> <img
                                    src="{{ showImage(@$enroll->course->thumbnailImage->original) }}" class="img-cover"
                                    alt="img"> </a>
                            <!--video icon -->
                            <div class="video-icon">
                                <a class="popup-video btn-icon"
                                    @if (@$enroll->course->firstLesson) href="{{ route('student.course.learn', [$enroll->course->slug, encryptFunction($enroll->course->firstLesson->id)]) }}" @endif>
                                    <img src="{{ url('frontend/assets/images/icon/play.svg') }}" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="course-caption">
                            <h4>
                                <a @if (@$enroll->course->firstLesson) href="{{ route('student.course.learn', [$enroll->course->slug, encryptFunction($enroll->course->firstLesson->id)]) }}" @endif
                                    class="title font-600 d-block line-clamp-2 line-clamp-2  mb-10">
                                    {{ Str::limit(@$enroll->course->title, 25) }}</a>
                            </h4>
                        </div>
                    </div>
                </div>
            @empty
                {{-- No Data Found --}}
                <div class="col m-auto">
                    <div class="not-data-found text-center pt-50 pb-50">
                        <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                            alt="img" class="w-100 mb-20">
                    </div>
                </div>
            @endforelse
        </div>
    </section>
    <!-- End-of Enrolled Courses -->
@endsection
