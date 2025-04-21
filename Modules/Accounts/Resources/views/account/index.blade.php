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
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}
        <input type="hidden">
        <!-- Form with multiStep S t a r t-->
        <div class="table-content table-basic ecommerce-components product-list ">
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
                                                <button type="submit" class="btn-add" onclick="courseAssignmentLoad()">
                                                    <span class="icon">{{ ___('common.Filter') }}
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- add btn start -->
                        @if (hasPermission('accounts_create'))
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <button onclick="mainModalOpen(`{{ route('admin.accounts.create') }}`)" role="button"
                                        class="btn-add" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ ___('course.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ ___('common.add') }}</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <!-- add btn end -->
                    </div>
                    <!--toolbar table end -->
                    <!-- start table data -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th>{{ ___('common.SL') }}</th>
                                    <th>{{ ___('common.Name') }}</th>
                                    <th>{{ ___('account.Account_Name') }}</th>
                                    <th>{{ ___('account.Account_Number') }}</th>
                                    <th>{{ ___('account.Code') }}</th>
                                    <th>{{ ___('account.Branch') }}</th>
                                    <th>{{ ___('account.Balance') }}</th>
                                    <th>{{ ___('common.Default') }}</th>
                                    <th>{{ ___('common.Status') }}</th>
                                    <th>{{ ___('common.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">

                                @forelse ($data['accounts'] as $key => $account)
                                    <tr>
                                        <td>{{ @$key + 1 }}</td>
                                        <td>{{ @$account->name }}</td>
                                        <td>
                                            {{ @$account->ac_name }}
                                        </td>
                                        <td>
                                            {{ @$account->ac_number }}
                                        </td>
                                        <td>
                                            {{ @$account->code }}
                                        </td>
                                        <td>
                                            {{ @$account->branch }}
                                        </td>
                                        <td>
                                            {{ showPrice(@$account->balance) }}
                                        </td>
                                        <td>
                                            @if (@$account->is_default == 1)
                                                <span class="badge-basic-success-text">{{ ___('common.Yes') }}</span>
                                            @else
                                                <span class="badge-basic-danger-text">{{ ___('common.No') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ statusBackend(@$account->status->class, $account->status->name) }}
                                        </td>

                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (hasPermission('accounts_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                onclick="mainModalOpen(`{{ route('admin.accounts.edit', $account->id) }}`)"
                                                                href="javascript:;"><span class="icon mr-12"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif

                                                    @if (hasPermission('account_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);"
                                                                data-href="{{ route('admin.accounts.destroy', $account->id) }}">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
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
                    <!-- end table data -->
                    <!-- pagination start -->
                    @include('backend.ui-components.pagination', ['data' => $data['accounts']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
