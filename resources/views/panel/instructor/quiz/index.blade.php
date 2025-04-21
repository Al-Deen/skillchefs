@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!-- Dashboard Card S t a r t -->
    <div class="dashboared-card mb-40">
        <div class="row g-24">
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-one h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-file-upload-fill"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera font-600">{{ ___('instructor.Total Submission') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number(@$data['total_submissions']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-four h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-file-user-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-16 font-600">{{ ___('instructor.Total Passed') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number(@$data['passed_submissions']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-three h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-file-user-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-16 font-600">{{ ___('instructor.Total Failed') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number(@$data['failed_submissions']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of card -->
    <!-- instructor Courses activity Start -->
    <section class="instructor-courses-activity">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap">
                    <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    <div class="right d-flex flex-wrap justify-content-between">
                        <!-- Search Box -->
                        <form action="" class="search-box-style mb-20 mr-10">
                            <div class="responsive-search-box">
                                <input class="ot-search " type="text" name="search"
                                    placeholder="{{ ___('placeholder.Search Quiz') }}" value="{{ @$_GET['search'] }}">
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

        <div class="row">
            <div class="col-lg-12">
                <div class="activity-table">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>{{ ___('instructorCommon.Courses Name') }}</th>
                                <th>{{ ___('instructor.Submissions') }}</th>
                                <th>{{ ___('instructorCommon.Marks') }}</th>
                                <th>{{ ___('instructor.Average Marks') }}</th>
                                <th>{{ ___('instructorCommon.Status') }}</th>
                                <th>{{ ___('instructorCommon.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['quizzes'] as $quiz)
                                <tr>
                                    <td>
                                        <h5 class="text-16 text-tertiary mb-6">
                                            {{ @$quiz->title }}
                                        </h5>
                                        <p class="text-12">
                                            {{ Str::limit(@$quiz->course->title, 30) }}
                                        </p>
                                    </td>
                                    <td>
                                        {{ $quiz->submissions->count() }}

                                    </td>
                                    <td>
                                        {{ $quiz->marks }}
                                    </td>
                                    <td>
                                        {{ $quiz->submissions->avg('marks') }}

                                    </td>
                                    <td>
                                        {{ @$quiz->status->name }}

                                    </td>
                                    <td>
                                        <a href="{{ route('instructor.quiz.submission', encryptFunction($quiz->id)) }}"
                                            class="action-success">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td colspan="6" class="text-center">
                                        {{-- No Data Found --}}
                                        <div class="row justify-content-center">
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="not-data-found table-img text-center pt-50 pb-10">
                                                    <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                                        alt="img" class="w-100 mb-20 w-25">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of courses activity  -->

    <!--  pagination start -->
    {!! @$data['quizzes']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->

@endsection
