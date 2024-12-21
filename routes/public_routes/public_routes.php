<?php

use App\Http\Controllers\employees_access\verification\VerificationController;
use App\Http\Controllers\public\PublicController;
use Illuminate\Support\Facades\Route;

// ---------- home view route ----------
Route::get('/',[PublicController::class,'home'])->name('home');
// ------------- about view route -------------
Route::get('/about',[PublicController::class,'about'])->name('about');
// ------------- FAQ  view route ---------------
Route::get('/faq',[PublicController::class,'faq'])->name('faq');
// ------------ register view route ----------------
Route::get('/register',[PublicController::class,'register'])->name('register');
// ------------------ registration OTP view route ----------------
Route::get('/registration-OTP',[PublicController::class,'registrationOTP']);
// --------------------- user login view route ------------
Route::get('/user-login',[PublicController::class,'userLogin'])->name('userLogin');
// ------------------ other login view route ---------------
Route::get('/depertment-login',[PublicController::class,'depertmentLogin'])->name('depertmentLogin');


// ------------------ forgot password view -----------------
Route::get('/forgot-password',[PublicController::class,'forgotPassword'])->name('forgot.password');
// ---------------- set new password -----------------
Route::get('/set-new-password',[PublicController::class,'setNewPassword'])->name('set.new.password');





// appointing authority routes


