@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- Events -->
    <section>
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10 pb-20 gap-15">
                    <h2 class="title font-600">{{ $data['title'] }}</h2>
                    <div class="right d-flex flex-wrap justify-content-between gap-15">
                        <!-- Search Box -->
                        <form action="" class="search-box-style">
                            <div class="responsive-search-box">
                                <input class="ot-search " type="text" name="search" placeholder="{{ ___('placeholder.Search Events') }}" value="{{ @$_GET['search'] }}">
                                <!-- icon -->
                                <div class="search-icon">
                                    <i class="ri-search-line"></i>
                                </div>
                                <!-- Button -->
                                <button class="search-btn">
                                    {{ ___('frontend.Search') }}
                                </button>
                            </div>
                        </form>
                        <!-- /End -->
                        <div class="search-tab ">
                            <a class="btn-primary-fill" href="{{ route('instructor.event.create') }}">
                                {{ ___('event.Add Event') }} <i class="ri-upload-2-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search -->
        </div>

        <!-- Events -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-5 g-24 mt-0 p-0 ">
            @forelse ($data['events'] as $event)
                <div class="col">
                    <div class="my-single-courses white-bg position-relative radius-8 h-calc">
                        <span class="course-badge position-absolute text-10 font-400 radius-4 "
                            >{{ @$event->event_type }}</span>
                        <div class="video-img2 overly1">
                            <a href="{{ route('event.home.details', $event->slug) }}">
                                <img src="{{ showImage(@$event->image->original) }}" class="img-cover"
                                    alt="img"> </a>
                            <!--Edit DropDown -->
                            <div class="course-edit">
                                <div class="activity-dropdown">
                                    <button class="dropdown-toggle"></button>
                                    <ul class="dropdown">

                                        <li>
                                            <a href="{{ route('event.home.details', $event->slug) }}"
                                                class="action-tertiary">
                                                <i title="View" class="ri-eye-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('instructor.event.edit', encryptFunction($event->id)) }}"
                                                class="action-success">
                                                <i title="Edit" class="ri-pencil-line"></i>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="javascript:;" class="action-danger"
                                                onclick="deleteFunction(`{{ route('instructor.event.destroy', encryptFunction($event->id)) }}`)">
                                                <i title="Delete" class="ri-delete-bin-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--video icon -->
                        </div>
                        <div class="course-caption">
                            <h4>
                                <a href="{{ route('event.home.details', $event->slug) }}"
                                    class="title colorEffect font-600 d-block line-clamp-2  mb-10">{{ Str::limit(@$event->title, 25) }}</a>
                            </h4>
                            <span class="module-time d-block mb-6">
                                {{ @$event->isPaid() }} | {{ @$event->category->title }}
                            </span>
                            <span class="module-time d-block mb-6">
                                {{ ___('event.Status') }} | {{ $event->visibleStatus->name }}
                            </span>
                            <span class="module-count text-tertiary d-block border-0 p-0 m-0">
                                <strong>{{ ___('event.Start') }}:</strong> {{ showDateTime(@$event->start) }}
                        </div>
                    </div>
                </div>
            @empty

                {{-- No Data Found --}}
                <div class="col-lg-3 col-md-6 col-sm-6 m-auto">
                    <div class="not-data-found text-center pt-50 pb-50">
                        <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                            alt="img" class="w-100 mb-20">
                    </div>
                </div>
            @endforelse
        </div>
    </section>
    
    <!--  pagination start -->
    {!! @$data['events']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->
@endsection
