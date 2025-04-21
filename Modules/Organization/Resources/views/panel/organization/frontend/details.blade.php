@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->

    <!-- Instructor Details s t a r t  -->
    <section class="ot-instructor-details-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="instructor-profile ">
                        <div class="instructor-profile-card radius-4 mb-24">
                            <div class="instructor-image">
                                <img src="{{ showImage(@$data['instructor']->user->image->original) }} " alt="img" >
                            </div>
                            <div class="caption">
                                <h6 class="instructor-name font-600">{{ @$data['organization']->user->name }}</h6>
                                <p class="instructor-position font-500">{{ ___('organization.Organization') }}</p>
                                <h6 class="instructor-designation">{{ @$data['organization']->designation }}</h6>
                                <p class="rating mb-10">
                                    <i class="ri-star-fill"></i>
                                    <span class="ratting-count font-500"> ({{ $data['organization']->ratings() }})</span>
                                    <span class="total-ratting font-600">
                                        ({{ $data['organization']->totalReviews() > 1 ? $data['organization']->totalReviews() . ' ' . ___('frontend.Ratings') : $data['organization']->totalReviews() . ' ' . ___('frontend.Rating') }})</span>
                                </p>
                                <!-- Sale Status -->
                                <div class="d-flex gap-10 justify-content-center flex-wrap mb-10">
                                    <div class="sale-status">
                                        <i class="ri-parent-line"></i>
                                        <span
                                            class="count font-500">{{ $data['organization']->courses->sum('total_sales') }}</span>
                                        <span class="pera font-500">
                                            @if ($data['organization']->courses->sum('total_sales') > 1)
                                                {{ ___('frontend.Sales') }}
                                            @else
                                                {{ ___('frontend.Sale') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expertise Tag -->
                        @if (@$data['organization']->skills)
                            <div class="tag-area radius-4 mb-24">
                                <h3 class="tittle font-500">{{ ___('frontend.Expertise') }}</h3>
                                <ul class="listing">
                                    @foreach (@$data['organization']->skills as $key => $skill)
                                        <li class="single-list">{{ @$skill['value'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="organization-content">
                        <div class="organization-info mb-24">
                            <p>{{ @$data['organization']->about_me }}</p>
                        </div>

                        <div class="counting-area mb-60">
                            <div class="d-flex justify-content-between">
                                <div class="count-number">
                                    <h4>{{ $data['organization']->courses->count() }}</h4>
                                    <p>{{ ___('frontend.Courses') }}</p>
                                </div>
                                <div class="count-number">
                                    <h4>{{ @$data['organization']->user->courseEnroll()->groupBy('user_id')->count() }}</h4>
                                    <p>{{ ___('frontend.Students') }}</p>
                                </div>
                                <div class="count-number">
                                    <h4>{{ @$data['organization']->user->courseEnroll->count() }}</h4>
                                    <p>{{ ___('frontend.Enrolls') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="courses-area">
                            <!-- Title -->
                            <div class="small-tittle mb-25">
                                <h3 class="tittle font-600">{{ ___('frontend.Courses') }}</h3>
                            </div>

                            <div class="row g-24">
                                @forelse ($data['courses'] as $key => $course)
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 view-wrapper">
                                        @include('frontend.partials.course.course_widget', [
                                            'course' => $course,
                                        ])
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-warning text-center">
                                            <h4 class="text-16 font-500">{{ ___('frontend.No Courses Found') }}</h4>
                                        </div>

                                    </div>
                                @endforelse
                            </div>

                        </div>
                    </div>
                    <!-- Pagination S t a r t -->
                    <?= $data['courses']->links('frontend.partials.pagination-count') ?>
                    <!-- End-of Pagination -->
                </div>
            </div>
        </div>
    </section>
    <!-- End-of Details -->

@endsection
