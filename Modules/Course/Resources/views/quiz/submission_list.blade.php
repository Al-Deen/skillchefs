@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                route('admin.quiz.index') => ___('course.Quiz Lists'),
                '#' => @$data['title'],
            ],

            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic ecommerce-components product-list">
            <div class="card">
                <div class="card-body">


                    <!--  toolbar table start  -->
                    <div
                        class="table-toolbar d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
                        <form action="" method="get">
                            <div class="align-self-center">
                                <div
                                    class="d-flex flex-wrap gap-2 flex-column flex-lg-row justify-content-center align-content-center">
                                    <!-- show per page -->
                                    @include('backend.ui-components.per-page')
                                    <!-- show per page end -->

                                    <div class="align-self-center d-flex gap-2">
                                        <!-- search start -->
                                        <div class="align-self-center">
                                            <div class="search-box d-flex">
                                                <input class="form-control" placeholder="{{ ___('common.search') }}"
                                                    name="search" value="{{ @$_GET['search'] }}" />
                                                <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                            </div>
                                        </div>
                                        <!-- search end -->

                                        <!-- dropdown action -->
                                        <div class="align-self-center">
                                            <div class="dropdown dropdown-action" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Filter">
                                                <button type="submit" class="btn-add">
                                                    <span class="icon">{{ ___('common.Filter') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--toolbar table end -->
                    <!--  table start -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
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
                            <tbody class="tbody">
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
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    @if (hasPermission('course_quiz_submission_view'))
                                                        <li>
                                                            <a class="dropdown-item main-modal-open"
                                                                href="javascript:void(0);"
                                                                data-url="{{ route('admin.quiz.view', $submission->id) }}">
                                                                <span class="icon mr-12">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </span>
                                                                {{ ___('common.View') }}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- empty table -->
                                    @include('backend.ui-components.empty_table', [
                                        'colspan' => '8',
                                        'message' => ___(
                                            'message.Please add a new entity or manage the data table to see the content here'),
                                    ])
                                    <!-- empty table -->
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                    <!--  table end -->
                    <!--  pagination start -->
                    @include('backend.ui-components.pagination', ['data' => $data['submissions']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection
@push('script')
    @include('backend.partials.delete-ajax')
@endpush
