@php
    $total = 0;
    $discount = 0;
@endphp
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="shoping-cart-heading mb-30 pb-8">
                <h5 class="fs-6 font-500 text-title">{{ count($data['carts']) }} {{ ___('frontend.Course in cart') }}
                </h5>
            </div>
        </div>
    </div>
    <div class="row justify-content-between ">
        <div class="col-xl-8 col-lg-8">
            <div class="shoping-cart-wrapper mb-24">
                @foreach ($data['carts'] as $cart)
                    @php
                        $total += $cart['price'];
                        $discount += $cart['discount_price'];
                    @endphp

                    <!-- single product cart-->
                    <div class="shoping-cart-widget d-flex align-items-center">
                        <div class="thumb">
                            <a href="{{ route('frontend.courseDetails', $cart['slug']) }}">
                                <img src="{{ @$cart['image'] }}" class="img-cover" alt="img">
                            </a>
                        </div>
                        <div class="d-flex flex-fill align-items-start  gap-4 shoping-cart-widget-info ">
                            <div class="shoping-cart-info flex-fill">
                                <a href="{{ route('frontend.courseDetails', $cart['slug']) }}">
                                    <h4 class="title colorEffect  font-600 line-clamp-1">{{ @$cart['course_title'] }}
                                    </h4>
                                </a>
                                <h5 class="author-name">by {{ @$cart['author'] }}</h5>
                                <div class="rating d-flex align-items-center gap-5">
                                    <span class="text-primary font-600 ">{{ number_format($cart['rating'], 1) }}</span>
                                    <div class="d-flex align-items-center gap-2">
                                        {{ rating_ui($cart['rating'], 16) }}
                                    </div>
                                    <span class="total-rating">
                                        ({{ numberFormat($cart['total_review']) }})
                                    </span>

                                </div>
                                <div class="d-flex align-items-center hours-lectures">
                                    <p class="total-hours">{{ @$cart['length'] }}</p>
                                    <p class="total-lecture">{{ @$cart['lessons'] }} {{ ___('frontend.Lesson') }}
                                    </p>
                                </div>
                            </div>
                            <div class="shoping-wized-prise d-flex flex-column justify-content-end align-items-end">
                                <button class="clear-cart" data-id="{{ @$cart['course_id'] }}">
                                    <i class="ri-close-line"></i>
                                </button>
                                @if ($cart['is_discount'] === 11)
                                    <span class="price">{{ showPrice(@$cart['discount_price']) }}</span>
                                    <span class="discount" style="color: #FF4B55">{{ showPrice(@$cart['price']) }}</span>
                                    @if ($cart['discount_type'] == 1)
                                        <h6 class="offer-text d-inline-block ms-2"> - {{ showPrice($cart['discount']) }} </h6>
                                    @else
                                        <h6 class="offer-text d-inline-block ms-2"> -{{ $cart['discount']}}% </h6>
                                    @endif
                                @else
                                    <span class="price">{{ showPrice(@$cart['price']) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- single product cart-->
                @endforeach

            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="total-checkout-prormo mb-24">
                <h5 class="text-18  font-600">{{ ___('frontend.Total') }}</h5>
                @if ($discount > 0)
                    <h3 class="current-prise">{{ showPrice($discount) }}</h3>
                    <div class="d-flex  align-items-center gap-15 mb-30">
                        <h4 class="text-decoration-line-through prev-prise" style="color: #FF4B55">{{ showPrice($total) }}</h4>
                        <h4 class="offer-text">{{ number_format((($discount - $total) / $total) * 100) }}%
                            {{ ___('frontend.off') }}</h4>
                    </div>
                @else
                    <h3 class="current-prise">{{ showPrice($total) }}</h3>
                @endif
                <div class="promo_box mt-50">
                    <a href="{{ route('checkout.index') }}"
                        class="btn-primary-fill w-100">{{ ___('frontend.Checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
