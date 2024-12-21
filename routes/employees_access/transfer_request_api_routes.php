<?php

use App\Http\Controllers\employees_access\TransferRequestController;
use App\Http\Controllers\employees_access\UserDashboardController;
use Illuminate\Support\Facades\Route;
// ----------------- request profile transfer -----------------
Route::post('/request-transfer-profile',[UserDashboardController::class,'requestTransferProfile']);
// ---------------- transfer request cancel by user --------------------
Route::post('/request-cancel-api',[TransferRequestController::class,'requestCancel']);
// ---------------- transfer request action by target employee --------------------
Route::post('/action-on-request-api',[TransferRequestController::class,'actionOnrequest']);
// ---------------- search profiles for request ----------------
Route::post('/search-profile-api',[TransferRequestController::class,'searchProfileAPI']);
// ----------------- fetch offices name by district and depertment -------------

Route::get('/get-offices-name',[TransferRequestController::class,'getOfficeByDistrict']);
