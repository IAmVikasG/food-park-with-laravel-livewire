<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Login' }}</title>
        <link rel="stylesheet" href="{{ asset('admin_assets') }}/modules/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('admin_assets') }}/modules/fontawesome/css/all.min.css">

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('admin_assets') }}/css/style.css">
        @livewireStyles
    </head>
    <body>
        {{ $slot }}

        <script src="{{ asset('admin_assets') }}/modules/jquery.min.js"></script>
        <script src="{{ asset('admin_assets') }}/modules/bootstrap/js/bootstrap.min.js"></script>
        @livewireScripts
    </body>
</html>
