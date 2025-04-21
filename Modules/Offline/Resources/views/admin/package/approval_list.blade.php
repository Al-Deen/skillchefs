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
                                    <th>{{ ___('common.Package_Name')}}</th>
                                    <th>{{ ___('common.Student')}}</th>
                                    <th>{{ ___('ui_element.Price')}}</th>
                                    <th>{{ ___('ui_element.Instructor_commission')}}</th>
                                    <th>{{ ___('ui_element.Date')}}</th>
                                    <th>{{ ___('ui_element.Expire_Date')}}</th>
                                    <th>{{ ___('ui_element.Invoice_No')}}</th>
                                    <th>{{ ___('offline.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['packages'] as $key => $package)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ @$package->package->name }}</td>
                                        <td>{{ @$package->user->name }}</td>
                                        <td>{{ showPrice(@$package->amount) }}</td>
                                        <td>{{ @$package->package->instructor_commission }}%</td>
                                        <td>{{ showDate(@$package->created_at) }}</td>
                                        <td>
                                            @if(@$package->expire_date <= now())
                                                <span class="badge badge-basic-danger-text">{{ showDate(@$package->expire_date) }}</span>
                                            @elseif(@$package->expire_date > now() && @$package->expire_date <= now()->addDays(7))
                                                <span class="badge badge-basic-warning-text">{{ showDate(@$package->expire_date) }}</span>
                                            @else
                                                <span class="badge badge-basic-success-text">{{ showDate(@$package->expire_date) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ @$package->invoice_number }}
                                        </td>
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (hasPermission('package_enroll_approval_update'))
                                                    <li>
                                                        <a class="dropdown-item main-modal-open" href="javascript:void(0);"
                                                            data-url="{{ route('package.enroll.view', $package->id) }}">
                                                            <span class="icon mr-12">
                                                                <i class="fa-solid fa-user-check"></i>
                                                            </span>
                                                            {{ ___('common.Approve') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if (hasPermission('package_enroll_approval_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);" data-href="{{ route('package.enroll.destroy', encryptFunction($package->id)) }}">
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
                    @include('backend.ui-components.pagination', ['data' => $data['packages']])
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
