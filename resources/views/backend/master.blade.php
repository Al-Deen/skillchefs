<!DOCTYPE html>
<html lang="en" dir="{{ @findDirectionOfLang() }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title') | {{ setting('application_name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ @showImage(setting('favicon'), 'favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" name="url" id="url" value="{{ url('') }}">

    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="author" content="{{ setting('author') }}">
    <meta name="description" content="{{ setting('meta_description') }}">

    @if (findDirectionOfLang() == 'rtl')
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/bootstrap.min.css">
    @endif

    <!-- css  -->
    <!-- metis menu for sidebar  -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/metisMenu.min.css">
    {{-- All icon-fonts --}}
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/icon-fonts.css">
    <!-- All Plugin  -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/plugin.css">
    <!-- Custom CSS  start -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/custom.css">
    @stack('css')
</head>

<body class="{{ @findDirectionOfLang() }} default-theme" dir="{{ @findDirectionOfLang() }}">

    <div id="layout-wrapper">
        <!-- start header -->
        @include('backend.partials.header')
        <!-- end header -->

        <!-- start sidebar -->
        @include('backend.partials.sidebar')
        <!-- end sidebar -->
        {{-- main-content ph-32 pt-100 pb-20 --}}
        <main class="main-content ph-32 pt-100">
            <!-- start main content -->
            @yield('content')
            <!-- end main content -->

            <!-- start footer -->
            @include('backend.partials.footer')
            <!-- end footer -->
        </main>
    </div>
    <!-- start lang static -->
    @include('backend.partials.lang-static')
    <!-- end lang static -->
    {{-- theme mode switch --}}
    <script src="{{ asset('backend') }}/assets/js/theme.js"></script>
    {{-- theme mode switch --}}
    <script src="{{ asset('backend') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/jquery-3.7.0.min.js"></script>
    <!-- Metis menu for sidebar  -->
    <script src="{{ asset('backend') }}/assets/js/metisMenu.min.js"></script>
    <!-- Metis menu for sidebar  -->
    {{-- All Plugin js --}}
    <script src="{{ asset('backend') }}/assets/js/plugin.js"></script>
    {{-- All Plugin js --}}
    <script src="{{ asset('backend') }}/assets/js/ckeditor.js"></script>
    {{-- alert message --}}
    @include('backend.partials.alert-message')
    {{-- alert message --}}
    <script src="{{ asset('backend') }}/assets/js/main.js"></script>
    {{-- Custom Js --}}
    <script src="{{ asset('backend') }}/assets/js/multi_image.js"></script>
    <script src="{{ asset('backend') }}/assets/js/file-uploader.js"></script>
    @stack('script')
    <script src="{{ asset('backend') }}/assets/js/custom.js"></script>
    <script src="{{ asset('backend') }}/assets/js/select-request.js"></script>

</body>

</html>
