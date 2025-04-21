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
                @foreach ($data['blogs'] as $key => $blog)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="blog-single h-calc">
                            <div class="blog-img-cap">
                                <div class="blog-img imgEffect">
                                    <a href="{{ route('blog_details', $blog->id) }}">
                                        <img src="{{ showImage(@$blog->iconImage->original, 'backend/uploads/default-images/blog/blog'.$key + 1 .'.jpg') }}" alt="img"
                                            class="img-cover">
                                    </a>
                                </div>
                                <div class="blog-cap">
                                    <h3><a href="{{ route('blog_details', $blog->id) }}"
                                            class="title colorEffect line-clamp-2 font-600">{{ Str::limit(@$blog->title, 20) }}</a>
                                    </h3>
                                    <p class="pera mb-15">{{ Str::limit(strip_tags(@$blog->description), 100) }}</p>
                                    <p class="font-600">{{ $blog->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ $data['blogs']->links('frontend.layouts.partials.pagination') }}
                </div>
            </div>

        </div>
    </section>
    <!-- End-of Blog -->
@endsection
