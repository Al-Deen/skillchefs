@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- instructor Courses activity Start -->
    <section class="instructor-courses-activity">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10">
                    <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="activity-table">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>{{ ___('instructor.ID') }}</th>
                                <th>{{ ___('instructorCommon.Student') }}</th>
                                <th>{{ ___('instructor.Purchase Date') }}</th>
                                <th>{{ ___('instructor.Submission Date') }}</th>
                                <th>{{ ___('instructorCommon.Quiz') }}</th>
                                <th>{{ ___('instructorCommon.Marks') }}</th>
                                <th>{{ ___('instructorCommon.Status') }}</th>
                                <th>{{ ___('instructorCommon.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['submissions'] as $submission)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <h5 class="text-16 text-tertiary">
                                            {{ @$submission->user->name }}
                                        </h5>
                                    </td>
                                    <td>
                                        {{ showDateTime($submission->enroll->created_at) }}
                                    </td>
                                    <td>
                                        {{ showDateTime($submission->created_at) }}
                                    </td>
                                    <td>
                                        <p>
                                            <strong>{{ ___('instructorCommon.Pass') }} : </strong>
                                            {{ @$submission->quiz->pass_marks }}
                                        </p>
                                        <p>
                                            <strong>{{ ___('instructorCommon.Marks') }} : </strong>
                                            {{ @$submission->quiz->marks }}
                                        </p>

                                    </td>
                                    <td>
                                        {{ @$submission->marks }}
                                    </td>
                                    <td>
                                        {{ status_ui('', @$submission->status->class, @$submission->status->name) }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            data-url="{{ route('instructor.quiz.view', encryptFunction($submission->id)) }}"
                                            class="action-success main-modal-open">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td colspan="8" class="text-center">
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
    </section>
    <!-- End-of courses activity  -->


    <!--  pagination start -->
    {!! @$data['submissions']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->

@endsection
