@include('frontend.include.header_script')

@include('panel.student.include.header')

<main>
    @include('panel.student.include.sidebar')
    @yield('content')
</main>

@include('frontend.include.panel_footer')

@include('frontend.include.footer_script')
