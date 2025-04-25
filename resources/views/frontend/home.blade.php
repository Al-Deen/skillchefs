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
            @php
                $featuredCourses = \Modules\CMS\Entities\FeaturedCourse::query()->active()->with('course')->orderBy('id', 'ASC')->limit(8)->get();
                $featuredata['courses'] = $featuredCourses;
                $featuredata['title'] = ___('frontend.Featured Courses');
                $featuredata['url'] = route('courses') . '?type=featured';
            @endphp
            @include('frontend.home.featured_courses')
        @elseif($section->snake_title == 'popular_category')
                @include('frontend.home.popular_category')
        @elseif($section->snake_title == 'latest_courses')

            @php
              $latest = \Modules\Course\Entities\Course::query()->active()->visible()->orderBy('id', 'DESC')->limit(8)->get();
              $latestdata['courses'] = $latest;
              $latestdata['title'] = ___('frontend.Latest Courses');
              $latestdata['url'] = route('courses') . '?sort=latest';
            @endphp
            @include('frontend.home.latest_courses')
        @elseif($section->snake_title == 'best_rated_courses')
            @php
                $courses =\Modules\Course\Entities\Course::query()->active()->visible()->orderBy('rating', 'DESC')->limit(8)->get();
                $bestRateddata['courses'] = $courses;
                $bestRateddata['title'] = ___('frontend.Best Rated Courses');
                $bestRateddata['url'] = route('courses') . '?sort=best_rated';
            @endphp
            @include('frontend.home.best_rated_courses')
        @elseif($section->snake_title == 'discount_courses')
            @php
             $courses = \Modules\Course\Entities\Course::query()->active()->visible()->orderBy('discount_price', 'DESC')->limit(8)->get();

            $discountData['courses'] = $courses;
            $discountData['title'] = ___('frontend.Discount Courses');
            $discountData['url'] = route('courses') . '?type=discount';
            @endphp
            @include('frontend.home.discount_courses')
        @elseif($section->snake_title == 'most_popular_courses')

            @php
               $courses = \Modules\Course\Entities\Course::query()->active()->visible()->orderBy('total_sales', 'DESC')->limit(8)->get();
               $popularCourseData['courses'] = $courses;
               $popularCourseData['title'] = ___('frontend.Most Popular Courses');
               $popularCourseData['url'] = route('courses') . '?sort=popular';
            @endphp
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
            @php
               $blogs = \Modules\Blog\Entities\Blog::query()->active()->with('iconImage')->select('id', 'title', 'description', 'image_id','created_at')->latest()->take(4)->get();
               $blogData['section_title'] = ___('frontend.Our Recent Blogs');
               $blogData['blogs'] = $blogs;
            @endphp
            @include('frontend.home.blogs')
        @elseif($section->snake_title == 'brands')
{{--            @php--}}
{{--                $brands = \Modules\Brand\Entities\Brand::query()->active()->with('iconImage:id,original')->select('id', 'image_id')->orderBy('serial', 'asc')->get();--}}
{{--                $brandsData['section_title'] = ___('frontend.Our Recent Blogs');--}}
{{--               $brandsData['brands'] = $brands;--}}
{{--            @endphp--}}
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
