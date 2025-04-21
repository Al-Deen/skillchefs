@extends('frontend.layouts.master')
@section('title', $data['title'] ?? 'Cartfghgf')
@section('content')


    <!--Bradcam S t a r t -->
    <div class="ot-bradcam-area footer-bg" id="ot_breadcrumb">
        <!-- get data from breadcrumb() -->
    </div>
    <!--End-of Bradcam  -->

    <!-- SHOPING_CART::START  -->
    <div class="shoping-cart-area section-padding" id="ot_shoppingCart">
        <!-- get data from shoppingCart() -->

    </div>
    <!-- SHOPING_CART::END  -->


@endsection
@section('scripts')
    <script>
        breadcrumb();
        shoppingCart();
        recommendedCourses();
    </script>
@endsection
