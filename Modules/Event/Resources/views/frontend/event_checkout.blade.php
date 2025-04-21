@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->

    <!-- event checkout area S t a r t-->
    <section class="ot-checkout-area section-padding bottom-padding">
        <div class="container">
            <form action="{{ route('frontend.event.checkout.payment') }}" method="post">
                @csrf
                <div class="row gutter-x-55">
                    <div class="col-lg-7">
                        <div class="billing-info">
                            <div class="payment-system">
                                <div class="d-flex">
                                    @foreach ($data['payment_method'] as $payment_method)
                                        <label class="card cursor payment-gateway-wrapper">
                                            <div class="payment-gateway-list d-flex  justify-content-between align-items-center">
                                                <div class="single-gateway-item">
                                                    <div class="payment-icon">
                                                        {{ @$data['course'] }}
                                                        <img src="{{ showImage(@$data['course']->image->original, 'payments/' . @$payment_method->name . '.png') }}"
                                                            alt="img" class="cover-image" width="100">
                                                    </div>
                                                    <div class="payment-content d-flex gap-10">
                                                        <!-- Radio -->
                                                        @if($payment_method->name == 'offline')
                                                        <input name="payment_method" class="radio" type="radio" value="offline">
                                                        @elseif($payment_method->name == 'Paynet')
                                                        <input name="payment_method" class="radio" type="radio" value="Paynet">
                                                        @else
                                                            <input name="payment_method" class="radio" type="radio" value="{{ encrypt($payment_method->name) }}">
                                                        @endif

                                                        {{-- <input name="payment_method" class="radio" type="radio" value="{{ $payment_method->name == 'offline' ? 'offline' : encrypt($payment_method->name) }}"> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @if(module('Offline'))
                                    @include('offline::frontend.partials.offline_checkout')
                                @endif



                                @if(module('PaynetGateway'))
                                    @include('paynetgateway::__payment_info',['amount' => intval(@$data['event']->price)])
                                @endif

                                <div class="mt-2 mb-40">
                                    @error('payment_method')
                                        <div id="validationServer04Feedback" class="invalid-feedback d-inline">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="summary-card">
                            <div class="summary-heading">
                                <h4>{{ ___('frontend.Summary') }}</h4>
                            </div>
                            <div class="summary-price-section">
                                <div class="summary-price original">
                                    <p>{{ ___('frontend.Price') }}</p>
                                    <p>{{ showPrice(@$data['event']->price) }}</p>
                                    <input type="hidden" name="event_slug" value="{{ encrypt(@$data['event']->slug) }}">
                                </div>
                            </div>
                            <div class="checkout-btn d-grid mb-16">
                                <button class="btn-primary-fill btn-block" type="submit">{{ ___('frontend.Complete Payment') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- End-of event checkout-->
@endsection
@section('scripts')
    <script src="{{ asset('frontend/js/__course.js')}}" type="module"></script>
@endsection
