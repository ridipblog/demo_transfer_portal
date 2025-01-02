<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

// ----------------- admin index routes ---------------
Route::post('/admin-login-api', [AdminController::class, 'indexAPI']);
Route::group(['middleware' => ['user_protect:roles,view,Superadmin']], function () {
    // ----------- revert user by admin ---------------
    Route::post('/revert-user-post',[AdminController::class,'revertUserPost']);
});
