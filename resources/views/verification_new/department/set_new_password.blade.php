@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <div class="flex-grow grid grid-cols-2">
        <div class="h-full w-full bg-[url('/images/hero_bg2.png')] bg-contain rounded-3xl bg-center bg-no-repeat">
            <!-- <img src="../assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
        </div>
        <div class="max-w-sm mx-auto w-full flex flex-col justify-center set-password-div" id="verifyCodeCon">
            <h1 class="text-5xl">PIN Code Verification</h1>
            {{-- <p class="mt-4 text-lg text-gray-900 font-medium">We have sent an OTP code to <span class="font-bold">+91
                {{ $phone }}</span></p> --}}
            <p class="mt-4 text-lg text-gray-900 font-medium">We have generated a PIN for <span class="font-bold">
                    {{ $name }}</span></p>
            <form id="verify-otp-form" class="mt-12">
                <div class="grid gap-6">
                    <div>
                        <div class="mx-auto">
                            <!-- <label class="block mb-1 text-xs md:text-sm font-semibold reqd">Enter OTP</label> -->
                            <input type="number" id="idNum" name="otp"
                                class="change-password-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full text-center"
                                required placeholder="XXXXXX"
                                oninput="if (this.value.length > 6) { this.value = this.value.slice(0, 6); }">
                        </div>
                        <span class="change-password-error text-red-500"></span>
                    </div>
                </div>
                <div class="flex justify-end gap-1 mt-8">
                    <button type="button"
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5"
                        id="verifyOtpBtn">Verify & Proceed</button>
                </div>
            </form>
            {{-- <div class="mt-4">
                <p class="py-4 text-gray-900 text-xs">
                    Didn't receive code? <a href="{{ route('verifier.forgotPassword') }}"
                        class="text-sky-600 hover:underline">Resend Now</a>
                </p>
            </div> --}}
        </div>
        <div class="max-w-sm mx-auto w-full flex flex-col justify-center hidden set-password-div" id="setPassCon">
            <h1 class="text-5xl">Set new password</h1>
            <p class="mt-4 text-lg text-gray-900 font-medium">Must be at least 6 characters and must contain one special
                character.</p>
            <div id="set-password-form" class="mt-12">
                <div class="grid gap-6">
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">New Password</label>
                        <input type="Password" name="password" id="password" value=""
                            class="user-login-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                            required>
                        <span class="user-login-error text-red-500"></span>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">Confirm
                            Password</label>
                        <input type="Password" name="confirm_password" id="confirm_password" value=""
                            class="user-login-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                            required>
                        <span class="user-login-error2 text-red-500"></span>
                    </div>
                </div>
                <div class="flex justify-end gap-1 mt-8">
                    <button type="button" id="set-password-btn"
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5">Set
                        password</button>
                </div>
            </div>
            {{-- <div class="mt-4">
                <p class="py-4 text-gray-900 text-xs">
                    <a href="{{ route('verifier.forgotPassword') }}" class="text-sky-600 hover:underline">Create a new request</a>
                </p>
            </div> --}}
        </div>
    </div>
@endsection
{{-- ------------------ end page content ------------- --}}

@section('extra_js')
    <script>
        $(document).ready(function() {
            $('#verifyOtpBtn').on('click', function() {
                $otp = $('#idNum').val();
                $.ajax({
                    type: "post",
                    url: "{{ url('/verification-otp-verify') }}",
                    data: {
                        'otp': $otp
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response.res_data)
                        if (response.res_data.status != 200) {
                            $('.change-password-error').text(response.res_data.message);
                        } else {
                            $('.change-password-error').text('');
                            $('#verifyCodeCon').addClass('hidden');
                            $('#setPassCon').removeClass('hidden');
                        }
                    }
                });
            });

            $('#set-password-btn').on('click', function() {
                var password = $('#password').val();
                var otp = $('#idNum').val();
                var confirm_password = $('#confirm_password').val();
                $.ajax({
                    type: "post",
                    url: "{{ url('/verification-newPassword') }}",
                    data: {
                        'password': password,
                        'confirm_password': confirm_password,
                        'otp': otp
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response.res_data)
                        if (response.res_data.status != 200) {
                            $('.user-login-error2').text(response.res_data.message);
                        } else {
                            $('.user-login-error2').text('');
                            alert('password reset successfully')
                            window.location.href = '/department/department-dashboard';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON);
                        console.log(status);
                        console.log(error);
                        if (xhr.status == 410) {
                            $('.change-password-error').text(xhr.responseJSON.message);
                        } else {
                            $('.change-password-error').text(
                                "An error occurred. Please try again.");
                        }
                    }
                });
            });
        });
    </script>
@endsection
