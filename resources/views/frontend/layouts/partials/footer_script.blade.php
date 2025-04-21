<!-- jquery-->
<script src="{{ url('frontend/assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ url('frontend/assets/js/popper.min.js') }}"></script>
<script src="{{ url('frontend/assets/js/bootstrap-5.3.0.min.js') }}"></script>
<!-- Plugin -->
<script src="{{ url('frontend/assets/js/plugin.js') }}"></script>
<!-- Plugin -->
<!-- Main -->
<script src="{{ url('frontend/assets/js/main.js') }}"></script>
<!-- Main -->
<!-- toastr js-->
@include('backend.partials.alert-message')

<!-- Backend dev written js-->
<script src="{{ url('frontend/js/main.js') }}"></script>
<script type="module" src="{{url('frontend/js/__authentication.js')}}"></script>
<!-- End Backend dev written js-->
@yield('scripts')
</body>

</html>
