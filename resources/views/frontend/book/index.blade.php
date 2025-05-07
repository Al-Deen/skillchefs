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
                        <div class="blog-single h-calc">
                            <div class="blog-img-cap">
                                <div class="blog-img imgEffect">
                                    <a href="{{ route('frontend.bookDetails', $book->slug) }}">
                                        <img src="{{ asset(@$book->thumbnail) }}" alt="img"
                                            class="img-cover">
                                    </a>
                                </div>
                                <div class="blog-cap">
                                    <h5><a href="{{ route('frontend.bookDetails', $book->slug) }}"
                                            class="title colorEffect line-clamp-2">{{ @$book->title }}</a>
                                    </h5>
                                    <p><strong>{{@$book->instructor->name}}</strong></p>
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
