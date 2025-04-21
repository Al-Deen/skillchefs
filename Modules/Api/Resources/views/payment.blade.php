<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ setting('author') }}">
    <meta name="baseurl" content="{{ url('/') }}">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ setting('application_name') }} </title>

    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/bootstrap-5.3.0.min.css') }}">
    <!-- fonts & icon -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/fonts-icon.css') }}">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/plugin.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/main-style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plyr/plyr.css') }}" />


    <style>
        ::-webkit-scrollbar {
        width: 8px;
        }

        ::-webkit-scrollbar-track {
        background-color: transparent; /* Set the track background color to transparent */
        }

        ::-webkit-scrollbar-thumb {
        background-color: transparent; /* Set the thumb background color to transparent */
        }
        .light-mode,
        .dark-mode {
            @if (Setting('ot_primary'))
                --ot-primary: {{ Setting('ot_primary') }} !important;
            @endif
            @if (Setting('ot_secondary'))
                --ot-secondary: {{ Setting('ot_secondary') }} !important;
            @endif
            @if (Setting('ot_tertiary'))
                --ot-tertiary: {{ Setting('ot_tertiary') }} !important;
            @endif
            @if (Setting('ot_primary_rgb'))
                --ot-primary-rgb: {{ Setting('ot_primary_rgb') }} !important;
            @endif
            @if (Setting('ot_secondary_rgb'))
                --ot-secondary-rgb: {{ Setting('ot_secondary_rgb') }} !important;
            @endif
            @if (Setting('ot_tertiary_rgb'))
                --ot-tertiary-rgb: {{ Setting('ot_tertiary_rgb') }} !important;
            @endif
            @if (Setting('ot_primary_btn'))
                --ot-primary-btn: {{ Setting('ot_primary_btn') }} !important;
            @endif
        }

        .section-tittle-two .title{
            font-size: 16px !important;
        }
        .h4, h4,
        .h5, h5,
        .h6, h6{
            font-size: 14px !important;
        }
        .comment_area .comment_list_wrapper .comment_list_single .comment_list_single_info h4{
            font-size: 14px !important;
        }
        .course-details-tabs .nav-item .nav-link span{
            font-size: 12px !important;
        }
        .course-details-tabs{
            grid-gap: 10px !important;
        }
        .small-tittle-two .title{
            font-size: 14px !important;
        }
        .btn-primary-fill{
            padding: 10px 16px !important;
            font-size: 12px !important;
        }
        .assignment-area .single-list-assignment .title{
            font-size: 12px !important;
        }

        .small, small,
        .noticeboard-list.accordion-list li div.answer p{
            font-size: 12px !important;
        }
    </style>
</head>

<body class="light-mode">
<main>
    <!-- Checkout S t a r t -->
    <section class="ot-checkout-area section-padding bottom-padding">
        <div class="container">
            <form action="{{ route('api.checkout.payment') }}" method="post">
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
                                                        <img src="{{ showImage(@$data['course']->image->original, 'payments/' . @$payment_method->name . '.png') }}"
                                                            alt="img" class="cover-image" width="100">
                                                    </div>
                                                    <div class="payment-content d-flex gap-10">
                                                        <!-- Radio -->
                                                        <input name="payment_method" class="radio" type="radio" checked
                                                        value="{{ encrypt($payment_method->name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
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
                    <div class="col-lg-5">
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
                            <div class="checkout-btn d-grid mb-16">
                                <button class="btn-primary-fill btn-block"
                                    type="submit">{{ ___('frontend.Complete Payment') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--End-of Checkout -->
</main>
@include('frontend.partials.lang-static')
<!-- toastr js-->

<script src="{{ url('frontend/assets/js/jquery-3.7.0.min.js') }} "></script>
<script src="{{ url('frontend/assets/js/popper.min.js') }} "></script>
<script src="{{ url('frontend/assets/js/bootstrap-5.3.0.min.js') }} "></script>
<!-- Plugin -->
<script src="{{ url('frontend/assets/js/plugin.js') }} "></script>
@include('backend.partials.alert-message')
<!-- multiple image upload -->
<script src="{{ asset('backend') }}/assets/js/multi_image.js"></script>
<!-- multiple image upload -->

<!-- Main js-->
<script src="{{ url('frontend/assets/js/main.js') }} "></script>
<script src="{{ asset('backend') }}/assets/js/ckeditor.js"></script>
<script src="{{ url('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/plyr/plyr.js') }}"></script>
    <script src="{{ asset('frontend/js/student/main.js') }}" type="module"></script>
    @if (@$data['lesson']->is_quiz == 1)
        <script src="{{ asset('frontend/js/student/quiz.js') }}" type="module"></script>
    @endif
</body>

</html>
