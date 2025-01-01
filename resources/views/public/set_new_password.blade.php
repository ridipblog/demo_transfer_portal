@extends('layouts.app')
@section('title', 'Set new password')
{{-- -------------- start page content ----------------- --}}
@section('content')
    <div class="flex-grow grid md:grid-cols-2">
        <div class="h-full w-full bg-[url('/images/hero_bg2.png')] bg-contain rounded-3xl bg-center bg-no-repeat hidden md:block">
            <!-- <img src="../assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
        </div>
        <div class="max-w-sm mx-auto w-full flex flex-col justify-center set-password-div px-4" id="verifyCodeCon">
            <h1 class="text-5xl">OTP Code Verification</h1>
            <p class="mt-4 text-lg text-gray-900 font-medium">We have sent an OTP code to <span class="font-bold">+91
                    {{ substr(session('phone'), 0, 3) . '*****' . substr(session('phone'), -2) }} </span></p>
            <form id="verify-otp-form" class="mt-12">
                <div class="grid gap-6">
                    <div>
                        <div class="mx-auto">
                            <!-- <label class="block mb-1 text-xs md:text-sm font-semibold reqd">Enter OTP</label> -->
                            <input type="number" id="idNum" name="otp"
                                class="change-password-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 text-center focus:border-sky-600 block p-2.5 w-full"
                                required placeholder="XXXXXX"
                                oninput="if (this.value.length > 6) { this.value = this.value.slice(0, 6); }">
                        </div>
                        <span class="change-password-error text-red-500"></span>
                    </div>
                </div>
                <div class="flex justify-end gap-1 mt-8">
                    <button
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5"
                        id="verifyCodeBtn">Verify & Proceed</a>
                </div>
            </form>
            <div class="mt-4">
                <p class="py-4 text-gray-900 text-xs">
                    {{-- Didn't receive code? <a href="{{ route('forgot.password') }}"
                        class="text-sky-600 hover:underline">Resend Now</a> --}}
                    Didn't receive code? <button type="button" class="text-sky-600 hover:underline"
                        id="resend-forgot-password-otp">Resend Now</button>
                </p>
            </div>
        </div>
        <div class="max-w-sm mx-auto w-full flex flex-col justify-center hidden set-password-div" id="setPassCon">
            <h1 class="text-5xl">Set new password</h1>
            <p class="mt-4 text-lg text-gray-900 font-medium">Must be at least 6 characters and must contain one special
                character.</p>
            <form id="set-password-form" class="mt-12">
                <div class="grid gap-6">
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">New Password</label>
                        <input type="Password" name="password"
                            class="user-login-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                            required>
                        <span class="user-login-error text-red-500"></span>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">Confirm
                            Password</label>
                        <input type="Password" name="confirm_password"
                            class="user-login-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                            required>
                        <span class="user-login-error text-red-500"></span>
                    </div>
                </div>
                <div class="flex justify-end gap-1 mt-8">
                    <button type="submit" id="set-password-btn"
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5">Set
                        password</button>
                </div>
            </form>
            <div class="mt-4">
                <p class="py-4 text-gray-900 text-xs">
                    <a href="{{ route('forgot.password') }}" class="text-sky-600 hover:underline">Create a new request</a>
                </p>
            </div>
        </div>
    </div>
@endsection
{{-- ------------------ end page content ------------- --}}

@section('extra_js')
    <script type="module" src="{{ asset('js/public/forgot_password.js') }}"></script>
@endsection
