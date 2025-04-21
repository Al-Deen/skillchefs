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


                        #########################



                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- End-of Blog -->

@endsection
