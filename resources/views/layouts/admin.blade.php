<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin | @yield('title', 'Dashboard')</title>

    <!-- General CSS Files -->
    @include('partials.styles')
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
    @livewireStyles
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('partials.navbar')
            @include('partials.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            @include('partials.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    @include('partials.scripts')
    @livewireScripts
</body>

</html>
