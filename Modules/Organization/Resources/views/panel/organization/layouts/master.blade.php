@include('frontend.include.header_script')
@include('organization::panel.organization.include.header')

<main>
    @include('organization::panel.organization.include.sidebar')
    @yield('content')
</main>


@include('frontend.include.panel_footer')
@include('frontend.include.footer_script')
