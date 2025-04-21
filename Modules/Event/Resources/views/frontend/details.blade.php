@extends('frontend.layouts.master')
@section('title', @$data['title'] ?? 'Blogs')

@section('css')
    <link rel="stylesheet" href="{{ asset('modules/event/css/style.css') }}">
@endsection



@section('content')
    <div class="event-css">
        {{-- Event Hero Section --}}
        <div class="event-hero-section padding-event-hero sectionImg-bg2 overlay"
            style="background-image:url('{{ showImage(@$data['event']->image->original, 'backend/uploads/default-images/event/event-'.@$data['event']->category->id .'.jpg') }}')">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="event-contents text-center mb-30">
                            <h3 class="title font-700 text-white">{{ @$data['event']->title }}</h3>
                            <ul class="listing d-flex gap-30 flex-wrap justify-content-center">
                                <li class="single-list text-white">
                                    <i class="ri-calendar-line"></i>
                                    <p class="pera text-white">{{ @$data['event']->start->format('d M Y') }}
                                        @if (showDate(@$data['event']->start) != showDate(@$data['event']->end))
                                            - {{ @$data['event']->end->format('d M Y') }}
                                        @endif
                                    </p>
                                </li>
                                <li class="single-list text-white">
                                    @if (@$data['event']->event_type == 'offline')
                                        <i class="ri-map-pin-line"></i>
                                        <p class="pera text-white">{{ @$data['event']->event_type }}</p>
                                    @else
                                        <i class="ri-focus-line"></i>
                                        <p class="pera text-white">{{ @$data['event']->event_type }}</p>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <!-- Timer -->
                        <div class="date-timer mb-20" id="timer_panel">
                            <div class="d-flex gap-15 justify-content-center">
                                <div class="single">
                                    <div class="cap">
                                        <span class="time" id="countdown_day">00</span>
                                        <p class="cap">{{ ___('event.Days') }}</p>
                                    </div>
                                </div>
                                <span class="clone">:</span>
                                <div class="single">
                                    <span class="time" id="countdown_hour">00</span>
                                    <p class="cap">{{ ___('event.Hours') }}</p>
                                </div>
                                <span class="clone">:</span>
                                <div class="single">
                                    <span class="time" id="countdown_minute">00</span>
                                    <p class="cap">{{ ___('event.Mins') }}</p>
                                </div>
                                <span class="clone">:</span>
                                <div class="single">
                                    <span class="time" id="countdown_second">00</span>
                                    <p class="cap">{{ ___('event.Secs') }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- /E n d -->
                    </div>
                </div>
            </div>
        </div>
        {{-- End-of Event Hero Section --}}

        {{-- Top Cart --}}
        <div class="container">
            <div class="event-cart-top">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex gap-10 justify-content-between flex-wrap">
                            <ul class="listing d-flex gap-30 flex-wrap ">
                                <li class="single-list text-white">
                                    <span class="text-primary text-16 d-block font-500">{{ ___('event.Date') }}</span>
                                    <p class="pera text-title text-18 font-500 d-block">
                                        {{ @$data['event']->start->format('d M Y') }}</p>
                                </li>
                                <li class="single-list text-white">
                                    <span class="text-primary text-16 d-block font-500">{{ ___('event.Time') }}</span>
                                    <p class="pera text-title text-18 font-500 d-block">
                                        {{ @$data['event']->start->format('h:i A') }}</p>
                                </li>
                                <li class="single-list text-white">
                                    <span
                                        class="text-primary text-16 d-block font-500">{{ ___('event.Participants') }}</span>
                                    <p class="pera text-title text-18 font-500 d-block ">
                                        {{ @$data['event']->max_participant }} {{ ___('event.Persons') }}</p>
                                </li>
                            </ul>
                            <div class="buttons-price d-flex gap-40 flex-wrap align-items-center">
                                <div class="price">
                                    <span
                                        class="font-500 d-block text-capitalize text-title">{{ ___('event.Price') }}</span>
                                    <span
                                        class="price font-700 text-primary d-block">{{ @$data['event']->isPaid() }}</span>
                                </div>
                                <div class="d-flex justify-content-center">

                                    @if (@$data['event']->created_by != auth()->id())

                                        @if (@$data['event']->paid_register_student)
                                            <button class="btn" disabled>
                                                {{ ___('event.Registered') }}
                                            </button>
                                        @elseif(@$data['event']->isPaid() === 'Free')
                                            <a href="{{ route('frontend.event.join.event', ['event' => @$data['event']->slug]) }}"
                                                class="btn-primary-fill">
                                                {{ ___('event.Join') }}
                                            </a>
                                        @else
                                            @if (@$data['event']->status_id == 4 && $data['event']->visibility_id == 22)
                                                <a href="{{ route('frontend.event.checkout.index', ['event' => @$data['event']->slug]) }}"
                                                    class="btn-primary-fill">
                                                    {{ ___('event.Booking Now') }}
                                                </a>
                                            @endif
                                        @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End-to top cart --}}
        {{-- Events discriptins --}}
        <div class="event-discriptions mt-40 bottom-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">

                        {{-- Single --}}
                        <div class="ot-card3 shadows mb-24 p-4">
                            {!! @$data['event']->description !!}
                        </div>

                        {{-- Schedule --}}
                        @if ($data['event']->activeSchedule->count() > 0)
                            <div class="ot-card3 shadows mb-24 p-4">
                                {{-- Schedule --}}
                                <div class="single-terms">
                                    <h5 class="title font-600">{{ ___('event.Schedule') }}</h5>
                                    <!--  TAB -->
                                    <ul class="nav schedule-tab mb-50" id="myTab" role="tablist">
                                        @foreach ($data['event']->activeSchedule as $index => $scheduleItem)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link{{ $index === 0 ? ' active' : '' }}"
                                                    id="tab-{{ $index }}" data-bs-toggle="tab"
                                                    data-bs-target="#content-{{ $index }}" type="button"
                                                    role="tab" aria-controls="content-{{ $index }}"
                                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                    <span class="title d-block">{{ $scheduleItem->title }}</span>
                                                    <p class="pera d-block">
                                                        {{ date('d M Y', strtotime($scheduleItem->date)) }}</p>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{-- End Tab --}}

                                    {{-- Contents --}}
                                    <div class="tab-content" id="myTabContent">
                                        @foreach ($data['event']->activeSchedule as $index => $schedule)
                                            <div class="tab-pane fade{{ $index === 0 ? ' show active' : '' }}"
                                                id="content-{{ $index }}" role="tabpanel"
                                                aria-labelledby="tab-{{ $index }}">

                                                @forelse ($schedule->activeScheduleList as $item)
                                                    <div class="row border-bottom-style">
                                                        <div class="col-xl-4 col-lg-5 col-md-5">
                                                            <div class="schedule-time">
                                                                <span> {{ date('h:i A', strtotime($item->from_time)) }} -
                                                                    {{ date('h:i A', strtotime($item->to_time)) }} </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-7 col-md-7">
                                                            <p class="text-title text-18 text-capitalize font-500 mb-10">
                                                                {{ $item->title }}
                                                            </p>

                                                            <p class="mb-10">{{ @$item->details }}</p>

                                                            <div class=" d-flex align-items-center gap-8">
                                                                <i class="ri-map-pin-line"></i>
                                                                <span>{{ $item->location }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @empty

                                                    <div class="text-center">
                                                        {{ ___('event.No timeline set for today') }}
                                                    </div>
                                                @endforelse

                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- Contents --}}
                                </div>
                            </div>
                        @endif

                        {{-- Participants --}}
                        @if ($data['event']->participant_status->name === 'Public' && @$data['event']->participants->count() > 0)
                            <div class="ot-card3 shadows mb-24 p-4">
                                <div class="single-terms">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-10 mb-30">
                                        <h5 class="title font-600 mb-0">{{ ___('event.Participants') }}</h5>
                                    </div>
                                    <div class="single-users-intro tilt-effects">
                                        <a class="d-flex align-items-center justify-start flex-wrap">
                                            @foreach ($data['event']->participants as $index => $participant)
                                                <div class="icon m-1">
                                                    <img src="{{ showImage(@$participant->user->image->original, 'default-1.jpeg') }}"
                                                        alt="img" class="img-cover">
                                                </div>
                                            @endforeach
                                            @if ($data['event']->register->count() > 31)
                                                <div class="empty-icon d-flex align-items-center text-center icon m-1">
                                                    <span class="w-100 text-center text-tertiary">
                                                        {{ $data['event']->register->count() - $data['event']->participants->count() }}+
                                                    </span>
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($data['event']->speaker)
                            <div class="ot-card3 shadows mb-24 p-4">
                                {{-- Speakers --}}
                                <div class="single-terms">
                                    <div class="mb-20">
                                        <h5 class="title font-600 mb-0">{{ ___('event.Speakers') }}</h5>
                                    </div>
                                    <div class="row g-24">
                                        @foreach ($data['event']->speaker as $index => $speaker)
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                                <div class="single-users-intro tilt-effects h-calc">
                                                    <div class="icon">
                                                        <img src="{{ showImage(@$speaker->image->original, 'default-1.jpeg') }}"
                                                            alt="img" class="img-cover">
                                                    </div>
                                                    <div class="cat-caption text-center mt-10">
                                                        <h4
                                                            class="title  line-clamp-1 font-500 text-title text-capitalize">
                                                            {{ $speaker->name }}</h4>
                                                        <p class="pera text-12">{{ $speaker->designation }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- End-of Speakers --}}
                            </div>
                        @endif

                    </div>

                    <div class="col-lg-4">
                        {{-- buy ticket button --}}
                        <div class="ot-card3 mb-24">
                            <ul class="listing">
                                <li class="single-list d-flex gap-10 flex-wrap">
                                    <span class="font-600 text-18 text-title">{{ ___('event.Deadline') }} : </span>
                                    <p class="pera text-16">
                                        {{ $data['event']->registration_deadline->format('Y-m-d h:i A') }}</p>
                                </li>
                            </ul>
                        </div>


                        <div class="ot-card3 mb-24">
                            {{-- Tag --}}
                            @if (@$data['event']->tags)
                                <div class="single-terms mb-30">
                                    <div class="tag-area radius-4 bg-transparent border-0">
                                        <h5 class="title font-600">{{ ___('event.Tags') }}</h5>
                                        <ul class="listing">
                                            @foreach (@$data['event']->tags as $tag)
                                                <li class="single-list">{{ $tag->value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="ot-card3 mb-24">
                            @if ($data['event']->organizer)
                                {{-- Organizer --}}
                                <div class="single-terms mb-30">
                                    <div class="mb-20">
                                        <h5 class="title font-600 mb-0">{{ ___('event.Organizer') }}</h5>
                                    </div>

                                    <div class="row g-24">
                                        @foreach ($data['event']->organizer as $index => $organizer)
                                            <div class="col-xl-12">
                                                <div class="single-users-intro organizations tilt-effects h-calc">
                                                    <a
                                                        class="d-flex align-items-center justify-content-between gap-15 flex-wrap">
                                                        <div class="d-flex align-items-center gap-20">
                                                            <div class="icon">
                                                                <img src="{{ showImage(@$organizer->image->original, 'default-1.jpeg') }}"
                                                                    alt="img" class="img-cover">
                                                            </div>
                                                            <div class="cat-caption">
                                                                <h4
                                                                    class="title line-clamp-1 font-500 text-title text-capitalize text-16">
                                                                    {{ $organizer->name }}</h4>
                                                                <p class="pera mb-0 text-10">Email:
                                                                    {{ $organizer->email }}
                                                                </p>
                                                                <p class="pera mb-0 text-10">Phone:
                                                                    {{ $organizer->phone }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- End-of Organizer --}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End-of events discriptions --}}
        <input type="hidden" value="{{ @$data['event']->start }}" id="event_start_date">
        <input type="hidden" value="{{ @$data['event']->end }}" id="event_end_date">
    </div>
@endsection

@section('scripts')
    <script>
        function updateCountdown(eventStartDate, eventEndDate) {
            const now = new Date();
            const startDate = new Date(eventStartDate);
            const endDate = new Date(eventEndDate);
            const timeDifference = startDate - now;

            if (timeDifference > 0) {
                const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                $('#countdown_day').text(days);
                $('#countdown_hour').text(hours);
                $('#countdown_minute').text(minutes);
                $('#countdown_second').text(seconds);
            } else if (now >= startDate && now <= endDate) {
                $('#timer_panel').html(
                    '<h1 class="title font-700 text-center text-tertiary">Event has already started!</h1>');
            } else if (now > endDate) {
                $('#timer_panel').html('<h1 class="title font-700 text-center text-tertiary">Event Expired!</h1>');
            }
        }

        const eventStartDate = $('#event_start_date').val();
        const eventEndDate = $('#event_end_date').val();

        updateCountdown(eventStartDate, eventEndDate);

        // Update the countdown every second
        setInterval(() => {
            updateCountdown(eventStartDate, eventEndDate);
        }, 1000);
    </script>

@endsection
