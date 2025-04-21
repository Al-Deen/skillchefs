@extends('frontend.layouts.master')
@section('title', $data['title'])
@section('content')


    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->

    <!-- Shopping card  -->
    <div class="shoping-cart-area section-padding2">
        @include('frontend.partials.cart.list')
    </div>
    <!-- End-of Shopping card  -->

@endsection
@section('scripts')
  <script src="{{ asset('frontend/js/__course.js')}}" type="module"></script>
@endsection
