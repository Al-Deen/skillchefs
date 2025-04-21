@extends('panel.instructor.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('modules/event/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/event/summernote/summernote.css') }}">
@endsection

@section('title', @$data['title'])
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                <h2 class="title font-600 mb-20">{{ ___('event.Edit Event') }}</h2>
            </div>
        </div>
        <div class="col-xl-12">
            <ul class="nav course-details-tabs setting-tab mb-40" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.event.edit', request()->id) }}" class="nav-link {{ url()->current() === route('instructor.event.edit', request()->id) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-pencil-line"></i> <span> {{ ___('instructor.General') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.event.speaker.index', request()->id) }}" class="nav-link {{ url()->current() === route('instructor.event.speaker.index', request()->id) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-user-line"></i> <span> {{ ___('instructor.Speakers') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.event.organizer.index', request()->id) }}" class="nav-link {{ url()->current() === route('instructor.event.organizer.index', request()->id) ? 'active' : '' }} "
                        type="button" role="tab">
                        <i class="ri-building-4-line"></i><span> {{ ___('instructor.Organizer') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('event.instructor.schedule.index', request()->id) }}" class="nav-link {{ url()->current() === route('event.instructor.schedule.index', request()->id) ? 'active' : '' }} "
                        type="button" role="tab">
                        <i class="ri-calendar-todo-fill"></i><span> {{ ___('instructor.Schedules') }}</span>
                    </a>
                </li>
            </ul>
            @if(url()->current() == route('instructor.event.edit', request()->id))
            @include('event::backend.instructor.event.details')
            @elseif(url()->current() == route('instructor.event.speaker.index', request()->id))
            @include('event::backend.instructor.event.speakers')
            @elseif(url()->current() == route('instructor.event.organizer.index', request()->id))
            @include('event::backend.instructor.event.organizers')
            @elseif(url()->current() == route('event.instructor.schedule.index', request()->id))
            @include('event::backend.instructor.event.schedule.index')
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/modules/event/summernote/summernote.js') }}"></script>
    <script src="{{ asset('/modules/event/js/app.js') }}"></script>
@endsection
