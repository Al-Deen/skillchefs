@extends('organization::panel.organization.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- organization Courses Start -->
    <section class="instructor-financial">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                    <h2 class="title font-600 mb-20">{{ ___('organization.Sales Report') }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- organization Setting TAB -->
            <ul class="nav course-details-tabs setting-tab mb-40" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.sales_report.course') }}" class="nav-link {{ url()->current() === route('organization.sales_report.course') ? 'active' : '' }}"
                        type="button" role="tab"> <i class="ri-pantone-line"></i>
                        <span>{{ ___('organization.Course') }}</span>
                    </a>
                </li>
                @if (module('Event'))
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.sales_report.event') }}" class="nav-link {{ url()->current() === route('instructor.sales_report.event') ? 'active' : '' }} "
                        type="button" role="tab"> <i class="ri-calendar-2-line"></i>
                        <span>{{ ___('organization.Events') }}</span>
                    </a>
                </li>
                @endif
            </ul>
            @if (url()->current() === route('organization.sales_report.course'))
                <!-- course sales start -->
                @include('organization::panel.organization.partials.report.course')
                <!-- course sales end -->
                @elseif (url()->current() === route('instructor.sales_report.event'))
                <!-- event sales start -->
                @include('event::backend.instructor.partials.report.event')
                <!-- event sales end -->
            @endif
        </div>
        <!--  pagination start -->
        {!! @$data['enrolls']->links('frontend.partials.pagination-count') !!}
        <!--  pagination end -->
    </section>
    <!-- instructor Courses End -->
@endsection
