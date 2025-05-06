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

                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div class="ot-course-details-inner">
                        <h3 class="ot-course-title">{{ @$data['book']->title }}</h3>
                        <div class="d-flex course-author gap-12 align-items-center">
                            <div class="thumb course-widget-author-img">
                                <img class="img-cover"
                                    src=" {{ showImage(@$data['book']->instructor->image->original) }} " alt="img">
                            </div>
                            <div class="author-info">
                                <h5>
                                    <a
                                        href="{{ route('frontend.instructor.details', [$data['book']->user->name, $data['book']->user->id]) }}">
                                        {{ @$data['book']->instructor->name }}
                                    </a>
                                </h5>
                                <p>{{ @$data['book']->instructor->instructor->designation }}</p>
                            </div>
                        </div>
                        <div class="d-flex gap-20 flex-wrap">
                            <div class="flex-fill">
{{--                                <div class="d-flex align-items-center course-star-rating">--}}
{{--                                    <span class="rating-count text-16 mr-2">{{ @$data['course']->rating }} </span>--}}
{{--                                    <span class="text-16 pl-8 pr-8">{{ rating_ui(@$data['course']->rating, '16') }} </span>--}}
{{--                                    <span class="total-rating  "> ( @if ($data['course']->total_review > 0)--}}
{{--                                            {{ numberFormat($data['course']->total_review) }}--}}
{{--                                            {{ ___('frontend.Reviews') }}--}}
{{--                                        @else--}}
{{--                                            {{ numberFormat(0.0) }}--}}
{{--                                        @endif )</span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <p class="course_description"><?= $data['book']->description ?></p>

                        <!-- course details tab  -->

                        <!-- COURSE_DETAILS_TABS::END    -->
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
