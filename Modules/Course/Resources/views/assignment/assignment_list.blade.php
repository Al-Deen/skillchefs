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
                '#' => @$data['title'],
            ],

            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic ecommerce-components product-list">
            <div class="card">
                <div class="card-body">

                    {{-- statistics --}}
                    <div class="row g-4 mb-5">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="cart-two bg-blue-gradient ot-card wave-animated h-calc">
                                <div class="icons">
                                    <!--icon -->
                                    <div class="icon ">
                                        <i class="las la-file-upload"></i>
                                    </div>
                                    <!--icon -->
                                </div>
                                <div class="cartCaption">
                                    <h6 class="cart-title">{{ ___('instructor.Total Submission') }}</h6>
                                    <div class="counts d-flex">
                                        <div class="single-counter mb-10">
                                            <p class="countPlus ">{{ shorten_number(@$data['total_submissions']) }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="cart-two bg-tea-gradient ot-card wave-animated h-calc">
                                <div class="icons">
                                    <!--icon -->
                                    <div class="icon ">
                                        <i class="las la-chart-bar"></i>
                                    </div>
                                    <!--icon -->

                                </div>
                                <div class="cartCaption">
                                    <h6 class="cart-title">{{ ___('instructor.Total Passed') }}</h6>
                                    <div class="counts d-flex">
                                        <!-- Counter -->
                                        <div class="single-counter mb-10">
                                            <p class="countPlus ">{{ shorten_number($data['passed_submissions']) }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="cart-two bg-soft-gradient ot-card wave-animated h-calc">
                                <div class="icons">
                                    <!--icon -->
                                    <div class="icon ">
                                        <i class="las la-times-circle"></i>
                                    </div>

                                </div>
                                <div class="cartCaption">
                                    <h6 class="cart-title">{{ ___('instructor.Total Failed') }}</h6>
                                    <div class="counts d-flex">
                                        <!-- Counter -->
                                        <div class="single-counter mb-10">
                                            <p class="countPlus ">{{ shorten_number(@$data['failed_submissions']) }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- statistics end --}}


                    <!--  toolbar table start  -->
                    <div
                        class="table-toolbar mt-3 d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
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
                                    <th>{{ ___('instructorCommon.Courses Name') }}</th>
                                    <th>{{ ___('instructor.Submissions') }}</th>
                                    <th>{{ ___('instructorCommon.Marks') }}</th>
                                    <th>{{ ___('instructorCommon.Pass Marks') }}</th>
                                    <th>{{ ___('instructor.Average Marks') }}</th>
                                    <th>{{ ___('common.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['assignments'] as $assignment)
                                    <tr>
                                        <td>
                                            <h5 class="text-16 text-tertiary">
                                                {{ @$assignment->title }}
                                            </h5>
                                            <p class="text-12">
                                                {{ Str::limit(@$assignment->course->title, 30) }}
                                            </p>
                                        </td>
                                        <td>
                                            {{ $assignment->assignmentSubmit->count() }}
                                        </td>
                                        <td>
                                            {{ $assignment->marks }}
                                        </td>
                                        <td>
                                            {{ $assignment->pass_marks }}
                                        </td>
                                        <td>
                                            {{ $assignment->assignmentSubmit->avg('marks') }}
                                        </td>
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    @if (hasPermission('course_assignment_submission_list'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.assignment_submission_list.index', $assignment->id) }}"><span
                                                                    class="icon mr-12">
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
                                        'colspan' => '6',
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
                    @include('backend.ui-components.pagination', ['data' => $data['assignments']])
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
