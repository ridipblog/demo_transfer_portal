<?php

use App\Http\Controllers\employees_access\verification\VerificationController;
use App\Http\Controllers\public\PublicController;
use Illuminate\Support\Facades\Route;

// ---------------- user registration API ----------------
Route::post('/user-registration', [PublicController::class, 'registrationAPI'])->name('user.registration');
// ---------------- registration OTP verify API -------------------
Route::post('/registration-otp-api', [PublicController::class, 'registrationOTPAPI']);
// ------------------ user login  API -----------------
Route::post('/user-login-api', [PublicController::class, 'userLoginAPI'])->name('userLoginAPI');

// verification login


// ----------------- forgot password API -------------------
Route::post('/forgot-password-api',[PublicController::class,'forgotPasswordAPI'])->name('forgot-password-api');
// ----------------- set new password -------------------
Route::post('/verify-set-password',[PublicController::class,'verifyBySetPassword'])->name('verifySetPassword');
// --------------------- get offices and posts name by depertment --------------

// --------------------- re-send forgot password OTP -------------
Route::post('/resend-forgot-otp',[PublicController::class,'resendForgotPassOTP']);


