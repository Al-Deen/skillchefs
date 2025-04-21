@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- Content Wrapper -->
    <div class="row">
        <!-- Section Tittle -->
        <div class="col-xl-12">
            <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                <div class="right d-flex flex-wrap justify-content-between">
                    <!-- Search Box -->
                    <form action="" class="search-box-style mb-20 mr-10">
                        <div class="responsive-search-box">
                            <input class="ot-search " type="text" name="search""
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
    </div>

    <!-- Feedbacks & Reviews S t a r t -->
    <section class="feedback-reviews-area">
        <div class="row g-24">
            @forelse ($data['course'] as $course)
                <div class="col-xl-6">
                    <div class="ot-card h-calc mb-24 pb-0">
                        <!-- Title -->
                        <div class="border-bottom mb-20 pb-10">
                            <div class="tittle-notification d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="icon"><i class="ri-tools-fill"></i></div>
                                    <h4 class="title font-600 mb-10">
                                        <a target="_blank" href="{{ route('frontend.courseDetails', @$course->slug) }}">
                                            {{ Str::limit($course->title, 30) }}
                                        </a>
                                    </h4>
                                </div>
                                <div class="total-ratting mb-10">
                                    <p>{{ ___('course.Ratings') }}: <span
                                            class="text-tertiary">{{ @$course->rating }}</span></p>
                                </div>

                            </div>
                            <div class="total-review mb-10 d-flex align-items-center justify-content-between flex-wrap">
                                <p>{{ ___('course.Review by') }}: <span class="text-tertiary">{{ $course->total_review }}
                                        {{ $course->total_review > 0 ? ___('course.Reviews') : '' }}</span></p>
                                @if (@$course->total_review)
                                    <p>
                                        <a target="_blank"
                                            href="{{ route('frontend.courseDetails', [@$course->slug]) }}#review"
                                            class="text-primary">{{ ___('common.See more') }}</a>
                                    </p>
                                @endif
                            </div>
                        </div>

                        @forelse ($course->reviews as $review)
                            <!-- single feedback Review -->
                            <div class="single-feedback-review radius-12 mb-18">
                                <div class="review-top">
                                    <div class="review-user flex-fill mb-7">
                                        <div class="review-img mt-6 mb-10">
                                            <img class="img-cover"
                                                src="{{ showImage(@$review->user->image->original ?? '', 'default-1.jpeg') }}"
                                                alt="round-img">
                                        </div>
                                        <div class="flex-fill mr-7">
                                            <h5 class="review-title line-clamp-3 font-500"> <?= @$review->comment ?></h5>
                                            <p class="review-widget-description"> - {{ @$review->user->name }} </p>
                                        </div>
                                    </div>
                                    <div class="review mb-7">
                                        <p>{{ ___('course.Ratings') }} ({{ @$review->rating }})</p>
                                        <div class="rating-star d-flex align-items-center">
                                            {{ rating_ui(@$review->rating, 16) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single feedback Review -->
                        @empty

                            {{-- No Data Found --}}
                            <div class="col-lg-3 col-md-6 col-sm-6 m-auto">
                                <div class="not-data-found table-img text-center pt-50 pb-10">
                                    <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                        alt="img" class="w-100 w-25">
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

            @empty
                <div class="col-xl-12">
                    <div class="ot-card h-calc mb-24 pb-0 ">
                        <div class="flex-wrap text-center">
                            <h5 class="title font-600 mb-10">
                                {{ ___('instructor.No Course Found') }}
                            </h5>
                        </div>
                    </div>
                </div>
            @endforelse

        </div>
    </section>
    <!-- End-of Feedbacks & Reviews -->

    <!--  pagination start -->
    {!! @$data['course']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->



@endsection
