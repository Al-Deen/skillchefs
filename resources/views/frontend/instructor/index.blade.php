@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->
    <!-- Get-in touch S t a r t-->
    <div class="ot-sidebar-overlay"></div>
    <section class="ot-filter-course section-padding2 mt-10" id="instructor_list">
        <div class="container">
            <div class="row">
                <!-- Left Sidebar -->
                <div class="col-xl-3 col-lg-3">
                    @include('frontend.partials.sidebar_instructor')
                </div>
                <!-- Right Content Result -->
                <div class="col-xl-9 col-lg-9" id="course-load">

                </div>
            </div>
        </div>
    </section>
    <!-- Get-in touch S t a r t-->

@endsection

@section('scripts')
    <script src="{{ asset('frontend/js/__filter.js') }}"></script>
@endsection
