<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    {{-- ---------------- start default css link --------------- --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/public/custom.css') }}">
    {{-- ---------------- end default css link --------------- --}}
    {{-- ----------------- start extra css links ------------------- --}}
    @yield('extra_css_links')
    {{-- ------------------- end extra css links ----------------- --}}
</head>

<body class="min-h-screen flex flex-col">
    {{-- <form action="{{ route('chanage.lang') }}" method="POST">
        @csrf
        <select name="lang" onchange="this.form.submit()">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
            <option value="as" {{ app()->getLocale() == 'as' ? 'selected' : '' }}>Assamese</option>
            <!-- Add more languages as needed -->
        </select>
    </form> --}}
    {{-- --------------- document loader -------------- --}}
    {{-- <x-document-loader-component>

    </x-document-loader-component> --}}
    {{-- ---------------- start header here --------------- --}}

    <x-reuse_components.employees.pendding-header-component></x-reuse_components.employees.pendding-header-component>

    {{-- -------------------- end header here ---------------- --}}
    {{-- ---------------------- start dynamic content ------------------- --}}

    @yield('content')
    {{-- ---------------------- end dynamic content ------------------- --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            window.addEventListener('load', function() {
                // Hide the loader after the window is fully loaded
                $('.document-loader').addClass('hidden');
                $('body').removeClass('overflow-hidden')
            });
            window.App = {
                locale: @json(app()->getLocale())
            };
        })
    </script>
    {{-- <script src="{{asset('js/loader.js')}}"></script> --}}
    {{-- ---------------------- start extra js links ------------------------- --}}
    @yield('extra_js_links')
    {{-- ------------------ end extra js links -------------------- --}}
</body>

</html>
