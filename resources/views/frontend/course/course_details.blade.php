@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plyr/plyr.css') }}" >
@endsection
@push('meta')
    <meta itemprop="name" content="{{ @$data['course']->meta_title }}">
    <meta itemprop="image" content="{{ showImage(@$data['course']->metaImage->original) }}">
    <meta itemprop="description" content="{{ @$data['course']->meta_description }}">
    <meta name="twitter:title" content="{{ @$data['course']->meta_title }}">
    <meta name="twitter:image" content="{{ showImage(@$data['course']->metaImage->original) }}">
    <meta name="twitter:description" content="{{ @$data['course']->meta_description }}">
    <meta property="og:site_name" content="{{ @$data['course']->meta_title }}" />
    <meta property="og:title" content="{{ @$data['course']->meta_title }}" />
    <meta property="og:description" content="{{ @$data['course']->meta_description }}" />
    <meta property="og:image" content="{{ showImage(@$data['course']->metaImage->original) }}" />
    <meta name="description" content="{{ @$data['course']->meta_description }}">
    <meta name="keywords" content="{{ @$data['course']->meta_keyword }}">

    <style>


    </style>
@endpush
@section('content')
    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->


    <!-- course-details  S t a r t-->
    <div class="ot-course-details section-padding2 mt-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Video -->
                    <div class="video-section mb-60">
                        @if (@$data['course']->course_overview_type == 15)
                            <div class="container video-size ">
                                <div class="plyr__video-embed" id="player">
                                    <iframe id="player" type="text/html" height="500" width="100%"
                                        src="https://www.youtube.com/embed/{{ course_video_url_preg_match(@$data['course']->video_url) }}"
                                        allowfullscreen allowtransparency allow="autoplay"></iframe>
                                </div>
                            </div>
                        @elseif (@$data['course']->course_overview_type == 16)
                            <div class="container video-size">
                                <div width="100px" height="500"id="player" data-plyr-provider="vimeo"
                                    data-plyr-embed-id="{{ course_video_url_preg_match(@$data['course']->video_url) }}">
                                </div>
                            </div>
                        @elseif (@$data['course']->course_overview_type == 17)
                            <video id="player" playsinline controls
                                data-poster="{{ showImage(@$data['course']->thumbnailImage->original) }}" playsinline
                                controls>
                                @if (video_get_video_extension(@$data['course']->video_url) == 'mp4')
                                    <source src="{{ @$data['course']->video_url }}" type="video/mp4" />
                                @elseif (video_get_video_extension(@$data['course']->video_url) == 'webm')
                                    <source src="{{ @$data['course']->video_url }}" type="video/webm" />
                                @endif
                            </video>
                        @endif

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div class="ot-course-details-inner">
                        <h3 class="ot-course-title">{{ @$data['course']->title }}</h3>
                        <div class="d-flex course-author gap-12 align-items-center">
                            <div class="thumb course-widget-author-img">
                                <img class="img-cover"
                                    src=" {{ showImage(@$data['course']->instructor->image->original) }} " alt="img">
                            </div>
                            <div class="author-info">
                                <h5>
                                    <a
                                        href="{{ route('frontend.instructor.details', [$data['course']->user->name, $data['course']->user->id]) }}">
                                        {{ @$data['course']->instructor->name }}
                                    </a>
                                </h5>
                                <p>{{ @$data['course']->instructor->instructor->designation }}</p>
                            </div>
                        </div>
                        <div class="d-flex gap-20 flex-wrap">
                            <div class="flex-fill">
                                <div class="d-flex align-items-center course-star-rating">
                                    <span class="rating-count text-16 mr-2">{{ @$data['course']->rating }} </span>
                                    <span class="text-16 pl-8 pr-8">{{ rating_ui(@$data['course']->rating, '16') }} </span>
                                    <span class="total-rating  "> ( @if ($data['course']->total_review > 0)
                                            {{ numberFormat($data['course']->total_review) }}
                                            {{ ___('frontend.Reviews') }}
                                        @else
                                            {{ numberFormat(0.0) }}
                                        @endif )</span>
                                </div>
                                <div
                                    class="d-flex align-items-center gap-12 course-duration d-flex align-items-center gap-12">
                                    <h5>{{ minutes_to_hours($data['course']->course_duration) }}</h5>
                                    <div class="bulet-rouned"></div>
                                    <span>{{ @$data['course']->lessons->count() }}
                                        {{ ___('frontend.Lesson') }} </span>
                                </div>
                            </div>
                        </div>
                        <p class="course_description"><?= $data['course']->short_description ?></p>

                        <!-- course details tab  -->
                        <ul class="nav course-details-tabs mb-40" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="Overview-tab" data-bs-toggle="tab"
                                    data-bs-target="#Overview" type="button" role="tab" aria-controls="Overview"
                                    aria-selected="true">
                                    <i class="ri-dashboard-line"></i>
                                    <span>{{ ___('frontend.Overview') }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Curriculum-tab" data-bs-toggle="tab"
                                    data-bs-target="#Curriculum" type="button" role="tab" aria-controls="Curriculum"
                                    aria-selected="false">
                                    <i class="ri-file-list-line"></i>
                                    <span>{{ ___('frontend.Curriculum') }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="{{ $data['user_type'] }}-tab" data-bs-toggle="tab"
                                    data-bs-target="#{{ $data['user_type'] }}" type="button" role="tab"
                                    aria-controls="{{ $data['user_type'] }}" aria-selected="false">
                                    <i class="ri-user-2-line"></i>
                                    <span>{{ $data["user_type"] }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Review-tab" data-bs-toggle="tab" data-bs-target="#Review"
                                    type="button" role="tab" aria-controls="Review" aria-selected="false">
                                    <i class="ri-user-2-line"></i>
                                    <span>{{ ___('frontend.Review') }}</span>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="Overview" role="tabpanel"
                                aria-labelledby="Overview-tab">

                                @if (@$data['course']->outcomes)
                                    <!-- course outcomes s t a r t  -->
                                    <div class="course-tab-widget">
                                        <h3 class="course-details-title">
                                            {{ ___('frontend.What You will Learn From This course') }}</h3>
                                        <ul class="course-details-list">
                                            <?= $data['course']->outcomes ?>
                                        </ul>
                                    </div>
                                    <!--End-of outcomes tab  -->
                                @endif

                                @if (@$data['course']->sections->count() > 0)
                                    <!-- course tab curriculam s t a r t  -->
                                    <div class="course-tab-widget">
                                        <h3 class="course-details-title">{{ ___('frontend.Course Curriculum') }}</h3>
                                        <?= $data['curriculum'] ?>

                                    </div>
                                    <!--End-of course tab  -->
                                @endif
                                @if (@$data['course']->requirements)
                                    <!-- course Requirements s t a r t  -->
                                    <div class="course-tab-widget">
                                        <h3 class="course-details-title">{{ ___('frontend.Requirements') }}</h3>
                                        <ul class="course-details-list">
                                            <?= $data['course']->requirements ?>
                                        </ul>
                                    </div>
                                    <!--End-of Requirements tab  -->
                                @endif

                                <!-- course Description s t a r t  -->
                                <div class="course-tab-widget">
                                    <h3 class="course-details-title">{{ ___('frontend.Description') }}</h3>
                                    <ul class="course-details-list">
                                        <?= $data['course']->description ?>
                                    </ul>
                                </div>
                                <!--End-of Description tab  -->

                                <!-- course tab profile s t a r t  -->
                                <div class="course-tab-widget">
                                    <?= $data['profile'] ?>
                                </div>
                                <!--End-of course tab  -->

                                <!-- course tab review s t a r t  -->
                                <div class="course-tab-widget">
                                    <?= $data['review'] ?>
                                </div>
                                <!-- End-of course tab review  -->


                            </div>
                            <div class="tab-pane fade" id="Curriculum" role="tabpanel" aria-labelledby="Curriculum-tab">
                                <!-- course tab curriculam s t a r t  -->
                                <div class="course-tab-widget">
                                    <h3 class="course-details-title">{{ ___('frontend.Course Curriculum') }}</h3>
                                    @if (@$data['course']->sections->count() > 0)
                                        <?= $data['curriculum'] ?>
                                    @else
                                        <div class="text-left">
                                            <p class="text-left">{{ ___('frontend.No Curriculum Found') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <!--End-of course tab  -->
                            </div>
                            <div class="tab-pane fade" id="{{ $data['user_type'] }}" role="tabpanel" aria-labelledby="{{ $data['user_type'] }}-tab">
                                <!-- course tab profile s t a r t  -->
                                <div class="course-tab-widget">
                                    <?= $data['profile'] ?>
                                </div>
                                <!--End-of course tab  -->
                            </div>
                            <div class="tab-pane fade" id="Review" role="tabpanel" aria-labelledby="Review-tab">

                                <!-- course tab review s t a r t  -->
                                <div class="course-tab-widget">
                                    <?= $data['review'] ?>
                                </div>
                                <!-- End-of course tab review  -->

                            </div>
                        </div>
                        <!-- COURSE_DETAILS_TABS::END    -->
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-8" id="course-summary"
                    data-val="{{ encrypt(@$data['course']->id) }}">
                    <div class="course-details-right-box mb-24">
                        <div class="course-details-right-box-inner">
                            <div class="d-flex align-items-center">
                                <div class="current-prise d-flex align-items-center flex-fill">
                                    @if ($data['course']->is_free == 1)
                                        <h4>{{ ___('frontend.Free') }}</h4>
                                    <!-- package course enroll -->
                                    @elseif(module('Subscription') && setting('subscription_setup') && @$data['package_included'])
                                        <h4>{{ ___('frontend.Free') }}</h4> <small class="ml-2 text-tertiary">({{ ___('subscription.Package') }})</small>
                                    <!-- package course enroll end-->
                                    @else

                                        @if ($data['course']->is_discount == 11)
                                            <div class= "pt-4">
                                            <h4>{{ showPrice(discount_price($data['course'])) }}</h4>
                                                <h5 class="text-decoration-line-through m-0 d-inline-block" style="color: #FF4B55">
                                                    {{ showPrice(@$data['course']->price) }}
                                                </h5>
                                                @if ($data['course']->discount_type == 1)
                                                    <h5 class="offer-text d-inline-block ms-2"> - {{ showPrice($data['course']->discount_price) }} </h5>
                                                @else
                                                    <h5 class="offer-text d-inline-block ms-2"> -{{ $data['course']->discount_price }}% </h5>
                                                @endif

                                            </div>
                                        @else
                                            <h4> {{ showPrice(@$data['course']->price) }}</h4>
                                        @endif
                                    @endif
                                </div>
                                <div class="shaire-hert d-flex align-items-center gap-15">
                                    @if (auth()->check() && @$data['course']->userBookmark->count() > 0)
                                        <a href="javascript:void(0)" class="bookmark bookmark-destroy"
                                            data-id="{{ encryptFunction(@$data['course']->id) }}">
                                            <i class="ri-heart-fill"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="bookmark bookmark-added"
                                            data-id="{{ encryptFunction(@$data['course']->id) }}">
                                            <i class="ri-heart-line"></i></a>
                                    @endif
                                </div>
                            </div>
                            @if (auth()->check() &&
                                    auth()->user()->userCourseEnroll->where('course_id', $data['course']->id)->count() > 0)
                                <a @if (@$data['course']->firstLesson) href="{{ route('student.course.learn', [@$data['course']->slug, encryptFunction(@$data['course']->firstLesson->id)]) }}"
                                    @else
                                    href="{{ route('student.course.learn', [@$data['course']->slug, 'no_lesson']) }}" @endif
                                    class="btn-primary-outline w-100">{{ ___('student.Start Learning') }}</a>

                            @else
                                <button
                                    class="btn-primary-fill mb-16 d-flex align-items-center justify-content-center w-100 offer_couter checkout">
                                    {{ ___('frontend.Enroll Now') }}
                                </button>
                                <button
                                    class="btn-primary-outline d-flex align-items-center justify-content-center w-100 add-to-cart">
                                    {{ ___('frontend.Add to cart') }}
                                </button>
                            @endif
                            <div class="course-features">
                                <h4>{{ ___('frontend.This course includes') }}:</h4>
                                <div class="course-feature-list d-flex align-items-center gap-14 ">
                                    <i class="ri-video-line"></i>
                                    <p>{{ minutes_to_hours($data['course']->course_duration) }}
                                        {{ ___('frontend.Hours video') }}</p>
                                </div>
                                <div class="course-feature-list d-flex align-items-center gap-14 ">
                                    <i class="ri-file-line"></i>
                                    <p>{{ $data['course']->lessons->count() }} {{ ___('frontend.Lesson') }}</p>
                                </div>
                                <div class="course-feature-list d-flex align-items-center gap-14 ">
                                    <i class="ri-links-line"></i>
                                    <p>{{ ___('frontend.Full lifetime access') }}</p>
                                </div>
                                <div class="course-feature-list d-flex align-items-center gap-14 ">
                                    <i class="ri-macbook-line"></i>
                                    <p>{{ ___('frontend.Access on mobile and TV') }}</p>
                                </div>
                                <div class="course-feature-list d-flex align-items-center gap-14 ">
                                    <i class="ri-trophy-line"></i>
                                    <p>{{ ___('frontend.Certificate of completion') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of course-details-->

@endsection


@section('scripts')
    <script src="{{ asset('frontend/js/__course.js') }}" type="module"></script>
@endsection
