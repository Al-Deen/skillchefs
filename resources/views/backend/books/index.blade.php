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
                                             data-bs-title="{{ ___('common.Instructor') }}">
                                            <select class="form-control instructor_select w-100" name="instructor_id"
                                                    data-href="{{ route('ajax-instructor-list') }}">
                                                <option selected disabled>
                                                    {{ ___('common.Select Instructor') }}</option>
                                                @if(!empty($data['selectedInstructor']))
                                                    <option value="{{ $data['selectedInstructor']->id }}" selected>
                                                        {{ $data['selectedInstructor']->name }}
                                                    </option>
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
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <a href="{{ route('book.create') }}" role="button" class="btn-add"
                                       data-bs-toggle="tooltip" data-bs-placement="top"
                                       data-bs-title="Book Add">
                                        <span><i class="fa-solid fa-plus"></i> </span>
                                        <span class="d-none d-xl-inline">{{ ___('common.add') }}</span>
                                    </a>
                                </div>
                            </div>
                        <!-- add btn end -->
                    </div>
                    <!--toolbar table end -->
                    <!--  table start -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
                            <!-- start table header from ui-helper function -->
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Instructor</th>
                                <th>Price</th>
                                <th>Payable Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <!-- end table header from ui-helper function -->
                            </thead>
                            <tbody class="tbody">
                            @forelse ($data['books'] as $key => $book)
                                <tr>
                                    <td>{{ @$key + 1 }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('frontend.bookDetails', @$book->slug) }}"
                                           class="text-primary">
                                            {{ @$book->title }}
                                        </a>
                                    </td>
                                    <td>
                                        Instructor :
                                        <a target="_blank" href="{{ route('frontend.instructor.details', [$book->user->name, $book->user->id]) }}"
                                           class="text-primary">
                                            {{ @$book->instructor->name }}</a>
                                    </td>

                                    <td>
                                        @if (@$book->is_free)
                                            {{ ___('common.Free') }}
                                        @else
                                            {{ showPrice(@$book->price) }}
                                        @endif
                                    </td>

                                    <td>
                                        @if(@$book->is_free == 1)
                                            <span class="badge-basic-success-text" > Free</span>
                                        @else
                                            <span class="badge-basic-danger-text" > Paid</span>
                                        @endif
                                    </td>

                                    <td>
                                      @if(@$book->status == 1)
                                          <span class="badge-basic-success-text" > Active</span>
                                        @else
                                            <span class="badge-basic-danger-text" > Inactive</span>
                                        @endif
                                    </td>


                                    <td class="action">
                                        <div class="dropdown dropdown-action">
                                            <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">


                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{ route('book.edit', [@$book->id]) }}"><span
                                                                class="icon mr-12"><i
                                                                    class="fa-solid fa-pen-to-square"></i></span>
                                                            {{ ___('common.edit') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete_data" href="javascript:void(0);"
                                                           data-href="{{ route('book.destroy', $book->id) }}">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
                                                            <span>{{ ___('common.delete') }}</span>
                                                        </a>
                                                    </li>
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
                    @include('backend.ui-components.pagination', ['data' => $data['books']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection
