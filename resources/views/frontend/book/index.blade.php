@extends('frontend.layouts.master')
@section('title', @$data['title'] ?? 'Blogs')
@section('content')
    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->
    <!-- Blog Area S t a r t -->
    <section class="blog-area section-padding">
        <div class="container">
            <div class="row g-24">
                @foreach ($data['books'] as $key => $book)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="blog-single h-calc radius-8">
                            <div class="blog-img-cap">
                                <div class="blog-img imgEffect">
                                    <a href="{{ route('frontend.bookDetails', $book->slug) }}">
                                        <img src="{{ asset($book->thumbnail) }}"
                                             alt="img" class="img-cover">
                                    </a>
                                </div>
                                <div class="blog-cap">
                                    <a href="{{ route('frontend.bookDetails', $book->slug) }}">
                                        <h4 class="title colorEffect line-clamp-2 text-15 font-500">
                                            {{ @$book->title }}
                                        </h4>
                                    </a>
                                    @if (@$book->user->role_id != 5)
                                        <div class="course-widget-author d-flex align-items-center">
                                            <div class="course-widget-author-img">
                                                <img src="{{ showImage(@$book->user->image->original) }}" class="img-cover" alt="img">
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);">
                                                    <h4 class="text-14 font-500 text-primary-hover  mb-0">{{ @$book->user->name }}</h4>
                                                </a>
                                                <p class="text-gray text-12 font-400  line-clamp-1">{{ ___('common.Admin') }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="course-widget-author d-flex align-items-center">
                                            <div class="course-widget-author-img">
                                                <img src="{{ showImage(@$book->user->image->original) }}" class="img-cover" alt="img">
                                            </div>
                                            <div class="">
                                                <a href="{{ route('frontend.instructor.details', [$book->user->name, $book->user->id]) }}">
                                                    <h4 class="text-14 font-500 text-primary-hover  mb-0">{{ @$book->user->name }}</h4>
                                                </a>
                                                <p class="text-gray text-12 font-400  line-clamp-1">{{ @$book->user->instructor->designation }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="widget-footer">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="pricing mt-2">
                                                @if ($book->is_free == 1)
                                                    <h4>{{ ___('frontend.Free') }}</h4>
                                                @else
                                                    <h4 class="prev-prise">
                                                        <span>{{ showPrice($book->price) }}</span>
                                                    </h4>
                                                @endif
                                            </div>
                                            <a href="{{ route('frontend.bookDetails', $book->slug) }}" class="btn-primary-outline mb-10"><i
                                                    class="ri-shopping-cart-line"></i> {{ ___('frontend.Enroll') }} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ $data['books']->links('frontend.layouts.partials.pagination') }}
                </div>
            </div>

        </div>
    </section>
    <!-- End-of Blog -->
@endsection
