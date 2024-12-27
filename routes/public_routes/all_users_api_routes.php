<?php

use App\Http\Controllers\public\PublicController;
use Illuminate\Support\Facades\Route;
// ----------------- get offices and posts name -----------------
Route::get('/get-offices-posts',[PublicController::class,'getOfficePost']);
// ----------------- get pay grade value --------------
Route::get('/get-pay-grade',[PublicController::class,'getPayGrade']);
// ------------- get office by district --------------
Route::get('/get-offices-by-district',[PublicController::class,'getOfficeByDistrict']);
// -------- fetch offices by district and depertment --------------
Route::get('/fetch-off-dist-dept',[PublicController::class,'fetchOfficeDistDept']);
