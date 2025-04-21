@extends('backend.master')

@section('title')
    {{ ___('common.Dashboard') }}
@endsection

@push('css')
    {{-- Chart js --}}
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/apexcharts.min.css">
@endpush

@section('content')
    <div class="page-content">
        <div class="row g-4">

            <!-- Welcome Title -->
            <div class="col-12">
                <div class="row">
                    <div class="dashboard-heading row align-items-center mt-6">
                        <div class="col-12 col-md-6 col-xl-6 col-lg-6">
                            <h3 class="title">{{ ___('dashboard.hello') }}, {{ Auth::user()->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Summery Card Start -->
            <div class="col-12 summery-card">
                <div class="row g-4">
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card summery-card ot-card h-100">
                            <div class="card-heading d-flex align-items-center">
                                <div class="card-icon circle-success dashboard-card-icon">
                                    <i class="las la-users"></i>
                                </div>
                                <div class="card-content">
                                    <h4>{{ ___('dashboard.Total_Student') }}</h4>
                                    <h1>{{ shorten_number(@$data['student'] ?? 0) }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card summery-card ot-card h-100">
                            <div class="card-heading d-flex align-items-center">
                                <div class="card-icon circle-warning dashboard-card-icon">
                                    <i class="las la-users"></i>
                                </div>
                                <div class="card-content">
                                    <h4>{{ ___('dashboard.Total_Instructor') }}</h4>
                                    <h1>{{ shorten_number($data['instructor'] ?? 0) }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card summery-card ot-card h-100">
                            <div class="card-heading d-flex align-items-center">
                                <div class="card-icon  circle-lightseagreen dashboard-card-icon">
                                    <i class="las la-book-open"></i>
                                </div>
                                <div class="card-content">
                                    <h4>{{ ___('dashboard.Total_Course') }}</h4>
                                    <h1>{{ shorten_number(@$data['course'] ?? 0) }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card summery-card ot-card h-100">
                            <div class="card-heading d-flex align-items-center">
                                <div class="card-icon circle-danger dashboard-card-icon">
                                    <i class="las la-chart-area"></i>
                                </div>
                                <div class="card-content">
                                    <h4>{{ ___('dashboard.Total_Sales') }}</h4>
                                    <h1>{{ shorten_number(@$data['enroll'] ?? 0) }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Summery Card End -->

            <div class="col-12 statistic-card">
                <div class="row g-4">
                    <div class="ot-charts col-12 col-xxl-12">
                        <div class="card statistic-card ot-card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>{{ ___('dashboard.Revenue') }}</h4>
                                </div>
                            </div>
                            {{-- Cahrt revenue Chart --}}
                            <div id="revenueChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 col-xl-12 ">
                <div class="ot-card chart-card2 h-calc">

                    {{-- Tittle --}}
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">
                            <h4>{{ ___('dashboard.Sales') }}</h4>
                        </div>
                    </div>

                    {{-- Chart --}}
                    <div id="sales_chart" class=""></div>
                </div>
            </div>

            <div class="col-12">
                <div class="row g-4">
                    <div class="ot-charts col-xxl-8 col-xl-8 table-content table-basic">
                        <div class="card ot-card ot-visit-chart h-calc">
                            <div class="card-title mb-20">
                                <h4>{{ ___('dashboard.Top_courses') }}</h4>
                            </div>

                            <div class="table-responsive ">
                                <table class="table table-bordered">
                                    <thead class="thead">
                                        <tr>
                                            <th>{{ ___('common.ID') }}</th>
                                            <th>{{ ___('common.name') }} </th>
                                            <th>{{ ___('student.Enroll') }}</th>
                                            <th>{{ ___('common.Sales') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @forelse ($data['top_courses'] as $key => $course)
                                            <tr>
                                                <td>
                                                    {{ @$key + 1 }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('frontend.courseDetails', @$course->slug) }}"
                                                        class="text-peragraph">
                                                        {{ Str::limit(@$course->title, 40) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ @$course->totalEnroll() }}
                                                </td>
                                                <td>
                                                    {{ showPrice(@$course->totalAmountSales()) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <!-- empty table -->
                                            @include('backend.ui-components.empty_table', [
                                                'colspan' => '4',
                                                'message' => ___(
                                                    'message.Please add a new entity or manage the data table to see the content here'),
                                            ])
                                            <!-- empty table -->
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!--  table end -->
                        </div>
                    </div>
                    <div class="ot-charts col-12 col-xxl-4">
                        <div class="card ot-card ot-visit-chart h-calc">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>{{ ___('dashboard.Summary') }}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush height-300 nice-scroll">

                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-users fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title"> {{ ___('dashboard.Total_Student') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['student'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-user fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Total_Instructor') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['instructor'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-book-open fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Total_Active_Course') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['active_course'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-book-open fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Total_Pending_Course') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['pending_course'] ?? 0) }}
                                        </span>
                                    </li>

                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-book-open fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Featured_Course') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['featured_course'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-book-open fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Discount_Course') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['discount_course'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-circle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Total_Sales') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['enroll'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-circle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Certificates') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['certificate_generate'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-circle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Pending_Payout') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ shorten_number(@$data['pending_payout'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-dollar-sign"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Income') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ showPrice(@$data['income'] ?? 0) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex gap-2 justify-content-between align-items-center">
                                        <div class="badge badge-light-primary">
                                            <i class="las la-dollar-sign"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="title">{{ ___('dashboard.Expense') }}</div>
                                        </div>
                                        <span class="badge badge-light-success fs-8 fw-bold">
                                            {{ showPrice(@$data['expense'] ?? 0) }}
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Table --}}


            <!--  top five student start -->
            <div class="col-lg-6 table-content table-basic">
                <div class="card h-calc">
                    <div class="card-body">
                        <div class="card-title mb-20">
                            <h4>{{ ___('dashboard.Top_Five_Students') }}</h4>
                        </div>

                        <div class="table-responsive table-height-350 niceScroll">
                            <table class="table table-bordered">
                                <thead class="thead">
                                    <tr>
                                        <th class="serial">{{ ___('common.ID.') }}</th>
                                        <th class="purchase">{{ ___('common.name') }}</th>
                                        <th class="purchase">{{ ___('student.Enroll') }}</th>
                                        <th class="purchase">{{ ___('student.Point') }}</th>
                                        <th class="purchase">{{ ___('common.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @forelse ($data['top_students'] as $key => $student)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                {{ @$student->user->name }}
                                            </td>
                                            <td>{{ @$student->points }}</td>
                                            <td>{{ @$student->enrollments->count() }}</td>
                                            <td>
                                                @if (@$student->user->status == App\Enums\Status::ACTIVE)
                                                    <span
                                                        class="badge-basic-success-text">{{ ___('common.Active') }}</span>
                                                @else
                                                    <span
                                                        class="badge-basic-danger-text">{{ ___('common.Inactive') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- empty table -->
                                        @include('backend.ui-components.empty_table', [
                                            'colspan' => '5',
                                            'message' => ___(
                                                'message.Please add a new entity or manage the data table to see the content here'),
                                        ])
                                        <!-- empty table -->
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--  table end -->
                    </div>
                </div>
            </div>
            <!--  top five student end -->

            <!--  top five instructor start -->
            <div class="col-lg-6 table-content table-basic">
                <div class="card h-calc">
                    <div class="card-body">
                        <div class="card-title mb-20">
                            <h4>{{ ___('dashboard.Top_Five_Instructors') }}</h4>
                        </div>

                        <div class="table-responsive table-height-350 niceScroll">
                            <table class="table table-bordered">
                                <thead class="thead">
                                    <tr>
                                        <th class="serial">{{ ___('common.ID.') }}</th>
                                        <th class="purchase">{{ ___('common.name') }}</th>
                                        <th class="purchase">{{ ___('course.Courses') }}</th>
                                        <th class="purchase">{{ ___('common.Sales') }}</th>
                                        <th class="purchase">{{ ___('common.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @forelse ($data['top_instructors'] as $key => $instructor)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                {{ @$instructor->user->name }}
                                            </td>
                                            <td>{{ @$instructor->courses->count() }}</td>
                                            <td>{{ @$instructor->user->courseEnroll ? @$instructor->user->courseEnroll->count() : 0 }}</td>
                                            <td>
                                                @if (@$instructor->user->status == App\Enums\Status::ACTIVE)
                                                    <span
                                                        class="badge-basic-success-text">{{ ___('common.Active') }}</span>
                                                @else
                                                    <span
                                                        class="badge-basic-danger-text">{{ ___('common.Inactive') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- empty table -->
                                        @include('backend.ui-components.empty_table', [
                                            'colspan' => '5',
                                            'message' => ___(
                                                'message.Please add a new entity or manage the data table to see the content here'),
                                        ])
                                        <!-- empty table -->
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--  table end -->
                    </div>
                </div>
            </div>
            <!--  top five instructor end -->


        </div>
        <!-- table leave container end -->
    </div>
@endsection

@push('script')
    <script src="{{ asset('backend') }}/vendors/apexchart/js/apexcharts.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/apex-chart.js"></script>
@endpush
