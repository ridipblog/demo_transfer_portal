<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

// ----------------- admin index routes ---------------
Route::post('/admin-login-api', [AdminController::class, 'indexAPI']);
