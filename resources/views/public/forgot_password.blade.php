@extends('layouts.app')
@section('title', 'Forgot password')
{{-- ------------------ start page content ----------------- --}}

@section('content')
    <div class="flex-grow grid grid-cols-2">
        <div
            class="h-full w-full bg-[url({{ asset('images/hero_bg2.png') }})] bg-contain rounded-3xl bg-center bg-no-repeat">
            <!-- <img src="../assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
        </div>
        <div class="max-w-sm mx-auto w-full flex flex-col justify-center">
            <h1 class="text-5xl">Forgot Password</h1>
            <p class="mt-4 text-lg text-gray-900 font-medium">No worries. Reset your password in 2 easy steps</p>
            <form id="forgot-password-form" class="mt-12">
                <div class="grid gap-6">
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">Phone</label>
                        <input type="tel" name="phone"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full user-login-input"
                            pattern="^[6-9][0-9]{9}$" required
                            oninput="this.setCustomValidity(''); if (!this.validity.valid) { this.setCustomValidity('Please enter a valid 10-digit phone number'); }"
                            oninvalid="this.setCustomValidity('Please enter a valid 10-digit phone number');"
                            maxlength="10">
                        <span class="user-login-error text-red-500"></span>
                    </div>
                </div>
                <div class="flex justify-end gap-1 mt-8">
                    <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-3 py-1.5"
                        id="forgot-password-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
{{-- ---------------- end page content -------------------- --}}
@section('extra_js')
    <script type="module" src="{{ asset('js/public/forgot_password.js') }}"></script>
@endsection
