@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!-- My Profile S t a r t -->
    <section class="my-profile-area  top-padding pb-90">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="my-profile-wrapper">
                        <div class="my-profile-card radius-6 ot-card">
                            <div class="d-flex flex-wrap align-items-center gap-20 border-bottom mb-20 pb-15 ">
                                <!-- Profile -->
                                <div class="profile-image">
                                    <img src="{{ showImage(@$data['instructor']->user->image->original, 'default-1.jpeg') }}"
                                        class="img-cover" alt="img">
                                </div>
                                <div class="caption">
                                    <h6 class="profile-name font-600">{{ @$data['instructor']->user->name }}</h6>
                                    <p class="text-14 text-{{ @$data['instructor']->user->userStatus->class }}">
                                        {{ @$data['instructor']->user->userStatus->name }}
                                    </p>
                                    <p class="profile-user-name font-500">{{ @$data['instructor']->user->email }}</p>
                                    <p class="profile-designation mb-10">{{ @$data['instructor']->designation }}</p>
                                    <div class="country d-flex align-items-center mb-10">
                                        <span class="country text-title font-600">
                                            {{ @$data['instructor']->country->name }}</span>
                                        <i class="fi fi-{{ strtolower(@$data['instructor']->country->code) }}"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="country d-flex align-items-center mb-10">
                                <i class="ri-user-follow-line"></i>
                                <span class="country text-title font-600 ml-10">{{ ___('instructor.My Self') }}</span>
                            </div>
                            <p class="pera mb-30">{!! @$data['instructor']->about_me !!}</p>


                            <div class="country d-flex align-items-center mb-10">
                                <i class="ri-briefcase-line"></i>
                                <span
                                    class="country text-title font-600 ml-10">{{ ___('instructor.Current Status') }}</span>
                            </div>
                            <div class="row">
                                @php $totalMonth = 0; @endphp
                                @if (@$data['instructor']->experience)
                                    @foreach (@$data['instructor']->experience as $key => $experience)
                                        <?php
                                        $months = totalMonths($experience['start_date'], $experience['end_date']);
                                        $totalMonth += $months;
                                        ?>
                                        <div class="col-xl-12">
                                            <div
                                                class="single-education mb-30 d-flex justify-content-between align-items-start">
                                                <div class="education-cap">
                                                    <h4 class="text-18 text-tile mb-15">
                                                        <a href="#">
                                                            {{ @$experience['title'] }}
                                                        </a>
                                                    </h4>
                                                    <p class="pera text-primary mb-6">
                                                        {{ @$experience['name'] }} -
                                                        <span
                                                            class="text-title text-capitalize">{{ str_replace('_', ' ', @$experience['employee_type']) }}</span>

                                                    </p>
                                                    <p class="pera mb-6">
                                                        {{ date('M y', strtotime(@$experience['start_date'])) }} -
                                                        @if (@$experience['current'])
                                                            {{ ___('instructor.Present') }} .
                                                            {{ \Carbon\Carbon::parse(@$experience['start_date'])->diffForHumans() }}
                                                        @else
                                                            {{ date('M y', strtotime(@$experience['end_date'])) }}
                                                        @endif
                                                    </p>
                                                    <p class="pera mb-20">
                                                        {{ @$experience['location'] }}
                                                    </p>
                                                    <p class="pera mb-6">
                                                        <?= @$experience['description'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <!-- Educations end -->
                            </div>

                            <!-- Experience -->
                            <div class="country d-flex align-items-center mb-10">
                                <span
                                    class="country text-title font-600">{{ ___('instructor.Years of Experience') }}</span>
                            </div>
                            <p class="pera mb-20">{{ monthsToYearAndMonth(@$totalMonth) }}</p>


                            <!--Educations  -->
                            <div class="country d-flex align-items-center mb-10">
                                <i class="ri-book-open-line"></i>
                                <span class="country text-title font-600 ml-10">{{ ___('instructor.Educations') }}</span>
                            </div>
                            <div class="row">
                                @if (@$data['instructor']->education)
                                    @foreach (@$data['instructor']->education as $key => $institute)
                                        <div class="col-xl-12">
                                            <div
                                                class="single-education mb-30 d-flex justify-content-between align-items-start">

                                                <div class="education-cap">
                                                    <h4 class="text-18 text-tile mb-15">
                                                        <a href="#">
                                                            {{ @$institute['name'] }}
                                                        </a>
                                                    </h4>
                                                    <p class="pera text-primary mb-6">
                                                        {{ @$institute['degree'] }} - {{ @$institute['program'] }}

                                                    </p>
                                                    <p class="pera mb-20">
                                                        {{ date('M Y', strtotime(@$institute['start_date'])) }} -
                                                        @if (@$institute['current'])
                                                            {{ ___('instructor.Continue') }}
                                                        @else
                                                            {{ date('M Y', strtotime(@$institute['end_date'])) }}
                                                        @endif
                                                    </p>
                                                    <p class="pera mb-6">
                                                        <?= @$institute['description'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <!-- Educations end -->
                            </div>

                            <!-- Expertise -->
                            <div class="country d-flex align-items-center mb-10">
                                <i class="ri-tools-line"></i>
                                <span class="country text-title font-600 ml-10">{{ ___('instructor.Expertise') }}</span>
                            </div>

                            <!-- Expertise Tag -->
                            <div class="tag-area3">
                                <ul class="listing">
                                    @if (@$data['instructor']->skills)
                                        @foreach (@$data['instructor']->skills as $key => $skill)
                                            <li class="single-list">{{ @$skill['value'] }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of Profile -->
@endsection
