@extends('panel.student.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- Courses -->
    <section>
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10 pb-20 gap-15">
                    <h2 class="title font-600">{{ $data['title'] }}</h2>
                    <div class="right d-flex flex-wrap justify-content-between">
                        <!-- Search Box -->
                        <form action="" class="search-box-style">
                            <div class="responsive-search-box">
                                <input class="ot-search " type="text" name="search"
                                    placeholder="{{ ___('placeholder.Search Courses') }}" value="{{ @$_GET['search'] }}">
                                <!-- icon -->
                                <div class="search-icon">
                                    <i class="ri-search-line"></i>
                                </div>
                                <!-- Button -->
                                <button class="search-btn">
                                    {{ ___('frontend.Search') }}
                                </button>
                            </div>
                        </form>
                        <!-- /End -->
                    </div>
                </div>
            </div>

            <!-- Search -->
        </div>

        <!-- Course -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-5 g-24 mt-0 p-0 ">
            @forelse ($data['enrolls'] as $enroll)
                <div class="col">
                    <div class="my-single-courses white-bg position-relative radius-8 h-calc">
                        <a class="course-badge position-absolute text-10 font-400 radius-4 "
                            href="javascript:void(0)">{{ @$enroll->course->category->title }}</a>
                        <div class="video-img2 overly1">
                            <a href="javascript:void(0)"> <img
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
                            <h4><a href="{{ route('frontend.courseDetails', $enroll->course->slug) }}"
                                    class="title font-600 d-block line-clamp-2 line-clamp-2  mb-10">{{ Str::limit(@$enroll->course->title, 25) }}</a>
                            </h4>
                            <span class="module-time d-block mb-6">{{ $enroll->course->lessons->count() }}
                                {{ ___('frontend.Lesson') }},
                                {{ minutes_to_hours(@$enroll->course->course_duration) }}</span>
                            <span class="module-count text-tertiary d-block">{{ $enroll->course->quizzes->count() }}
                                {{ ___('course.Quizzes') }} {{ ___('student.&') }}
                                {{ $enroll->course->assignments->count() }} {{ ___('course.Assignments') }} </span>
                            @if ($enroll->course->firstLesson)
                                <a @if (@$enroll->course->firstLesson) href="{{ route('student.course.learn', [$enroll->course->slug, encryptFunction($enroll->course->firstLesson->id)]) }}" @endif
                                    class="btn-primary-outline w-100">{{ ___('student.Start Learning') }}</a>
                            @else
                                <a href="{{ route('student.course.learn', [$enroll->course->slug, 'no_lesson']) }}"
                                    class="btn-primary-outline w-100">{{ ___('student.No Lesson') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty

                {{-- No Data Found --}}
                <div class="col-lg-3 col-md-6 col-sm-6 m-auto">
                    <div class="not-data-found text-center pt-50 pb-50">
                        <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                            alt="img" class="w-100 mb-20">
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!--  pagination start -->
    {!! @$data['enrolls']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->

@endsection
