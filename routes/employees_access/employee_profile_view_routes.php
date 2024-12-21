<?php

use App\Http\Controllers\employees_access\UserProfileController;
use Illuminate\Support\Facades\Route;
// ----------------- complete pending  employee profile details -------------------
Route::get('/update-profile',[UserProfileController::class,'completeProfile'])->name('update.profile');
// Route::get('/update-employee-profile',[UserProfileController::class,'updateEmployeeProfile'])->name('update.employee.profile');
