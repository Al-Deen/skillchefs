@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--Bradcam S t a r t -->


    <!-- GET IN TOUCH::START  -->
    <div class="ot-sidebar-overlay"></div>
    <section class="ot-filter-course section-padding2 mt-10" id="course_list">
        <div class="container">
            <div class="row">
                <!-- Courese Search -->
                <div class="col-lg-12">
                    <div class="searching-course mb-20">
                        <div class="grid-list-view d-flex flex-wrap justify-content-between align-items-center gap-15">
                            <!-- results total -->
                            <span class="tag-cout text-tertiary text-16 font-600 mr-10" id="showResults"></span>
                            <!-- End result total -->

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-15">
                                <!-- search-tab -->
                                <div class="search-tab">
                                    <button
                                        class="tab-btn btn-options @if (@$_GET['sort'] == 'best_rated') text-primary @endif"
                                        data-val="best_rated">{{ ___('frontend.Best Rated') }}</button>
                                    <button
                                        class="tab-btn btn-options @if (@$_GET['sort'] == 'popular') text-primary @endif"
                                        data-val="popular">{{ ___('frontend.Most Popular') }}</button>
                                    <button
                                        class="tab-btn btn-options @if (@$_GET['sort'] == 'latest') text-primary @endif"
                                        data-val="new">{{ ___('frontend.Latest') }}</button>
                                    <button class="tab-btn btn-options"
                                        data-val="highest_price">{{ ___('frontend.Highest Price') }}</button>
                                    <button class="tab-btn btn-options"
                                        data-val="lowest_price">{{ ___('frontend.Lowest Price') }}</button>
                                    @if (@$_GET['type'])
                                        <button class="tab-btn btn-options text-primary"
                                            data-val="{{$_GET['type']}}">{{ Str::ucfirst($_GET['type']) }}</button>
                                    @endif
                                </div>

                                <!-- Tab & Grid View -->
                                <div class="tab-grid">
                                    <button class="tab-view active"><i class="ri-dashboard-line"></i></button>
                                    <button class="grid-view"><i class="ri-list-check"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- start Left Sidebar -->
                <div class="col-xl-3 col-lg-3">
                    @include('frontend.partials.sidebar_course')
                </div>
                <!-- end left Sidebar -->
                <!-- Right Content Result -->
                <div class="col-xl-9 col-lg-9">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <!-- Search-Tab -->
                        <div class="search-tags flex-grow-1 bd-highlight">

                        </div>
                    </div>

                    <!-- list & Grid  view -->
                    <div class="item-list mb-24" id="course-load">

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('frontend/js/__filter.js') }}"></script>
@endsection
