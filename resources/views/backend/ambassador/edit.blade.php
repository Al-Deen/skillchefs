@extends('backend.master')

@section('title', @$data['title'])
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
@endpush
@section('content')
    <div>
        @include('backend.ambassador.partials.tab')
        @if (url()->current() === route('admin.ambassador.edit', [$data['ambassador']->id, 'general']))
            <!-- profile body start -->
            @include('backend.ambassador.partials.general')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'security']))
            <!-- profile body start -->
            @include('backend.ambassador.partials.security')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'educations']))
            <!-- profile body start -->
            @include('backend.ambassador.partials.educations')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'experiences']))
            <!-- profile body start -->
            @include('backend.ambassador.partials.experiences')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'skill']))
            <!-- profile body start -->
            @include('backend.ambassador.partials.skill')
            <!-- profile body form end -->
        @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'commission']))
            <!-- profile body start -->
            @include('backend.ambassador.partials.commission')
            <!-- profile body form end -->
        @endif
    </div>
@endsection

@push('script')
    <script src="{{ asset('backend/assets/js/tagify.js') }}"></script>
@endpush
