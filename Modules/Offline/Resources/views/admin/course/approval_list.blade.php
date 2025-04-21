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
                                    <th>{{ ___('offline.Invoice_No') }}</th>
                                    <th>{{ ___('offline.Date') }}</th>
                                    <th>{{ ___('offline.Student') }}</th>
                                    <th>{{ ___('offline.Price') }}</th>
                                    <th>{{ ___('offline.Discount') }}</th>
                                    <th>{{ ___('offline.Total Amount') }}</th>
                                    <th>{{ ___('offline.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['orders'] as $key => $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ @$order->invoice_number }}</td>
                                        <td>
                                            {{ showDate(@$order->created_at) }}
                                        </td>
                                        <td>
                                            {{ @$order->user->name }}
                                        </td>
                                        <td>
                                            {{ showPrice(@$order->amount) }}
                                        </td>

                                        <td>
                                            {{ showPrice(@$order->discount_amount) }}
                                        </td>
                                        <td>
                                            {{ showPrice(@$order->total_amount) }}
                                        </td>
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (hasPermission('course_enroll_approval_update'))
                                                    <li>
                                                        <a class="dropdown-item main-modal-open" href="javascript:void(0);"
                                                            data-url="{{ route('course.enroll.view', $order->id) }}">
                                                            <span class="icon mr-12">
                                                                <i class="fa-solid fa-user-check"></i>
                                                            </span>
                                                            {{ ___('common.Approve') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if (hasPermission('course_enroll_approval_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);" data-href="{{ route('course.enroll.destroy', encryptFunction($order->id)) }}">
                                                                <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                                                <span>{{ ___('common.delete') }}</span>
                                                            </a>
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
                    @include('backend.ui-components.pagination', ['data' => $data['orders']])
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
