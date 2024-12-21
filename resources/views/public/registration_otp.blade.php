{{-- ------------ implement app layout------------------ --}}
@extends('layouts.app')

@section('title', 'Registration-OTP')
{{-- -------------- start dynamic content ---------------- --}}
@section('content')
    @if (session('phone'))
        <div class="flex-grow grid grid-cols-2">
            <div class="h-full w-full bg-[url('/images/hero_bg2.png')] bg-contain rounded-3xl bg-center bg-no-repeat">
                <!-- <img src="../assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
            </div>
            <div class="max-w-sm mx-auto w-full flex flex-col justify-center set-password-div" id="verifyCodeCon">
                <h1 class="text-5xl">@lang('login_register.otp.heading')</h1>
                <p class="mt-4 text-lg text-gray-900 font-medium">@lang('login_register.otp.sent_to') <span class="font-bold">+91
                        {{ substr_replace(session('phone'), '****', 3, 4) }}</span></p>
                <form id="registration-otp" class="mt-12">
                    <div class="grid gap-2">
                        <div>
                            <div class="mx-auto">
                                <!-- <label class="block mb-1 text-xs md:text-sm font-semibold reqd">Enter OTP</label> -->
                                <input type="number" id="idNum" name="registration_otp"
                                    class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-2.5 w-full text-center registration-OTP-input"
                                    placeholder="XXXXXX"
                                    oninput="if (this.value.length > 6) { this.value = this.value.slice(0, 6); }">
                                <span class="text-red-500 registration-OTP-error"></span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <button type="submit"
                                class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block w-fit ml-auto px-3 py-1.5 registration-OTP-btn">@lang('login_register.otp.button')</button>
                            <p class="py-4 text-gray-500 text-xs mx-auto mt-4">
                                @lang('login_register.otp.no_code') <button type="button" class="text-sky-600 hover:underline"
                                    id="resend-registration-otp">@lang('login_register.otp.resend')</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="flex-grow flex flex-col items-center justify-center">
            <div class="">
                <div class="bg-yellow-100 p-6 text-yellow-600 mb-12 rounded-3xl text-center max-w-lg">
                    <div class="grid gap-4">
                        <i class="bi bi-exclamation-triangle"></i>
                        <div>
                            <p class="text-xl font-semibold mb-1">@lang('login_register.otp.messages.title')</p>
                            <p>@lang('login_register.otp.messages.text')</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/register" class="text-gray-500 font-medium hover:underline"><i class="bi bi-arrow-left"></i> Back to
                register</a>
        </div>
    @endif
@endsection

{{-- -------------- end dynamic content ---------------- --}}
{{-- ----------- start extra js links ----------------- --}}
@section('extra_js')
    <script type="module" src="{{ asset('js/public/registration.js') }}"></script>

@endsection
{{-- ----------- end extra js links ----------------- --}}
