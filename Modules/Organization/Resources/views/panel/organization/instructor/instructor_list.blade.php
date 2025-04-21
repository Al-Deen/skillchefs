@extends('organization::panel.organization.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- Dashboard Card S t a r t -->
    <div class="dashboared-card mb-40">
        <div class="row g-24">
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-one h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-user-3-fill"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera font-600">{{ ___('instructor.Total Instructor') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number(@$data['total_instructor']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-two h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-user-unfollow-fill"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-16 font-600">{{ ___('instructor.Pending Instructor') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number($data['instructor_pending']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-four h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-user-follow-fill"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-16 font-600">{{ ___('instructor.Approved Instructor') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ shorten_number($data['instructor_approved']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of card -->
    <!-- instructor Courses activity Start -->
    <section class="instructor-courses-activity">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap">
                    <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    <div class="right d-flex flex-wrap justify-content-between">
                        <!-- Search Box -->
                        <form action="" class="search-box-style mb-20 mr-10">
                            <div class="responsive-search-box">
                                <input class="ot-search " type="text" name="search"
                                    placeholder="{{ ___('placeholder.Search Instructor') }}" value="{{ @$_GET['search'] }}">
                                <!-- icon -->
                                <div class="search-icon">
                                    <i class="ri-search-line"></i>
                                </div>
                                <!-- Button -->
                                <button class="search-btn">
                                    {{ ___('frontend.Search') }}
                                </button>
                            </div>
                        </form>
                        <!-- /End -->
                        <div class="search-tab ">
                            <a class="btn-primary-fill main-modal-open" data-url="{{ route('organization.instructor.add') }}">
                                <i class="ri-add-line"></i> {{ ___('organization.Add New Instructor') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="activity-table">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>{{ ___('instructorCommon.ID') }}</th>
                                <th>{{ ___('instructor.Name') }}</th>
                                <th>{{ ___('instructorCommon.Course') }}</th>
                                <th>{{ ___('instructor.Sales') }}</th>
                                <th>{{ ___('instructorCommon.Income') }}</th>
                                <th>{{ ___('instructorCommon.Balance') }}</th>
                                <th>{{ ___('instructorCommon.Status') }}</th>
                                <th>{{ ___('instructorCommon.Created_at') }}</th>
                                <th>{{ ___('instructorCommon.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['instructors'] as $key => $instructor)
                                <tr>
                                    <td> {{ $loop->iteration }}</td>
                                    <td>{{ Str::limit(@$instructor->user->name, 20) }}</td>
                                    <td> {{ @$instructor->courses->count() }}</td>
                                    <td> {{ @$instructor->enroll->count() }}</td>
                                    <td>{{ showPrice(@$instructor->earnings) }}</td>
                                    <td>{{ showPrice(@$instructor->balance) }}</td>
                                    <td>
                                        @if (@$instructor->user->userStatus->name === "Approve")
                                            <span class="status-success">
                                                {{ ___('instructorCommon.Approve') }}
                                            </span>
                                        @elseif (@$instructor->user->userStatus->name === "Suspended")
                                            <span class="status-warning">
                                                {{ ___('instructorCommon.Suspend') }}
                                            </span>
                                        @else
                                            <span class="status-pending">
                                                {{ ___('instructorCommon.Pending') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="create-date">{{ showDate(@$instructor->created_at) }}</td>
                                    <td>

                                        <a href="{{ route('organization.instructor.edit', [encryptFunction($instructor->user->id), 'general']) }}" class="action-success">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        @if(@$instructor->user->userStatus->name === "Approve")
                                        <a href="javascript:;" class="action-tertiary" onclick="suspendFunction(`{{ route('organization.instructor.suspend', $instructor->id) }}`, `{{ ___('organization.Yes_suspend_it') }}`)">
                                            <i class="ri-admin-line"></i>
                                        </a>
                                        @else
                                        <a href="javascript:;" class="action-success" onclick="approveFunction(`{{ route('organization.instructor.approve', $instructor->id) }}`, `{{ ___('organization.Yes_approve_it') }}`)">
                                            <i class="ri-user-follow-line"></i>
                                        </a>
                                        @endif
                                        <a href="javascript:;" class="action-danger" onclick="deleteFunction(`{{ route('organization.instructor.delete', $instructor->id) }}`)">
                                            <i class="ri-delete-bin-line"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="alert alert-warning">
                                            {{ ___('instructor.No Instructor Found') }}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of courses activity  -->
    <!--  pagination start -->
    {!! @$data['instructors']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->
@endsection
