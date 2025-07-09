@extends('panel.ambassador.layouts.master')

@section('title', @$data['title'])
@section('content')

    <!-- Dashboard Card S t a r t -->
    <div class="dashboared-card mb-24">
        <div class="row g-24">
            <div class="col-xl-3 col-sm-6">
                <div class="single-dashboard-card carts-bg-one h-calc d-flex align-items-center">
                    <div class="cat-caption">
                        <p class="pera text-white  text-center font-600">ID</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ @$data['ambassador']->user->username }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="single-dashboard-card carts-bg-two h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-book-open-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-white text-16 font-600">{{ ___('instructor.Total Courses') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number(@$data['ambassador']->user->courses ? @$data['ambassador']->user->courses->count() : 0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="single-dashboard-card carts-bg-three h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-movie-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-white text-16 font-600">{{ ___('instructor.Total Enrollments') }} </p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number(@$data['ambassador']->user->courseEnroll ? @$data['ambassador']->user->courseEnroll->count() : 0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="single-dashboard-card carts-bg-four h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-user-add-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-white text-16 font-600">{{ ___('instructor.Total Students') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number(@$data['ambassador']->user->courseEnroll ? @$data['ambassador']->user->courseEnroll->groupBy('user_id')->count() : 0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of card -->


@endsection

