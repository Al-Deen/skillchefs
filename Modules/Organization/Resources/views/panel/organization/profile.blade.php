@extends('organization::panel.organization.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- My Profile S t a r t -->
    <section class="my-profile-area">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-20">
                    <h2 class="title font-600">{{ ___('organization.My profile') }}</h2>
                    <span class="action-success" id="copyButton" data-url="{{ route('share.profile', ['username' => @$data['organization']->user->username ])}}">
                        <i class="ri-file-copy-line"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="my-profile-wrapper">
                    <div class="my-profile-card radius-6 ot-card">
                        <div class="d-flex flex-wrap align-items-center gap-20 border-bottom mb-20 pb-15 ">
                            <!-- Profile -->
                            <div class="profile-image">
                                <img src="{{ showImage(@$data['organization']->user->image->original, 'default-1.jpeg') }}"
                                    class="img-cover" alt="img">
                            </div>
                            <div class="caption">
                                <h6 class="profile-name font-600">{{ @$data['organization']->user->name }}</h6>
                                <p class="text-14 text-{{ @$data['organization']->user->userStatus->class }}">
                                    {{ @$data['organization']->user->userStatus->name }}
                                </p>
                                <p class="profile-user-name font-500">{{ @$data['organization']->user->email }}</p>
                                <p class="profile-designation mb-10">{{ @$data['organization']->designation }}</p>
                                <div class="country d-flex align-items-center mb-10">
                                    <span class="country text-title font-600">
                                        {{ @$data['organization']->country->name }}</span>
                                    <i class="fi fi-{{ strtolower(@$data['organization']->country->code) }}"></i>
                                </div>
                            </div>
                        </div>

                        <div class="country d-flex align-items-center mb-10">
                            <i class="ri-user-follow-line"></i>
                            <span class="country text-title font-600 ml-10">{{ ___('organization.My Self') }}</span>
                        </div>
                        <p class="pera mb-30">{!! @$data['organization']->about_me !!}</p>
                        <!-- Expertise -->
                        <div class="country d-flex align-items-center mb-10">
                            <i class="ri-tools-line"></i>
                            <span class="country text-title font-600 ml-10">{{ ___('organization.Expertise') }}</span>
                        </div>
                        <!-- Expertise Tag -->
                        <div class="tag-area3">
                            <ul class="listing">
                                @if (@$data['organization']->skills)
                                    @foreach (@$data['organization']->skills as $key => $skill)
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
