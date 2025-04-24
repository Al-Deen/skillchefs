@extends('frontend.layouts.master')
@section('title', $data['title'] ?? 'Home')
@section('content')

    @foreach ($data['section'] as $key => $section)
        @if ($section->snake_title == 'slider')
            @php
           $sliders = \Modules\Slider\Entities\Slider::query()
                    ->active()
                    ->with('iconImage:id,original')
                    ->orderBy('serial', 'asc')
                    ->get()
                    ->map(function ($data) {
                        return [
                            'id' => $data->id,
                            'title' => $data->title,
                            'sub_title' => $data->sub_title,
                            'description' => $data->description,
                            'serial' => $data->serial,
                            'image' => showImage(optional($data->iconImage)->original, 'backend/uploads/default-images/hero/hero' . rand(1, 3) . '.jpg'),
                        ];
                    });
            @endphp
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
        @elseif(module('Subscription') && $section->snake_title == 'subscription_packages')
            @include('subscription::frontend.packages')
        @elseif(module('Event') && $section->snake_title == 'event')
            @include('event::frontend.events')
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
@section('scripts')
    <script>
        new Swiper('.banner-active', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@endsection
