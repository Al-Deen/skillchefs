<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ setting('author') }}">
    <title>@yield('title') | {{ setting('application_name') }} </title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/bootstrap.min.css" />
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/style.css" />
    <!-- Custom CSS  end -->
</head>

<body>
    <!-- main content start -->
    @yield('main')
    <!-- main content end -->
</body>

</html>
