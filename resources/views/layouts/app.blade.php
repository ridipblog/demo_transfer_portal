<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- ---------------- start default css link --------------- --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/public/custom.css') }}">
    {{-- ---------------- end default css link --------------- --}}

    {{-- ------------ start write your extra css code --------------- --}}
    @yield('extra_css')
    {{-- ------------ end write your extra css code --------------- --}}
</head>

<body class="min-h-screen flex flex-col">

    {{-- --------------- document loader -------------- --}}
    {{-- <x-document-loader-component>

    </x-document-loader-component> --}}
    {{-- --------- start header here --------- --}}
    <x-reuse_components.header-component></x-reuse_components.header-component>
    {{-- --------- end header here --------- --}}
    {{-- ------------ start  your main content code --------------- --}}
    @yield('content')
    {{-- ------------ end  your main content code --------------- --}}

    {{-- --------------- start footer header ----------------- --}}
    <x-reuse_components.footer-component></x-reuse_components.footer-component>
    {{-- --------------- start footer header ----------------- --}}
    {{-- ------------- start default js links -------------- --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            window.addEventListener('load', function() {
                // Hide the loader after the window is fully loaded
                $('.document-loader').addClass('hidden');
                $('body').removeClass('overflow-hidden')
            });
        })
        window.App = {
            locale: @json(app()->getLocale())
        };
    </script>
    {{-- ------------- end default js links -------------- --}}

    {{-- ------------ start  your extra js code --------------- --}}
    @yield('extra_js')
    {{-- ------------ end your extra js code --------------- --}}
</body>

</html>
