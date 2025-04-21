<!DOCTYPE html>
<html lang="en" dir="{{ @findDirectionOfLang() }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <!-- Favicon start -->
    <link rel="icon" type="image/x-icon" href="{{ @showImage(setting('favicon'), 'favicon.png') }}">
    <!-- Favicon end -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="author" content="{{ setting('author') }}">
    <meta name="description" content="{{ setting('meta_description') }}">

    <!-- css  -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/icon-fonts.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/apexcharts.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/plugin.css">
    <!-- metis menu for sidebar  -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/metisMenu.min.css">
    <!-- Custom CSS  start -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/custom.css">
</head>


<body class="default-theme {{ @findDirectionOfLang() }}" dir="{{ @findDirectionOfLang() }}">
    <!-- main content start -->
    <main class="auth-page">
        <section class="auth-container">
            <div
                class="form-wrapper pv-80 ph-100 bg-white d-flex justify-content-center align-items-center flex-column">
                <div class="form-container d-flex justify-content-center align-items-start flex-column">
                    <div class="mb-40">
                        <a href="{{ url('/') }}">
                            <img class="logo_custom" src="{{ userTheme() == 'default-theme' ? @showImage(setting('light_logo'), 'logo.png') : @showImage(setting('dark_logo'), 'logo.png') }}"
                                alt="img" />
                        </a>
                    </div>
                    @yield('content')
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('backend') }}/assets/js/theme.js"></script>

    <!-- main content end -->
    <script src="{{ asset('backend') }}/assets/js/jquery-3.7.0.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/plugin.js"></script>

    <script src="{{ asset('backend') }}/assets/js/show-hide-password.js"></script>

    @include('backend.partials.alert-message')
    @yield('script')

</body>

</html>
