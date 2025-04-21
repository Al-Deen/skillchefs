@include('frontend.include.header_script')
<body class="playlist light-mode {{ @findDirectionOfLang() }}" dir="{{ @findDirectionOfLang() }}">
@yield('content')
@include('frontend.include.panel_footer')
</body>
@include('frontend.include.footer_script')
