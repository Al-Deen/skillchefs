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
                                                    <span class="icon">{{ ___('common.Filter') }} </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- add btn start -->
                        @if (hasPermission('discount_course_create'))
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <button data-url="{{ route('admin.discount-course.create') }}" role="button"
                                        class="btn-add main-modal-open" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ ___('common.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i></span>
                                        <span class="d-none d-xl-inline">{{ ___('common.Add') }}</span>
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
                                <tr>
                                    <th>{{ ___('common.SL') }}</th>
                                    <th>{{ ___('common.Title') }}</th>
                                    <th>{{ ___('course.Instructor') }}</th>
                                    <th>{{ ___('course.Price') }}</th>
                                    <th>{{ ___('course.Discount') }}</th>
                                    <th>{{ ___('course.Discount_Type') }}</th>
                                    <th>{{ ___('course.Discount_Price') }}</th>
                                    <th>{{ ___('common.Status') }}</th>
                                    <th>{{ ___('common.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">

                                @forelse ($data['courses'] as $key => $course)
                                    <tr>
                                        <td>{{ @$key + 1 }}</td>
                                        <td>
                                            {{ Str::limit(@$course->title, 25) }}
                                            <p>
                                                {{ @$course->category->title }}
                                            </p>
                                        </td>
                                        <td>
                                            {{ @$course->instructor->name }}
                                        </td>

                                        <td>
                                            @if (@$course->is_free)
                                                {{ ___('common.Free') }}
                                            @else
                                                {{ showPrice(@$course->price) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$course->discount_type == 1)
                                                {{ showPrice(@$course->discount_price) }}
                                            @else
                                                {{ @$course->discount_price }}%
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$course->discount_type == 1)
                                                {{ ___('course.Fixed') }}
                                            @else
                                                {{ ___('course.Percentage') }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ showPrice(discount_price(@$course)) }}
                                        </td>
                                        <td>
                                            {{ statusBackend(@$course->status->class, $course->status->name) }}
                                        </td>

                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (hasPermission('discount_course_update'))
                                                        <li>
                                                            <a class="dropdown-item main-modal-open"
                                                                href="javascript:void(0);"
                                                                data-url="{{ route('admin.discount-course.edit', $course->id) }}">
                                                                <span class="icon mr-8">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </span>
                                                                <span>{{ ___('common.Edit') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('discount_course_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);"
                                                                data-href="{{ route('admin.discount-course.destroy', $course->id) }}">
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
                    <!--  table end -->
                    <!--  pagination start -->
                    @include('backend.ui-components.pagination', ['data' => $data['courses']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection
