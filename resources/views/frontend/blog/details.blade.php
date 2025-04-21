@extends('frontend.layouts.master')
@section('title', @$data['title'] ?? 'Blogs')
@section('content')

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->

    <div class="blog-details section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-9">

                    <!-- Share Post -->
                    <div class="d-flex justify-content-between align-items-start">
                        <!-- Blog Post user -->
                        <div class="user-profile2 mb-28">
                            <div class="user-img">
                                <img src="{{ showImage(@$data['blog']->user->image->original, 'default-1.jpeg') }}"
                                    class="img-cover" alt="{{ @$data['blog']->user->name }}">
                            </div>
                            <div class="user-cap">
                                <div class="cap">
                                    <h5><a href="#" class="title font-600"> {{ @$data['blog']->user->name }}</a> </h5>
                                    <p class="pera">{{ @$data['blog']->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Single -->
                    <div class="single-description">
                        <p>{!! @$data['blog']->description !!}</p>
                    </div>

                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ot-card">
                                <!-- Title -->
                                <div class="section-tittle-four mb-20">
                                    <h5 class="title text-capitalize font-600">{{ ___('frontend.Latest Blogs') }}</h5>
                                </div>

                                @if (!empty($data['latest_blogs']))
                                    @foreach ($data['latest_blogs'] as $latest_blog)
                                        <!-- Single -->
                                        <div class="single-blogs single-blogs2 radius-6 white-bg mb-10">
                                            <div class="blog-content-box d-flex align-items-center">
                                                <div class="blog-img imgEffect radius-4">
                                                    <a href="{{ route('blog_details', $latest_blog->id) }}"><img
                                                            src="{{ showImage(@$latest_blog->iconImage->paths['220x300'], 'default-1.jpeg') }}"
                                                            class="img-cover" alt="img"></a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="capt">
                                                        <h3><a href="{{ route('blog_details', $latest_blog->id) }}"
                                                                class="title colorEffect font-600 line-clamp-2">{{ Str::limit(@$latest_blog->title, 60) }}</a>
                                                        </h3>
                                                        <p class="pera line-clamp-1">{{ showDate(@$latest_blog->created_at) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- End-of Blog -->

@endsection
