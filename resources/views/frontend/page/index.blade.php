@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->

    <!-- About section S t a r t-->
    <section class="about-seciton section-padding2 mt-10">
        <div class="container">
            <div class="row justify-content-center">
                @if ($data['page']->type == 3)
                    <div class="@if ($data['page']->widget_type == 1) col-lg-12 @else col-lg-6 @endif">
                        <div class="ot-about-thumb mb-30 position-relative">
                            <img class="featue-thumb-large img-fluid w-100" src="{{ showImage(@$data['page']->image->original) }}"
                                alt="img">
                        </div>
                    </div>

                    <div class="@if ($data['page']->widget_type == 1) col-lg-12 @else col-lg-6 @endif">
                        <div class="description_one">
                            <?= @$data['page']->content ?>
                        </div>
                    </div>
                @elseif ($data['page']->type == 2)
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="ot-about-thumb mb-30 position-relative">
                            <img class="featue-thumb-large img-fluid w-100" src="{{ showImage(@$data['page']->image->original) }}"
                                alt="img">
                        </div>
                    </div>
                @else
                    <div class=" col-lg-12">
                        <div class="terms-conditons">
                            {!! @$data['page']->content !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!--End-of About section -->

    @foreach ($data['section'] as $key => $section)
        @if ($section->snake_title == 'slider')
            @include('frontend.home.hero_area')
        @elseif($section->snake_title == 'featured_courses')
            @include('frontend.home.featured_courses')
        @elseif($section->snake_title == 'popular_category')
            @include('frontend.home.popular_category')
        @elseif($section->snake_title == 'latest_courses')
            @include('frontend.home.latest_courses')
        @elseif($section->snake_title == 'best_rated_courses')
            @include('frontend.home.best_rated_courses')
        @elseif($section->snake_title == 'discount_courses')
            @include('frontend.home.discount_courses')
        @elseif($section->snake_title == 'most_popular_courses')
            @include('frontend.home.most_popular_courses')
        @elseif($section->snake_title == 'become_an_instructor')
            @include('frontend.home.become_an_instructor')
        @elseif($section->snake_title == 'testimonials')
            @include('frontend.home.testimonials')
        @elseif($section->snake_title == 'blogs')
            @include('frontend.home.blogs')
        @elseif($section->snake_title == 'brands')
            @include('frontend.home.brands')
        @endif
    @endforeach

@endsection
