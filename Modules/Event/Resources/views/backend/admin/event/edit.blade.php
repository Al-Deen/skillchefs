@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('modules/event/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/event/summernote/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
@endpush
@section('content')
    <div class="page-content">
        @include('event::backend.admin.partials.tab')
        @if (url()->current() === route('event.admin.edit', [$data['event']->id]))
            <!-- profile body start -->
            @include('event::backend.admin.event.details')
            <!-- profile body form end -->
        @elseif (url()->current() === route('event.admin.speaker.index', [$data['event']->id]))
            <!-- profile body start -->
            @include('event::backend.admin.event.speaker')
            <!-- profile body form end -->
        @elseif (url()->current() === route('event.admin.organizer.index', [$data['event']->id]))
            <!-- profile body start -->
            @include('event::backend.admin.event.organizer')
            <!-- profile body form end -->
        @elseif (url()->current() === route('event.admin.schedule.index', [$data['event']->id]))
            <!-- profile body start -->
            @include('event::backend.admin.event.schedule')
            <!-- profile body form end -->
        @elseif (url()->current() === route('event.admin.schedules_timeline.index', [$data['event_schedule']->id]))
            <!-- profile body start -->
            @include('event::backend.admin.event.schedule_timeline')
            <!-- profile body form end -->
        @endif
    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
    <script src="{{ asset('/modules/event/summernote/summernote.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tagify.js') }}"></script>
    <script src="{{ asset('/modules/event/js/app.js') }}"></script>
@endpush

