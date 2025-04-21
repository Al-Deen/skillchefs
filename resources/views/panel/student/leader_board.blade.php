@extends('panel.student.layouts.master')
@section('title', @$data['title'])
@section('content')
    <section>
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                    <h2 class="title font-600 mb-20">{{ @$data['title'] }}</h2>
                </div>
            </div>
        </div>
        <!-- Report Table -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="mb-24">
                    <div class="activity-table">
                        <table class="table-responsive">
                            <thead>
                                <tr>
                                    <th>{{ ___('student.Name') }}</th>
                                    <th>{{ ___('student.Position') }}</th>
                                    <th>{{ ___('student.Country') }}</th>
                                    <th>{{ ___('student.Points') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (@$data['students'] as $key => $student)
                                    <tr>
                                        <td>
                                            {{ @$student->user->name }}
                                        </td>
                                        <td>
                                            {{ @$key + 1 }}
                                        </td>
                                        <td>
                                            <div class="flag-icon d-flex align-items-center">
                                                <i class="fi fi-{{ strtolower(@$student->country->code) }}"></i>
                                                <span>
                                                    {{ @$student->user->country }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ @$student->points }}
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            {{-- No Data Found --}}
                                            <div class="row justify-content-center">
                                                <div class="col-lg-3 col-md-6 col-sm-6">
                                                    <div class="not-data-found table-img text-center pt-50 pb-10">
                                                        <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                                            alt="img" class="w-100 mb-20 w-25">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  pagination start -->
    {!! @$data['students']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->


@endsection
