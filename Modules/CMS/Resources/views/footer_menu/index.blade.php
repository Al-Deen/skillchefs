@extends('backend.master')
@section('title', $data['title'])
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


                        <!-- add btn start -->
                        @if (hasPermission('footer_menu_create'))
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <button data-url="{{ route('footer-menu.create') }}" role="button"
                                        class="btn-add main-modal-open" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ ___('course.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i></span>
                                        <span class="d-none d-xl-inline">{{ ___('common.add') }}</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <!-- add btn end -->
                    </div>
                    <!--toolbar table end -->
                    <!--  table start -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
                                <!-- start table header from ui-helper function -->
                                {{ table_header('', $data['tableHeader']) }}
                                <!-- end table header from ui-helper function -->
                            </thead>
                            <tbody class="tbody">

                                @forelse ($data['menus'] as $key => $menu)
                                    <tr>
                                        <td>{{ @$menu->id }}</td>
                                        <td>{{ Str::limit(@$menu->name, 20) }}</td>
                                        <td>
                                            @if (json_decode($menu->links))
                                                @foreach (json_decode($menu->links) as $key => $item)
                                                    <div
                                                        class="d-flex justify-content-sm-between text-wrap align-items-center">
                                                        <span
                                                            class="badge bg-{{ $item->status_id == 1 ? 'primary' : 'danger' }} mr-3">{{ $item->name }}</span>
                                                        <span class="d-flex gap-2 mb-6">
                                                            <a class="badge-basic-success-text p-0 main-modal-open"
                                                                href="javascript:void(0);"
                                                                data-url="{{ route('footer-menu-link.edit', [$menu->id, $key]) }}">
                                                                <i class="fa-solid fa-edit"></i>
                                                            </a>

                                                            <a class="badge-basic-danger-text p-0 delete_data"
                                                                href="javascript:void(0);"
                                                                data-href="{{ route('footer-menu-link.destroy', [$menu->id, $key]) }}">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if (hasPermission('footer_menu_create'))
                                                <a class="badge-basic-success-text main-modal-open"
                                                    href="javascript:void(0);"
                                                    data-url="{{ route('footer-menu-link.create', $menu->id) }}">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            @endif


                                        </td>
                                        <td>
                                            {{ $menu->column }}
                                        </td>
                                        <td>
                                            {{ statusBackend(@$menu->status->class, $menu->status->name) }}
                                        </td>

                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    @if (hasPermission('footer_menu_update'))
                                                        <li>
                                                            <a class="dropdown-item main-modal-open"
                                                                href="javascript:void(0);"
                                                                data-url="{{ route('footer-menu.edit', $menu->id) }}"><span
                                                                    class="icon mr-12"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('footer_menu_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);"
                                                                data-href="{{ route('footer-menu.destroy', $menu->id) }}">
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
                    @include('backend.ui-components.pagination', ['data' => $data['menus']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection
