<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['public_protect:view']], function () {
    // ----------------- admin index routes ---------------
    Route::get('/login', [AdminController::class, 'index']);
});

Route::group(['middleware' => ['user_protect:roles,view,Superadmin']], function () {
    // ---------------- admin dashboard routes ---------------
    Route::get('/admin-dashboard', [AdminController::class, 'adminDashboard']);
});
