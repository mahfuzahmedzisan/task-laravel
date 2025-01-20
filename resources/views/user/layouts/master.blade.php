<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title'){{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <link
        rel="icon"
        href="{{asset('admin/assets/img/kaiadmin/favicon.ico')}}"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{asset('admin/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{asset('admin/assets/css/fonts.min.css')}}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('user.partials.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">

            @include('user.partials.header')

            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>

            @include('user.partials.footer')
        </div>
    </div>

<!--   Core JS Files   -->
<script src="{{ asset('backend/admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<!-- Kaiadmin JS -->
<script src="{{ asset('backend/admin/assets/js/kaiadmin.min.js') }}"></script>
@stack('js_links')
<script src="{{ asset('backend/admin/js/custom.js') }}"></script>
@stack('js')
</body>

</html>
