<?php

use App\Http\Controllers\root_access\AuthoritiesController;
use App\Http\Controllers\root_access\RootProcessController;
use App\Http\Controllers\root_access\StateUserRegistration;
use Illuminate\Support\Facades\Route;
// ---------------- get offices by dist -------------
Route::get('/get-offices-by-dist',[AuthoritiesController::class,'getOfficesByDist']);
// ---------------- render a assign form---------------
Route::get('/add-assign-form',[AuthoritiesController::class,'addNewForm']);
// -------------- authority registration post --------------
Route::post('/authority-registration-api',[AuthoritiesController::class,'authorityRegistrationAPI']);
// ------------------ get districts by offices ----------------
Route::get('/get-districts-by-offices',[AuthoritiesController::class,'getDistrictByOffices']);
// ----------------- view assign data --------------
Route::get('/view-assign-data',[AuthoritiesController::class,'viewAssignData']);

// --------------- state user registration page --------------

Route::get('/state-user-registration',[StateUserRegistration::class,'index']);
// --------- register state user ---------------
Route::post('/register-state-user',[StateUserRegistration::class,'registerStateUser']);

// ---------------- send a text message to all authotities ----------------------
Route::get('/send-message-to-authrities',[RootProcessController::class,'sendMesssageToAuthrities']);
