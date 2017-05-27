<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('pageTitle')</title>
        <!--Common Stylesheets-->
        <link rel = "shortcut icon" type = "image/png" href = "{{ asset('favicon.png') }}">
        <link rel = "stylesheet" href = "{{ asset('css/bootstrap.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/font-awesome.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/custom.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/main-navbar.css')}}">
        <!--Common Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:700i" rel="stylesheet">
        <!--Specific Stylesheets-->
        @stack('styles')


    </head>
    <body>
        @include('partials.main-navbar')
        @yield('content')
    </body>
    <!--JavaScript-->
    <!--Common Scripts-->
    <script src = "{{ asset('js/jquery.js') }}"></script>
    <script src = "{{ asset('js/bootstrap.js') }}"></script>
    <script src = "{{ asset('js/moment.min.js') }}"></script>
    @stack('scripts')
</html>