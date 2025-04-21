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
                    <div class="table-toolbar d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
                        <form action="" method="get">
                            <div class="align-self-center">
                                <div class="d-flex flex-wrap gap-2 flex-column flex-lg-row justify-content-center align-content-center">
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
                                    <th>{{ ___('common.Name') }}</th>
                                    <th>{{ ___('common.Course') }}</th>
                                    <th>{{ ___('common.Sales') }}</th>
                                    <th>{{ ___('organization.Income') }}</th>
                                    <th>{{ ___('organization.Balance') }}</th>
                                    <th>{{ ___('common.Status') }}</th>
                                    <th>{{ ___('common.Created_at') }}</th>
                                    <th>{{ ___('common.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">

                                @forelse ($data['organizations'] as $key => $organization)
                                    <tr>
                                        <td>{{ @$organization->id }}</td>
                                        <td>

                                            <div class="d-flex align-items-center">
                                                <div class="product-image">
                                                    <img src="{{ showImage(@$organization->user->image->original, 'default-1.jpeg') }}"
                                                        alt="{{ @$organization->user->name }}">
                                                </div>
                                                <div class="product-name ml-10">
                                                    {{ Str::limit(@$organization->user->name, 20) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td> {{ @$organization->courses->count() }} </td>
                                        <td> {{ @$organization->enroll->count() }} </td>
                                        <td>{{ showPrice(@$organization->earnings) }}</td>
                                        <td>{{ showPrice(@$organization->balance) }}</td>
                                        <td>
                                            {{ statusBackend(@$organization->user->userStatus->class, $organization->user->userStatus->name) }}
                                        </td>

                                        <td class="create-date">{{ showDate(@$organization->created_at) }}</td>

                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (hasPermission('organization_login'))
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.organization.login', $organization->id) }}">
                                                                <span
                                                                    class="icon mr-12">
                                                                    <i class="fa-solid fa-user-shield"></i>
                                                                </span>
                                                                {{ ___('common.Login') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('organization_re_activate'))
                                                        <li>
                                                            <a class="dropdown-item status_update" href="javascript:void(0);"
                                                                data-text="{{ ___('common.Re-Activate') }}" data-href="{{ route('organization.admin.re_activate', $organization->id) }}">
                                                            <span class="icon mr-12">
                                                                <i class="fa-solid fa-user-check"></i>
                                                            </span>
                                                            {{ ___('common.Re-Activate') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('organization_update'))
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('organization.admin.edit', [$organization->id, 'general']) }}">
                                                                <span class="icon mr-12">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('organization_suspend'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);" data-href="{{ route('organization.admin.destroy', $organization->id) }}">
                                                                <span class="icon mr-8">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </span>
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
                    @include('backend.ui-components.pagination', ['data' => $data['organizations']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection
@push('script')
@endpush
