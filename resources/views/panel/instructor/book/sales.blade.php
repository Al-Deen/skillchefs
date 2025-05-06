@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!-- instructor Courses Start -->
    <section class="instructor-courses">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                    <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    <div class="right d-flex flex-wrap justify-content-between">
                        <!-- Search Box -->
                        <form action="" class="search-box-style mb-20 mr-10">
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

        <div class="row">
            <div class="col-xl-12">
                <div class="activity-table">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>{{ ___('course.Course') }}</th>
                                <th>{{ ___('common.Student') }}</th>
                                <th>{{ ___('course.Assignment') }}</th>
                                <th>{{ ___('course.Quiz') }}</th>
                                <th>{{ ___('course.Points') }}</th>
                                <th>{{ ___('course.Sales') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['courses'] as $course)
                                <tr>
                                    <td>
                                        <a target="_blank" href="{{ route('frontend.courseDetails', @$course->slug) }}">
                                            {{ Str::limit(@$course->title, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="enroll-student-details d-flex gap-10 align-items-center">
                                            <p>{{ @$course->enrolls->count() }}</p>
                                            <div class="all-enroll-student-img">
                                                @foreach ($course->enrolls as $enroll)
                                                    <div class="img-box">
                                                        <img src="{{ showImage($enroll->user->image->original ?? '', 'default-1.jpeg') }}"
                                                            alt="img">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ @$course->assignments->count() }}</td>
                                    <td>{{ @$course->quizzes->count() }}</td>
                                    <td>{{ @$course->point }}</td>
                                    <td>
                                        {{ showPrice(
                                            @$course->orderItem()->whereHas('order', function ($query) {
                                                    $query->where('status', 'paid');
                                                })->sum('total_amount'),
                                        ) }}
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
    <!-- End-of courses  -->
    <!--  pagination start -->
    {!! @$data['courses']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->
@endsection
