@extends('backend.master')

@section('title', @$data['title'])
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
@endpush
@section('content')
    <div>
        @include('student::student.partials.tab')
        @if (url()->current() === route('admin.student.edit', [$data['student']->id, 'general']))
            <!-- profile body start -->
            @include('student::student.partials.general')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.student.edit', [$data['student']->id, 'security']))
            <!-- profile body start -->
            @include('student::student.partials.security')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.student.edit', [$data['student']->id, 'educations']))
            <!-- profile body start -->
            @include('student::student.partials.educations')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.student.edit', [$data['student']->id, 'experiences']))
            <!-- profile body start -->
            @include('student::student.partials.experiences')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.student.edit', [$data['student']->id, 'skill']))
            <!-- profile body start -->
            @include('student::student.partials.skill')
            <!-- profile body form end -->
        @endif
    </div>

@endsection

@push('script')
    <script src="{{ asset('backend/assets/js/tagify.js') }}"></script>
@endpush
