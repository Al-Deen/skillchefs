@include('frontend.include.loader')
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
@if (auth()->check() && auth()->user()->role_id == '5')
    <script src="{{ url('frontend/js/instructor/main.js') }}" type="module" ></script>
@elseif(module('Organization') && auth()->check() && auth()->user()->role_id == '6')
    <script src="{{ url('modules/organization/js/main.js') }}" type="module" ></script>
@endif
<script type="module" src="{{url('frontend/js/__authentication.js')}}"></script>
@yield('scripts')

</body>

</html>
