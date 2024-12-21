{{-- ---------- extends app layout -------------------- --}}
@extends('layouts.app')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Admin Login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <div class="flex-grow grid lg:grid-cols-2 px-4">
        <div
            class="h-full bg-sky-600 w-full bg-[url({{ asset('/images/hero_bg2.jpg') }})] bg-cover rounded-3xl bg-center bg-no-repeat hidden lg:block">
            <!-- <img src="../assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
        </div>
        <div class="max-w-sm mx-auto w-full flex flex-col justify-center">
            <h1 class="text-5xl">Admin @lang('login_register.login_page.heading')</h1>
            <p class="mt-4 text-lg text-gray-900 font-medium">@lang('login_register.login_page.sub_text')</p>
            <form id="admin-login-form" class="mt-12">
                <div class="grid gap-2">
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('login_register.login_page.input.phone')</label>
                        <input type="text" name="phone"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full user-login-input"
                            >
                        <span class="user-login-error text-red-500"></span>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('login_register.login_page.input.pass')</label>
                        <input type="Password" name="password"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full user-login-input"
                            >
                        <span class="user-login-error text-red-500"></span>
                    </div>
                    <div class="flex justify-end gap-1 mt-8 mb-4">
                        <button type="submit"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-3 py-1.5 admin-login-btn">@lang('login_register.login_page.button')
                            <i class="bi bi-arrow-right"></i></button>
                    </div>
                    {{-- <p class="text-center text-xs">Don't have an account? <a href="/register" class="text-sky-500 hover:underline">Register now</a></p> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
{{-- --------------------- dynamic js link ------------------ --}}
@section('extra_js')
    <script type="module" src="{{ asset('js/admin/login.js') }}"></script>

@endsection
