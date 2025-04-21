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
                    </div>
                    <!--toolbar table end -->
                    <!-- start table data -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th>{{ ___('common.SL') }}</th>
                                    <th>{{ ___('account.Account_Name') }}</th>
                                    <th>{{ ___('common.name') }}</th>
                                    <th>{{ ___('common.type') }}</th>
                                    <th>{{ ___('common.Amount') }}</th>
                                    <th>{{ ___('common.Created_at') }}</th>
                                    <th>{{ ___('common.Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">

                                @forelse ($data['expenses'] as $key => $expense)
                                    <tr>
                                        <td>{{ @$key + 1 }}</td>
                                        <td>
                                            {{ @$expense->transaction->account->ac_name }}
                                        </td>
                                        <td>
                                            {{ @$expense->transaction->user->name }}
                                        </td>
                                        <td>
                                            {{ @$expense->note }}
                                        </td>
                                        <td>
                                            {{ showPrice(@$expense->amount) }}
                                        </td>
                                        <td>
                                            {{ showDateTime(@$expense->created_at) }}
                                        </td>
                                        <td>
                                            {{ statusBackend(@$expense->status->class, $expense->status->name) }}
                                        </td>
                                    </tr>
                                @empty
                                    <!-- empty table -->
                                    @include('backend.ui-components.empty_table', [
                                        'colspan' => '7',
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
                    @include('backend.ui-components.pagination', ['data' => $data['expenses']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
