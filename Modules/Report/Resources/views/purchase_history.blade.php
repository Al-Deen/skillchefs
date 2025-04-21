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

                        <!-- export btn start -->
                        @if (hasPermission('report_purchase_history_export'))
                            <div class="align-self-center d-flex gap-2">
                                <div class="align-self-center">
                                    <a href="{{ route('report.purchase-history.export') }}" role="button"
                                        class="btn btn-outline-primary btn-export" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="{{ ___('common.Export') }}">
                                        <span><i class="fa-solid fa-arrow-up-right-from-square"></i> </span>
                                        <span class="d-none d-xl-inline">{{ ___('common.Export') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <!-- export btn end -->


                    </div>
                    <!--toolbar table end -->
                    <!--  table start -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th>{{ ___('common.ID') }}</th>
                                    <th>{{ ___('instructor.Course Title') }}</th>
                                    <th>{{ ___('instructor.Student') }}</th>
                                    <th>{{ ___('instructor.Instructor') }}</th>
                                    <th>{{ ___('instructor.Price') }}</th>
                                    <th>{{ ___('instructor.Discount') }}</th>
                                    <th>{{ ___('instructor.Total Amount') }}</th>
                                    <th>{{ ___('instructor.Date') }}</th>
                                    <th>{{ ___('instructor.Payment') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['purchase_histories'] as $key => $enroll)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a target="_blank"
                                                href="{{ route('frontend.courseDetails', $enroll->course->slug) }}">
                                                {{ Str::limit(@$enroll->course->title, 30) }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ @$enroll->user->name }}
                                        </td>
                                        <td>
                                            {{ @$enroll->teacher->name }}
                                        </td>
                                        <td>
                                            {{ showPrice(@$enroll->orderItem->amount) }}
                                        </td>

                                        <td>
                                            {{ showPrice(@$enroll->orderItem->discount_amount) }}
                                        </td>
                                        <td>
                                            {{ showPrice(@$enroll->orderItem->total_amount) }}
                                        </td>
                                        <td>
                                            {{ showDate(@$enroll->orderItem->created_at) }}
                                        </td>
                                        <td>
                                            <span class="badge badge-basic-success-text">{{ ___('common.Paid') }}</span>
                                        </td>

                                    </tr>
                                @empty
                                    <!-- empty table -->
                                    @include('backend.ui-components.empty_table', [
                                        'colspan' => '9',
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
                    @include('backend.ui-components.pagination', ['data' => $data['purchase_histories']])
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
