@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- Courses -->
    <section>
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10 pb-20 gap-15">
                    <h2 class="title font-600">{{ $data['title'] }}</h2>
                    <div class="right d-flex flex-wrap justify-content-between gap-15">
                        <!-- Search Box -->
                        <form action="" class="search-box-style">
                            <div class="responsive-search-box">
                                <input class="ot-search " type="text" name="search"
                                    placeholder="Search Books" value="{{ @$_GET['search'] }}">
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
                            <a class="btn-primary-fill" href="{{ route('instructor.add_book') }}">
                                Add New book <i class="ri-upload-2-line"></i>
                            </a>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Search -->
        </div>

        <!-- Course -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-5 g-24 mt-0 p-0 ">
            @forelse ($data['books'] as $book)
                <div class="col">
                    <div class="my-single-courses white-bg position-relative radius-8 h-calc">
                        <a class="course-badge position-absolute text-10 font-400 radius-4 "
                            href="{{ route('frontend.bookDetails', $book->slug) }}">{{ @$book->title }}</a>
                        <div class="video-img2 overly1">
                            <a href="{{ route('frontend.bookDetails', $book->slug) }}">
                                <img src="{{ asset($book->thumbnail) }}" class="img-cover"
                                    alt="img"> </a>
                            <!--Edit DropDown -->
                            <div class="course-edit">
                                <div class="activity-dropdown">
                                    <button class="dropdown-toggle"></button>
                                    <ul class="dropdown">

                                        <li>
                                            <a href="{{ route('frontend.bookDetails', $book->slug) }}"
                                                class="action-tertiary">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('instructor.book.edit', $book->slug) }}"
                                                class="action-success">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="javascript:;" class="action-danger"
                                                onclick="deleteFunction(`{{ route('instructor.book.delete', $book->id) }}`)">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <!--video icon -->
                        </div>
                        <div class="course-caption">
                            <h4>
                                <a href="{{ route('frontend.bookDetails', $book->slug) }}"
                                    class="title colorEffect font-600 d-block line-clamp-2  mb-10">{{ Str::limit(@$book->title, 25) }}</a>
                            </h4>
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
    {!! @$data['books']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->

@endsection
