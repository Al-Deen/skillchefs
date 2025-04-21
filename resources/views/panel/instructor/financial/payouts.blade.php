@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')


    <!-- Dashboard Card S t a r t -->
    <div class="dashboared-card mb-24">
        <div class="row g-24">
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-one h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-line-chart-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera font-600">{{ ___('instructor.Total Earnings') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ getCurrencySymbol() }}
                                {{ shorten_number(@$data['instructor']->earnings ?? 0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-two h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-16 font-600">{{ ___('instructor.Available Balance') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ getCurrencySymbol() }}
                                {{ shorten_number(@$data['instructor']->balance ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="single-dashboard-card single-dashboard-card2 carts-bg-four h-calc d-flex align-items-center">
                    <div class="icon">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <div class="cat-caption">
                        <p class="pera text-16 font-600">{{ ___('instructor.Total Payouts') }}</p>
                        <!-- Counter -->
                        <div class="single-counter mb-15">
                            <p class="currency">
                                {{ getCurrencySymbol() }}
                                {{ shorten_number(@$data['instructor']->payouts()->where('status_id', 4)->sum('amount') ?? 0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of card -->
    <!-- instructor financial Transection Start -->
    <section class="instructor-financial-transection">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom pb-20 d-flex align-items-center justify-content-between flex-wrap mb-20">
                    <h2 class="title font-600">{{ $data['title'] }}</h2>
                    <button class="btn-primary-outline main-modal-open"
                        data-url="{{ route('instructor.payout_request') }}">
                        <i class="ri-add-line"></i>
                        {{ ___('instructor.Withdrawal') }}
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of instructor financial Transection  -->
    <!-- History Table S t a r t -->
    <div class="history-table">
        <div class="row">
            <div class="col-xl-12">
                <div class="activity-table">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>{{ ___('common.ID') }}</th>
                                <th>{{ ___('instructor.Request Amount') }}</th>
                                <th>{{ ___('instructor.Type') }}</th>
                                <th>{{ ___('instructor.Payment Method') }}</th>
                                <th>{{ ___('instructor.Date') }}</th>
                                <th>{{ ___('instructor.Status') }}</th>
                                <th>{{ ___('instructor.Payment Status') }}</th>
                                <th>{{ ___('common.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['payouts'] as $key => $payout)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ showPrice($payout->amount) }}
                                    </td>
                                    <td>Manual</td>
                                    <td>
                                        {{ Str::ucfirst(@$payout->instructorPaymentMethod->paymentMethod->name) }}
                                    </td>
                                    <td>
                                        {{ showDate($payout->created_at) }}
                                    </td>
                                    <td>
                                        <span class="text-{{ $payout->status->class }}">
                                            {{ $payout->status->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-{{ $payout->payment_status->class }}">
                                            {{ $payout->payment_status->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('instructor.payout_details', $payout->id) }}"
                                            class="action-success">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
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
        <!--  pagination start -->
        {!! @$data['payouts']->links('frontend.partials.pagination-count') !!}
        <!--  pagination end -->
    </div>
    <!-- End-of History Table -->
@endsection
