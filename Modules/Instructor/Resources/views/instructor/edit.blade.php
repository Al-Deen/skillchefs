@extends('backend.master')

@section('title', @$data['title'])
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
@endpush
@section('content')
<div>
    @include('instructor::instructor.partials.tab')
    @if (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'general']))
        <!-- profile body start -->
        @include('instructor::instructor.partials.general')
        <!-- profile body form end -->
    @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'security']))
        <!-- profile body start -->
        @include('instructor::instructor.partials.security')
        <!-- profile body form end -->
    @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'educations']))
        <!-- profile body start -->
        @include('instructor::instructor.partials.educations')
        <!-- profile body form end -->
    @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'experiences']))
        <!-- profile body start -->
        @include('instructor::instructor.partials.experiences')
        <!-- profile body form end -->
    @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'skill']))
        <!-- profile body start -->
        @include('instructor::instructor.partials.skill')
        <!-- profile body form end -->
    @elseif (url()->current() === route('admin.instructor.edit', [$data['instructor']->id, 'commission']))
        <!-- profile body start -->
        @include('instructor::instructor.partials.commission')
        <!-- profile body form end -->
    @endif
</div>
@endsection

@push('script')
    <script src="{{ asset('backend/assets/js/tagify.js') }}"></script>
@endpush
