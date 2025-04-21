@extends('panel.student.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- My Profile S t a r t -->
    <section class="my-profile-area">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-20">
                    <h2 class="title font-600">{{ @$data['title'] }}</h2>
                    <span class="action-success" id="copyButton"
                        data-url="{{ route('share.profile', ['username' => @$data['student']->user->username]) }}">
                        <i class="ri-file-copy-line"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="my-profile-wrapper">
                    <div class="my-profile-card radius-6 mb-24 ot-card">
                        <div class="d-flex flex-wrap align-items-center gap-20 border-bottom mb-20 pb-15 ">
                            <div class="profile-image">
                                <img src="{{ showImage(@$data['student']->user->image->original) }}" class="img-cover"
                                    alt="img">
                            </div>
                            <div class="caption">
                                <h6 class="profile-name font-600">{{  @$data['student']->user->name }}</h6>
                                <p class="profile-designation mb-20">{{ @$data['student']->designation }}</p>
                                <div class="country d-flex align-items-center pb-20 mb-10">
                                    <span class="country text-title font-600">
                                        {{ @$data['student']->country->name }}
                                    </span>
                                    <i class="fi fi-{{ strtolower(@$data['student']->country->code) }}"></i>
                                </div>
                            </div>
                        </div>

                        <div class="country d-flex align-items-center mb-10">
                            <i class="ri-user-follow-line"></i>
                            <span class="country text-title font-600 ml-10">{{ ___('student.About') }}</span>
                        </div>
                        <p class="pera mb-30"><?= @$data['student']->about_me ?></p>


                        <div class="country d-flex align-items-center mb-10 border-bottom">
                            <i class="ri-briefcase-line"></i>
                            <span class="country text-title font-600 ml-10">{{ ___('student.Experiences') }}</span>
                        </div>

                        <div class="row">
                            @if (@$data['student']->experience)
                                @foreach (@$data['student']->experience as $key => $experience)
                                    <div class="col-xl-12">
                                        <div
                                            class="single-education mb-30 d-flex justify-content-between align-items-start">
                                            <div class="education-cap">
                                                <h5 class="text-16 text-tile mb-15">
                                                    <a href="#">
                                                        {{ @$experience['title'] }}
                                                    </a>
                                                </h5>
                                                <p class="pera text-primary mb-6">
                                                    {{ @$experience['name'] }} -
                                                    <span
                                                        class="text-title text-capitalize">{{ str_replace('_', ' ', @$experience['employee_type']) }}</span>

                                                </p>
                                                <p class="pera mb-6">
                                                    {{ date('M y', strtotime(@$experience['start_date'])) }} -
                                                    @if (@$experience['current'])
                                                        {{ ___('student.Present') }} .
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


                        <!--Educations  -->
                        <div class="country d-flex align-items-center mb-10 border-bottom">
                            <i class="ri-book-open-line"></i>
                            <span class="country text-title font-600 ml-10">{{ ___('student.Educations') }}</span>
                        </div>

                        <div class="row">
                            @if (@$data['student']->education)
                                @foreach (@$data['student']->education as $key => $institute)
                                    <div class="col-xl-12">
                                        <div
                                            class="single-education mb-30 d-flex justify-content-between align-items-start">

                                            <div class="education-cap">
                                                <h5 class="text-16 text-tile mb-15">
                                                    <a href="#">
                                                        {{ @$institute['name'] }}
                                                    </a>
                                                </h5>
                                                <p class="pera text-primary mb-6">
                                                    {{ @$institute['degree'] }} - {{ @$institute['program'] }}

                                                </p>
                                                <p class="pera mb-20">
                                                    {{ date('M y', strtotime(@$institute['start_date'])) }} -
                                                    @if (@$institute['current'])
                                                        {{ ___('student.Continue') }}
                                                    @else
                                                        {{ date('M y', strtotime(@$institute['end_date'])) }}
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
                        </div>
                        <!-- Educations end -->

                        <!-- Expertise -->
                        <div class="country d-flex align-items-center mb-10">
                            <i class="ri-tools-line"></i>
                            <span class="country text-title font-600 ml-10">{{ ___('student.Skills & Expertise') }}</span>
                        </div>

                        <!-- Expertise Tag -->
                        <div class="tag-area3">

                            <ul class="listing">
                                @if (@$data['student']->skills)
                                    @foreach (@$data['student']->skills as $key => $skill)
                                        <li class="single-list">{{ @$skill['value'] }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of Profile -->
@endsection
