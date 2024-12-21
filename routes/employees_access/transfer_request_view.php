<?php

use App\Http\Controllers\employees_access\TransferRequestController;
use Illuminate\Support\Facades\Route;
Route::get('/download-join-transfer/{transfer_id?}',[TransferRequestController::class,'downloadJoinTransformLetter']);
