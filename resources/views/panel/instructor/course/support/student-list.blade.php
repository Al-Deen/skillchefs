@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')


    <!-- instructor Create new Course -->
    <section class="create-new-course">

        <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20 pb-20">
            <!-- Section Tittle -->
            <div class="section-tittle-two">
                <h2 class="title font-600 mb-20">{{ $data['title'] }} ( <strong>Course - {{$data['supportStudents'][0]?->course->title ?? ''}} </strong> )</h2>
            </div>
        </div>
        <div>
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
                                            <th> Student Name</th>
                                            <th> Start Time </th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        <!-- end table header from ui-helper function -->
                                        </thead>
                                        <tbody class="tbody">
                                        @foreach($data['supportStudents'] as $key=> $supportStudent)
                                            <tr>
                                                <td>{{ @$key + 1 }}</td>
                                                <td>{{ @$supportStudent->user->name}}</td>
                                                <td>{{ \Carbon\Carbon::parse($supportStudent->start_time)->format('h:i A') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($supportStudent->end_time)->format('h:i A') }}</td>
                                                <td>
                                                    @if(@$supportStudent->status == 0)
                                                        <span class="badge bg-warning text-dark">Waiting</span>
                                                    @elseif(@$supportStudent->status == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Terminated</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(@$supportStudent->status != 2)
                                                    <li>
                                                        <a href="{{ route('instructor.support.student-terminate', $supportStudent->id) }}"
                                                           class="text-danger">
                                                            <i class="ri-close-circle-line me-1"></i> Terminate
                                                        </a>
                                                    </li>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--  table end -->
                                <!--  pagination start -->
                                @include('backend.ui-components.pagination', ['data' => $data['supportStudents']])
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
