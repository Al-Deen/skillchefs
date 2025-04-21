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

                                    <!-- start categories -->
                                    <div class="align-self-center">
                                        <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="{{ ___('common.Category') }}">
                                            <select id="single" class="select2 form-control cus-dropdown-seelct"
                                                name="category_id">
                                                <option value="0" selected disabled>
                                                    {{ ___('common.Select Category') }}</option>
                                                @if ($data['categoriesArr'])
                                                    @foreach ($data['categoriesArr'] as $catId => $category)
                                                        <option @if (@request()->category_id == $catId) {{ 'selected' }} @endif
                                                            value="{{ $catId }}">{{ $category }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end categories -->


                                    <div class="align-self-center d-flex gap-2">
                                        <!-- search start -->
                                        <div class="align-self-center">
                                            <div class="search-box d-flex">
                                                <input class="form-control" placeholder="{{ ___('common.search') }}"
                                                    name="search" value="{{ @request()->search }}" />
                                                <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                            </div>
                                        </div>
                                        <!-- search end -->


                                        <!-- dropdown action -->
                                        <div class="align-self-center">
                                            <div class="dropdown dropdown-action">
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
                        @if (hasPermission('blog_create'))
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <a href="{{ route('blog.create') }}" role="button" class="btn-add"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add">
                                        <span><i class="fa-solid fa-plus"></i> </span>
                                        <span class="d-none d-xl-inline">{{ ___('common.add') }}</span>
                                    </a>
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

                                @forelse ($data['blogs'] as $key => $blog)
                                    <tr>
                                        <td>{{ @$blog->id }}</td>
                                        <td>{{ Str::limit(@$blog->title, 20) }}</td>
                                        <td>
                                            <img src="{{ showImage(@$blog->iconImage->paths['35x35'], 'default-1.jpeg') }}"
                                                alt="{{ @$blog->title }}" width="35px">
                                        </td>
                                        <td>{{ @$blog->category->title }}</td>
                                        <td>
                                            {{ statusBackend(@$blog->status->class, @$blog->status->name) }}
                                        </td>

                                        <td class="create-date">{{ showDate(@$blog->created_at) }}</td>

                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('blog_details', $blog->id) }}"><span
                                                                class="icon mr-12"><i class="fa-solid fa-eye"></i></span>
                                                            {{ ___('common.View') }}</a>
                                                    </li>
                                                    @if (hasPermission('blog_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('blog.edit', $blog->id) }}"><span
                                                                    class="icon mr-12"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('blog_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);"
                                                                data-href="{{ route('blog.destroy', $blog->id) }}">
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
                                        'colspan' => '7',
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
                    @include('backend.ui-components.pagination', ['data' => $data['blogs']])
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
