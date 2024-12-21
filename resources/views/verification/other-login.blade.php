{{-- ---------- extends app layout -------------------- --}}
@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="flex-grow grid grid-cols-2">
        <div
            class="h-full w-full bg-[url({{ asset('/images/hero_bg2.png') }})] bg-contain rounded-3xl bg-center bg-no-repeat">
            <!-- <img src="../assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
        </div>
        <div class="max-w-sm mx-auto w-full flex flex-col justify-center">
            <h1 class="text-5xl">@lang('home.cards.login.heading')</h1>
            <p class="mt-4 text-lg text-gray-900 font-medium">@lang('home.cards.login.text')</p>
            <form id="verification-login-form" class="mt-12">
                <div class="grid gap-6">
                    <div>
                        <label
                            class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('login_register.login_page.input.phone')</label>
                        <input type="text" name="phone_or_email"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full verification-login-input"
                            required maxlength="10">
                        <span class="verification-login-error text-red-500"></span>
                    </div>
                    <div>
                        <label
                            class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('login_register.login_page.input.pass')</label>
                        <input type="Password" name="password"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full verification-login-input"
                            required>
                        <span class="verification-login-error text-red-500"></span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ url('/verification-forgotPassword') }}"
                        class="text-xs underline hover:text-sky-600">@lang('login_register.login_page.forgot_pass')</a>
                </div>
                <div class="flex justify-end gap-1 mt-8">
                    <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-3 py-1.5 verification-login-btn">@lang('login_register.login_page.button')
                        <i class="bi bi-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- footer -->

    {{-- ---------- extends app layout -------------------- --}}


@endsection
{{-- --------------------- dynamic js link ------------------ --}}

@section('extra_js')
    <script type="module" src="{{ asset('js/verification/login.js') }}"></script>
    <script>
        window.App = {
            locale: "{{ Session::get('locale', 'en') }}"
        };
    </script>

@endsection
