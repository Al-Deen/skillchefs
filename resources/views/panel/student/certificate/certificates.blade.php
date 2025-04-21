@extends('panel.student.layouts.master')
@section('title', @$data['title'])
@section('content')
    <section>
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                    <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    <div class="right d-flex flex-wrap justify-content-between">
                        <!-- Search Box -->
                        <form action="" class="search-box-style mb-20 mr-10">
                            <div class="responsive-search-box">
                                <input class="ot-search " type="text" name="search""
                                    placeholder="{{ ___('placeholder.Search Courses') }}" value="{{ @$_GET['search'] }}">
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
                    </div>
                </div>
            </div>

            <!-- Search -->
        </div>
        <!-- Report Table -->
        <div class="row">
            <div class="col-xl-12">
                <div class="mb-24">
                    <!-- Section Tittle -->
                    <div class="activity-table">
                        <table class="table-responsive">
                            <thead>
                                <tr>
                                    <th>{{ ___('student.Courses Title') }}</th>
                                    <th>{{ ___('student.Total Points') }}</th>
                                    <th>{{ ___('student.Your Points') }}</th>
                                    <th>{{ ___('student.Status') }}</th>
                                    <th>{{ ___('student.Progress') }}</th>
                                    <th>{{ ___('student.Certificate') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['enrolls'] as $enroll)
                                    <tr>
                                        <td>
                                            <a target="_blank"
                                                href="{{ route('frontend.courseDetails', @$enroll->course->slug) }}">
                                                {{ Str::limit(@$enroll->course->title, 30) }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ @$enroll->course->point }}
                                        </td>
                                        <td>
                                            {{ @$enroll->lesson_point + @$enroll->quiz_point + @$enroll->assignment_point }}
                                        </td>
                                        <td class="porgress-td">
                                            @if (@$enroll->is_completed)
                                                <span class="progress-complite">
                                                    {{ ___('student.Completed') }}
                                                </span>
                                            @else
                                                <span class="text-warning">
                                                    {{ ___('student.Pending') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="round-progress d-flex align-items-center">
                                                <div class="progress-container d-inline">
                                                    <div class="progress" data-percentage="{{ @$enroll->progress }}">
                                                        <span class="progress-left">
                                                            <span class="progress-bar progress-c-complite"></span>
                                                        </span>
                                                        <span class="progress-right">
                                                            <span class="progress-bar progress-c-complite"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <p class="browser-percent ml-6">{{ @$enroll->progress }}%</p>
                                            </div>
                                        </td>
                                        <td>
                                            @if (@$enroll->is_completed)
                                                <a href="{{ route('student.certificate.download', encryptFunction($enroll->id)) }}"
                                                    class="action-tertiary">
                                                    <i class="ri-download-cloud-fill"></i>
                                                </a>
                                                <a href="{{ route('student.certificate.view', encryptFunction($enroll->id)) }}"
                                                    class="action-success">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            @else
                                                <span class="text-danger">
                                                    {{ ___('student.Not Completed') }}
                                                </span>
                                            @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{-- No Data Found --}}
                                            <div class="row justify-content-center">
                                                <div class="col-lg-3 col-md-6 col-sm-6">
                                                    <div class="not-data-found table-img text-center pt-50 pb-10">
                                                        <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                                            alt="img" class="w-100 mb-20 w-25">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--  pagination start -->
        {!! @$data['enrolls']->links('frontend.partials.pagination-count') !!}
        <!--  pagination end -->

    </section>

@endsection
