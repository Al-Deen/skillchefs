@extends('frontend.layouts.master')
@section('title', @$data['title'] ?? 'Blogs')
@section('content')

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])

    <section class="events-search-area mt-50 mb-50">
        <div class="container">
            <div class="card-style white-bg border-0">
                <form id="filterFormSubmit" action="{{ route('event_ajax.event.list') }}">
                    <div class="row">
                        <div class="col-lg-4 mb-15">
                            <div class="header-search widht-auto">
                                <div class="input-form">
                                    <input type="text" name="search"
                                        placeholder="{{ ___('event.Find your next event') }}" value="">
                                    <div class="icon">
                                        <i class="ri-search-line"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-15">
                            <select class="select_2" name="event_type">
                                <option selected disabled>
                                    {{ ___('event.Event Type') }}
                                </option>
                                <option value="Online">{{ ___('event.Online') }}</option>
                                <option value="Offline">{{ ___('event.Offline') }}</option>

                            </select>
                        </div>
                        <div class="col-lg-3 mb-15">
                            <select class="select_2" name="category_id">
                                <option selected disabled>
                                    {{ ___('event.Event Category') }}
                                </option>
                                @foreach ($data['event_categories'] as $category)
                                    <option value="{{ @$category->id }}">{{ @$category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 mb-15">
                            <button class="btn-primary-fill ml-20 text-end" type="submit">
                                <i class="ri-search-line"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="ot-discount-courses-area bottom-padding section-data-load"
        data-url="{{ route('event_ajax.event.list') }}">
    </section>

@endsection
