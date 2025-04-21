@include('frontend.include.header_script')
<body class="light-mode {{ @findDirectionOfLang() }}" dir="{{ @findDirectionOfLang() }}">
<main>
    @yield('content')
</main>
@include('frontend.include.footer_script')
