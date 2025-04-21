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
                                        <div class="dropdown dropdown-designation custom-dropdown-select"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{ ___('common.Category') }}">
                                            <select id="single" class="select2 form-control categories_select"
                                                name="category" data-href="{{ route('ajax-categories-list') }}">
                                                <option selected disabled>{{ ___('common.Select Category') }}</option>
                                                @if (@$_GET['category'])
                                                    <option value="{{ $_GET['category'] }}" selected>
                                                        {{ @$data['params']['category'] }}</option>
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <!-- end categories -->

                                    <!-- start categories -->
                                    <div class="align-self-center">
                                        <div class="dropdown dropdown-designation custom-dropdown-select"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{ ___('common.Instructor') }}">
                                            <select class="form-control instructor_select w-100" name="instructor_id"
                                                data-href="{{ route('ajax-instructor-list') }}">
                                                <option selected disabled>
                                                    {{ ___('common.Select Instructor') }}</option>
                                                @if (@$_GET['instructor_id'])
                                                    <option value="{{ $_GET['instructor_id'] }}" selected>
                                                        {{ @$data['params']['instructor'] }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end categories -->

                                    <!-- start categories -->
                                    <div class="align-self-center">
                                        <div class="dropdown dropdown-designation custom-dropdown-select"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{ ___('ui_element.status') }}">
                                            <select class="form-control select2 w-100" name="status">
                                                <option selected disabled>
                                                    {{ ___('common.Select Status') }}</option>
                                                @if (@$_GET['status'])
                                                    <option value="{{ $_GET['status'] }}" selected>
                                                        {{ @$data['params']['status'] }}</option>
                                                @endif
                                                <option value="1" {{ @$_GET['status'] == 1 ? 'selected' : '' }}>
                                                    {{ ___('common.Active') }}</option>
                                                <option value="3" {{ @$_GET['status'] == 3 ? 'selected' : '' }}>
                                                    {{ ___('common.Pending') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end categories -->

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
                        @if (hasPermission('course_create'))
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <a href="{{ route('course.create') }}" role="button" class="btn-add"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ ___('course.Add') }}">
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

                                @forelse ($data['courses'] as $key => $course)
                                    <tr>
                                        <td>{{ @$key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('frontend.courseDetails', @$course->slug) }}"
                                                class="text-primary">
                                                {{ Str::limit(@$course->title, 20) }}
                                            </a>
                                        </td>
                                        <td> {{ @$course->category->title }}</td>
                                        <td>
                                            {{ ___('common.Instructor') }} :
                                            <a href="{{ route('frontend.instructor.details', [$course->user->name, $course->user->id]) }}"
                                                class="text-primary">
                                                {{ @$course->instructor->name }}</a>
                                            @if (count(@$course->partnerInstructors()) > 0)
                                                <br>{{ ___('course.Partner') }} :
                                                {{ partner_instructor_ui(@$course->partnerInstructors()) }}
                                            @endif
                                        </td>

                                        <td>
                                            {{ ___('course.Total Section') }} :
                                            {{ numberFormat(@$course->sections->count()) }}
                                            <br>
                                            {{ ___('course.Total Lesson') }} :
                                            {{ numberFormat(@$course->lessons->count()) }}
                                        </td>

                                        <td>
                                            {{ numberFormat(@$course->total_enroll) }}
                                        </td>

                                        <td>
                                            @if (@$course->is_free)
                                                {{ ___('common.Free') }}
                                            @else
                                                {{ showPrice(@$course->price) }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ statusBackend(@$course->courseType->class, $course->courseType->name) }}
                                        </td>
                                        <td>
                                            {{ statusBackend(@$course->status->class, $course->status->name) }}
                                        </td>

                                        <td>
                                            {{ statusBackend(@$course->visibility->class, @$course->visibility->name) }}
                                        </td>

                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    @if (hasPermission('course_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.edit', [$course->id]) }}"><span
                                                                    class="icon mr-12"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('course_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.curriculum.index', [$course->id]) }}"><span
                                                                    class="icon mr-12">
                                                                    <i class="fa-solid fa-file-lines"></i>
                                                                </span>
                                                                {{ ___('common.Add Curriculum') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (module('LiveClass') && hasPermission('live_class_read'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('live_class.index', [$course->id]) }}"><span
                                                                    class="icon mr-12">
                                                                    <i class="fa-solid fa-globe"></i>
                                                                </span>
                                                                {{ ___('common.Add Live Class') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('course_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.assignment.index', [$course->id]) }}"><span
                                                                    class="icon mr-12"><i
                                                                        class="fa-solid fa-file-pdf"></i></span>
                                                                {{ ___('course.Add Assignment') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('course_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.notice-board.index', [$course->id]) }}"><span
                                                                    class="icon mr-12"><i
                                                                        class="fa-solid fa-file"></i></span>
                                                                {{ ___('course.Add NoticeBoard') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('course_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);"
                                                                data-href="{{ route('course.destroy', $course->id) }}">
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
                                        'colspan' => '10',
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
