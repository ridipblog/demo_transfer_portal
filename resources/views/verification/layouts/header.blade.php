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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/public/custom.css') }}">
    {{-- ---------------- end default css link --------------- --}}

    {{-- ------------ start write your extra css code --------------- --}}
    @yield('extra_css')
    {{-- ------------ end write your extra css code --------------- --}}
</head>

<body class="px-4 min-h-screen flex flex-col">

    {{-- --------- start header here --------- --}}
    {{-- <x-reuse_components.header-component></x-reuse_components.header-component> --}}
    {{-- --------- end header here --------- --}}
    {{-- ------------ start  your main content code --------------- --}}
    <div class="hidden fixed inset-0 flex items-center justify-center bg-black/30 popup" style="z-index: 9999;">
        <!-- success -->
        <div class="popup-success max-w-xs w-full bg-white rounded-2xl p-6 py-10 hidden">
            <div class="flex flex-col items-center justify-center gap-6">
                <i class="bi bi-check-circle text-green-600 text-7xl"></i>
                <div class="space-y-2 mb-6">
                    <p class="text-3xl text-center font-semibold">Success!</p>
                    <p class="text-gray-900 text-center text-xs"></p>
                </div>
            </div>
        </div>
        <!-- error -->
        <div class="popup-error max-w-xs w-full bg-white rounded-2xl p-6 py-10 hidden">
            <div class="flex flex-col items-center justify-center gap-6">
                <i class="bi bi-x-circle text-red-600 text-7xl"></i>
                <div class="space-y-2 mb-6">
                    <p class="text-3xl text-center font-semibold">Failed!</p>
                    <p class="text-gray-900 text-center text-xs error-msg"></p>
                </div>
                {{-- <a href="#" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Try again</a> --}}
            </div>
        </div>
    </div>



    <nav class="bg-white sticky top-0 z-50">
        <div class="bg-sky-600">
            <div class="max-w-full mx-auto flex justify-between items-center lg:px-4 py-1 text-xs text-white">
                <div class="flex gap-4">
                    <div class="flex gap-1"><i class="bi bi-telephone"> </i>+91 882 676 2317</div>
                    <div class="flex gap-1"><i class="bi bi-at"> </i>helpdesk.swagatasatirtha@gmail.com</div>
                </div>
                <div class="">
                    <form action="{{ route('chanage.lang') }}" method="POST" class="m-0">
                        @csrf
                        <div class="flex gap-1 lg:gap-2">
                            <button type="submit" name="lang" value="en"
                                class=" border-b {{ app()->getLocale() == 'en' ? '' : 'border-transparent' }}">English</button>
                            <button type="submit" name="lang" value="as"
                                class=" border-b {{ app()->getLocale() == 'as' ? '' : 'border-transparent' }}">অসমীয়া</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="max-w-full mx-auto flex justify-between items-center py-3">
            <div class="font-black flex gap-2 items-center">
                <img src="{{ asset('images/logo.svg') }}" alt="" class="h-8 md:h-12">
                <p class="leading-4 text-2xl text-sky-600 mt-1">SWAGATA SATIRTHA <br><small
                        class="text-xs font-medium text-black">GOVT. OF ASSAM</small></p>
            </div>
            {{-- @if (!request()->routeIs('depertmentLogin')) --}}
            {{-- <div class="flex items-center gap-4 text-gray-900 text-xs md:text-base">
                    <a href="{{ route('home') }}" class="border-b-2 border-sky-600 text-sky-600 pb-2">Home</a>
                    <a href="{{ route('about') }}"
                        class="border-transparent border-b-2 transition-all duration-150 hover:text-sky-600 hover:border-sky-600 pb-2">About</a>
                    <a href="{{ route('faq') }}"
                        class="border-transparent border-b-2 transition-all duration-150 hover:text-sky-600 hover:border-sky-600 pb-2">FAQ</a>
                </div> --}}
            @php
                $locale1 = app()->getLocale();
            @endphp
            @if (Session::has('verifier_name'))
                <div class="flex items-center gap-4 text-gray-900">
                    <div class="flex items-center justify-end gap-2 group/menu-drop relative">
                        <div class="text-sm text-right">
                            <p class="font-bold">{{ Session::get('verifier_name') }}</p>
                            <p class="text-gray-600 text-xs">
                                @if (Session::get('is_dept') == 1)
                                    {{-- {{dd('here')}} --}}
                                    {{ Session::get('role') }}
                                @else
                                    {{ Session::has('display_role_name') ? Session::get('display_role_name') : 'N/A' }}
                                @endif
                            </p>
                        </div>
                        <div class=""><i class="bi bi-caret-down-fill"></i></div>
                        <div
                            class="hidden group-hover/menu-drop:block bg-white shadow-md rounded-lg absolute right-0 top-full z-50 ">
                            <div class="grid divide-z">
                                <div class="p-4">
                                    <div class="text-sm">
                                        <p class="font-bold">
                                            {{ Auth::guard('user_guard')->user()->roles->display_name }}</p>
                                        <p class="text-gray-600 text-xs">
                                            @if (Auth::guard('user_guard')->user()->appointing_authorities->designation != null)
                                                {{ Auth::guard('user_guard')->user()->appointing_authorities->designation }}
                                                | {{ Session::has('office') ? Session::get('office') : 'N/A' }}
                                            @endif
                                        </p>
                                        <p class="text-gray-600 text-xs">
                                            @if (Session::get('is_dept') == 1)
                                                {{ Session::get('role') }}
                                            @else
                                                {{ Session::has('display_role_name') ? Session::get('display_role_name') : 'N/A' }}
                                            @endif
                                        </p>
                                        <p class="text-gray-600 text-xs whitespace-nowrap">
                                            {{ !Session::get('district_name') ? 'All District' : Session::get('district_name') }}
                                            | {{ Session::get('department_name') }}</p>
                                    </div>
                                </div>
                                {{-- ----------------------------------------------------------------------------------------- --}}
                                {{-- {{ dd(Session::get('switch_condition')) }} --}}
                                @if (Session::has('switch_condition') && Session::get('switch_condition') == 1)
                                    @php
                                        $flag = false;
                                    @endphp
                                    {{-- @foreach (Session::get('all_roles') as $roles)
                                        @if (count(Session::get('all_roles')) > 2)
                                            @if ($roles->id == 7)
                                                <a href="/switch-role/{{ Crypt::encryptString($roles->id) }}"
                                                    class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-sky-700 font-medium text-xs">
                                                    <span>{{ $roles->display_name }}</span>
                                                </a>
                                            @else
                                                @if ($flag != true)
                                                    <a href="/switch-role/{{ Crypt::encryptString($roles->id) }}"
                                                        class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-sky-700 font-medium text-xs">
                                                        <span>Other Login</span>
                                                    </a>
                                                    @php
                                                        $flag = true;
                                                    @endphp
                                                @endif
                                            @endif
                                        @else
                                            <a href="/switch-role/{{ Crypt::encryptString($roles->id) }}"
                                                class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-sky-700 font-medium text-xs">
                                                <span>{{ $roles->display_name }}</span>
                                            </a>
                                        @endif
                                    @endforeach --}}
                                    @foreach (Session::get('all_roles') as $roles)
                                    
                                        @php
                                            $role_name = $roles->display_name;
                                            if ($roles->id == 7) {
                                                $role_name = 'Approval HOD';
                                            } elseif ($roles->id == 3) {
                                                $role_name = 'Recommendation HOD';
                                            }
                                        @endphp
                                        @if (count(Session::get('all_roles')) > 2)
                                            @if ($roles->id == 7)
                                                <a href="/switch-role/{{ Crypt::encryptString($roles->id) }}"
                                                    class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-sky-700 font-medium text-xs">
                                                    <span>{{ $role_name }}</span>
                                                </a>
                                            @else
                                                @if ($flag != true)
                                                    <a href="/switch-role/{{ Crypt::encryptString($roles->id) }}"
                                                        class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-sky-700 font-medium text-xs">
                                                        <span>Other Login</span>
                                                    </a>
                                                    @php
                                                        $flag = true;
                                                    @endphp
                                                @endif
                                            @endif
                                        @else
                                            <a href="/switch-role/{{ Crypt::encryptString($roles->id) }}"
                                                class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-sky-700 font-medium text-xs">
                                                <span>{{ $role_name }}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                                {{-- --------------------------------------------------------------------------------------------------- --}}
                                {{-- @if (Auth::guard('user_guard')->user()->roles->id == 2)
                                    <a href="{{ url('verifier/approver/logout') }}"
                                        class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-red-500">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Logout</span>
                                    </a>
                                @else --}}
                                <a href="{{ url('verifier/logout') }}"
                                    class="px-4 py-2 flex gap-1 items-center hover:bg-neutral-100 text-red-500">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>@lang('authority_dashboard.logout')</span>
                                </a>
                                {{-- @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- @endif --}}
        </div>
    </nav>




    @yield('content')
    @extends('verification.layouts.footer')
    {{-- ------------ end  your main content code --------------- --}}

    {{-- --------------- start footer header ----------------- --}}
    {{-- <x-reuse_components.footer-component></x-reuse_components.footer-component> --}}
    {{-- --------------- start footer header ----------------- --}}
    {{-- ------------- start default js links -------------- --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
    </script>
    {{-- ------------- end default js links -------------- --}}

    {{-- ------------ start  your extra js code --------------- --}}
    @yield('extra_js')
    {{-- ------------ end your extra js code --------------- --}}
</body>

</html>
