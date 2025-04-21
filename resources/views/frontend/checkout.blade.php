@extends('frontend.layouts.master')
@section('title', 'Instructor')
@section('content')


@php
$amount = 0 ;
    foreach ($data['carts'] as $cart){
        if($cart['is_discount'] === 11){
            $amount += $cart['discount_price'];
        }else{
            $amount += $cart['price'];
        }
    }
@endphp


    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->

    <!-- checkout area S t a r t-->
    <section class="ot-checkout-area section-padding bottom-padding">
        <div class="container">
            <form action="{{ route('checkout.payment') }}" method="post">
                @csrf
                <div class="row gutter-x-55">
                    <div class="col-lg-8">
                        <div class="billing-info">
                            <div class="payment-system">
                                <div class="d-flex">

                                    @foreach ($data['payment_method'] as $payment_method)
                                    <label class="card cursor payment-gateway-wrapper" @if($payment_method->name == 'Paynet') onClick="showPaynet()" @endif>
                                        <div class="payment-gateway-list d-flex  justify-content-between align-items-center">
                                            <div class="single-gateway-item">
                                                <div class="payment-icon">
                                                    <img src="{{ showImage(@$data['course']->image->original, 'payments/' . @$payment_method->name . '.png') }}"
                                                        alt="img" class="cover-image" width="100">
                                                </div>
                                                <div class="payment-content d-flex gap-10" >
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
                                    @include('paynetgateway::__payment_info', ['amount' => @$amount])
                                @endif

                                <div class="mt-2 mb-40">
                                    @error('payment_method')
                                        <div id="validationServer04Feedback" class="invalid-feedback d-inline">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="order-list shoping-cart-wrapper">
                                    <div class="order-heading mb-15">
                                        <h4 class="title">{{ ___('frontend.Order') }}</h4>
                                    </div>
                                    @foreach ($data['carts'] as $cart)
                                        <div class="shoping-cart-widget d-flex align-items-center">
                                            <div class="thumb">
                                                <a href="{{ route('frontend.courseDetails', $cart['slug']) }}">
                                                    <img src="{{ @$cart['image'] }}" class="img-cover" alt="img">
                                                </a>
                                            </div>
                                            <div
                                                class="d-flex flex-fill align-items-start  gap-4 shoping-cart-widget-info ">
                                                <div class="shoping-cart-info flex-fill">
                                                    <a href="{{ route('frontend.courseDetails', $cart['slug']) }}">
                                                        <h4 class="title colorEffect  font-600 line-clamp-1">
                                                            {{ @$cart['course_title'] }}
                                                        </h4>
                                                    </a>
                                                    <h5 class="author-name">by {{ @$cart['author'] }}</h5>
                                                    <div class="rating d-flex align-items-center gap-5">
                                                        <span
                                                            class="text-primary font-600 ">{{ number_format($cart['rating'], 1) }}</span>
                                                        <div class="d-flex align-items-center gap-2">
                                                            {{ rating_ui($cart['rating'], 16) }}
                                                        </div>
                                                        <span class="total-rating">
                                                            ({{ numberFormat($cart['total_review']) }})
                                                        </span>

                                                    </div>
                                                    <div class="d-flex align-items-center hours-lectures">
                                                        <p class="total-hours">{{ @$cart['length'] }}</p>
                                                        <p class="total-lecture">{{ @$cart['lessons'] }}
                                                            {{ ___('frontend.Lesson') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="shoping-wized-prise d-flex flex-column justify-content-end align-items-end">
                                                    <button class="clear-cart" data-id="{{ @$cart['course_id'] }}"> <i
                                                            class="ri-close-line"></i></button>
                                                    @if ($cart['is_discount'] === 11)
                                                        <span
                                                            class="price">{{ showPrice(@$cart['discount_price']) }}</span>
                                                        <span class="discount">{{ showPrice(@$cart['price']) }}</span>
                                                    @else
                                                        <span class="price">{{ showPrice(@$cart['price']) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="summary-card">
                            <div class="summary-heading">
                                <h4>{{ ___('frontend.Summary') }}</h4>
                            </div>
                            <div class="summary-price-section">
                                <div class="summary-price original">
                                    <p>{{ ___('frontend.Original Price') }}</p>
                                    <p>{{ showPrice($data['total_price']) }}</p>
                                </div>
                                <div class="summary-price discount">
                                    <p>{{ ___('frontend.Discounts') }}</p>
                                    @if ($data['discount'] > 0)
                                        <p>
                                            {{ showPrice($data['total_price'] - $data['discount']) }}
                                        </p>
                                    @else
                                        <p>
                                            {{ showPrice($data['discount']) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="final-price">
                                <p>{{ ___('frontend.Total Course fees') }}</p>
                                <p>
                                    @if ($data['discount'] > 0)
                                        {{ showPrice($data['discount']) }}
                                    @else
                                        {{ showPrice($data['total_price']) }}
                                    @endif
                                </p>
                            </div>
                            <div class="checkout-btn d-grid mb-16" id="complete_payment">
                                <button class="btn-primary-fill btn-block"
                                    type="submit">{{ ___('frontend.Complete Payment') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- End-of checkout-->

@endsection
@section('scripts')
    <script src="{{ asset('frontend/js/__course.js')}}" type="module"></script>

    <script>


        // function showPaynet() {
        //     $('#complete_payment').addClass('d-none');
        // }



    </script>
@endsection
