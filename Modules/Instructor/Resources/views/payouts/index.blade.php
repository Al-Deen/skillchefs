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
                    </div>
                    <!--toolbar table end -->
                    <!--  table start -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th>{{ ___('common.ID') }}</th>
                                    <th>{{ ___('common.User') }}</th>
                                    <th>{{ ___('common.User Type') }}</th>
                                    <th>{{ ___('instructor.Request Amount') }}</th>
                                    <th>{{ ___('instructor.Payment Method') }}</th>
                                    <th>{{ ___('common.Status') }}</th>
                                    <th>{{ ___('instructor.Payment Status') }}</th>
                                    <th>{{ ___('common.Created_at') }}</th>
                                    <th>{{ ___('common.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">

                                @forelse ($data['payouts'] as $key => $payout)
                                    <tr>
                                        <td>{{ @$payout->id }}</td>
                                        <td>

                                            <div class="d-flex align-items-center">
                                                <div class="product-image">
                                                    <img src="{{ showImage(@$payout->user->image->original, 'default-1.jpeg') }}"
                                                        alt="{{ @$payout->user->name }}">
                                                </div>
                                                <div class="product-name ml-10">
                                                    {{ Str::limit(@$payout->user->name, 20) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ @$payout->user->role_id === 5 ? 'Instructor' : 'Organization' }}</td>
                                        <td> {{ showPrice($payout->amount) }}</td>
                                        <td>{{ Str::ucfirst(@$payout->instructorPaymentMethod->paymentMethod->name) }}
                                        </td>
                                        <td>
                                            {{ statusBackend(@$payout->status->class, $payout->status->name) }}
                                        </td>
                                        <td>
                                            {{ statusBackend(@$payout->payment_status->class, $payout->payment_status->name) }}
                                        </td>

                                        <td class="create-date">{{ showDateTime(@$payout->created_at) }}</td>

                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    @if (hasPermission('instructor_payout_details'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.instructor.payout.details', $payout->id) }}">
                                                                <span class="icon mr-12">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </span>
                                                                {{ ___('common.View') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('instructor_payout_request_approve') && $payout->status_id == 3)
                                                        <li>
                                                            <a class="dropdown-item status_update"
                                                                href="javascript:void(0);"
                                                                data-text="{{ ___('common.Approve') }}"
                                                                data-href="{{ route('admin.instructor.payout.approve', $payout->id) }}">
                                                                <span class="icon mr-12">
                                                                    <i class="fa-solid fa-check"></i>
                                                                </span>
                                                                {{ ___('common.Approve') }}</a>
                                                        </li>
                                                    @endif

                                                    @if (hasPermission('instructor_payout_request_reject') && $payout->status_id == 3)
                                                        <li>
                                                            <a class="dropdown-item main-modal-open"
                                                                href="javascript:void(0);"
                                                                data-url="{{ route('admin.instructor.payout.reject', $payout->id) }}">
                                                                <span class="icon mr-12">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </span>
                                                                {{ ___('common.Reject') }}</a>
                                                        </li>
                                                    @endif

                                                    @if (hasPermission('instructor_make_payout') && $payout->status_id == 4 && $payout->payment_status_id == 9)
                                                        <li>
                                                            <a class="dropdown-item status_update"
                                                                href="javascript:void(0);"
                                                                data-text="{{ ___('common.Make Payment') }}"
                                                                data-href="{{ route('admin.instructor.payout.payment', $payout->id) }}">
                                                                <span class="icon mr-12">
                                                                    <i class="fa-solid fa-check"></i>
                                                                </span>
                                                                {{ ___('common.Make Payment') }}</a>
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
                    @include('backend.ui-components.pagination', ['data' => $data['payouts']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection
@push('script')
@endpush
