<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ setting('author') }}">
    <meta name="baseurl" content="{{ url('/') }}">
    @stack('meta')
    <link rel="icon" type="image/x-icon" href="{{ @showImage(setting('favicon'), 'favicon.png') }}">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ setting('application_name') }} </title>


    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/bootstrap-5.3.0.min.css') }}">
    <!-- fonts & icon -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/fonts-icon.css') }}">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/plugin.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/main-style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('frontend/css/custom.css') }}">

    @yield('css')
    <style>
        .light-mode,
        .dark-mode {
            @if (Setting('ot_primary'))
                --ot-primary: {{ Setting('ot_primary') }} !important;
            @endif
            @if (Setting('ot_secondary'))
                --ot-secondary: {{ Setting('ot_secondary') }} !important;
            @endif
            @if (Setting('ot_tertiary'))
                --ot-tertiary: {{ Setting('ot_tertiary') }} !important;
            @endif
            @if (Setting('ot_primary_rgb'))
                --ot-primary-rgb: {{ Setting('ot_primary_rgb') }} !important;
            @endif
            @if (Setting('ot_secondary_rgb'))
                --ot-secondary-rgb: {{ Setting('ot_secondary_rgb') }} !important;
            @endif
            @if (Setting('ot_tertiary_rgb'))
                --ot-tertiary-rgb: {{ Setting('ot_tertiary_rgb') }} !important;
            @endif
            @if (Setting('ot_primary_btn'))
                --ot-primary-btn: {{ Setting('ot_primary_btn') }} !important;
            @endif
        }
    </style>


    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '9998253530207568');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=9998253530207568&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Meta Pixel Code -->


    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PGLJB2JH');</script>
    <!-- End Google Tag Manager -->

</head>
