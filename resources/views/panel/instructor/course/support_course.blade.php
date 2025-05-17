@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')


    <!-- instructor Create new Course -->
    <section class="create-new-course">

        <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20 pb-20">
            <!-- Section Tittle -->
            <div class="section-tittle-two">
                <h2 class="title font-600 mb-20">{{ $data['title'] }} ( <strong>Course - {{ $data['course']->title }} </strong> )</h2>
            </div>
        </div>
            <div>
                    <!-- Title -->
                    <div class="setp-page-title mb-20 d-flex align-items-center justify-content-between flex-wrap">
                        <h4 class="title font-600">
                            <i class="ri-file-list-3-line"></i>Support
                        </h4>

                        <div class="search-tab ">
                            <a class="btn-primary-fill" href="{{ route('instructor.support.add',$data['course']->id) }}">
                                Add Support
                            </a>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="table-content table-basic ecommerce-components product-list">
                                <div class="card">
                                    <div class="card-body">
                                        <!--  table start -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="thead">
                                                <tr>
                                                    <th>ID</th>
                                                    <th> Meeting Link</th>
                                                    <th> Created By</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                <!-- end table header from ui-helper function -->
                                                </thead>
                                                <tbody class="tbody">
                                                @foreach($data['supports'] as $key=> $support)
                                                    <tr>
                                                        <td>{{ @$key + 1 }}</td>
                                                        <td>
                                                            <a target="_blank" href="{{ @$support->support_link }}"
                                                               class="text-primary">
                                                                {{ @$support->support_link }}
                                                            </a>
                                                        </td>
                                                        <td> {{ @$support->user->name }}</td>
                                                        <td>
                                                            @if(@$support->status == 1)
                                                                <span class="badge-basic-success-text text-bg-success" > Active</span>
                                                            @else
                                                                <span class="badge-basic-danger-text text-bg-danger" > Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                                    <li>
                                                                        <a href="{{ route('instructor.support.edit', $support->id) }}"
                                                                           class="action-success">
                                                                            <i class="ri-pencil-line"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="mb-2">
                                                                        <a href="javascript:;" class="action-danger"
                                                                           onclick="deleteFunction(`{{ route('instructor.support.delete', $support->id) }}`)">
                                                                            <i class="ri-delete-bin-line"></i>
                                                                        </a>
                                                                    </li>
                                                      </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--  table end -->
                                        <!--  pagination start -->
                                        @include('backend.ui-components.pagination', ['data' => $data['supports']])
                                        <!--  pagination end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </section>
    <!-- End-of Create new Course -->

@endsection
@section('scripts')
    <script src="{{ url('frontend/js/instructor/__course.js') }}"></script>
@endsection
