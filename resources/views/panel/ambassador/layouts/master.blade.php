@include('frontend.include.header_script')
@if (Auth::check() && Auth::user()->role_id == 6)
    @include('organization::panel.organization.include.header')
@else
    @include('panel.ambassador.include.header')
@endif

<main>
    @if (Auth::check() && Auth::user()->role_id == 6)
        @include('organization::panel.organization.include.sidebar')
    @else
        @include('panel.ambassador.include.sidebar')
    @endif
    @yield('content')
</main>


@include('frontend.include.panel_footer')
@include('frontend.include.footer_script')
