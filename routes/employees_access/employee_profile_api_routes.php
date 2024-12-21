<?php

use App\Http\Controllers\employees_access\UserProfileController;
use Illuminate\Support\Facades\Route;
// ---------------- save employee profile -----------------
Route::post('/save-profile-api',[UserProfileController::class,'saveProfileAPI']);
// ---------------- final submit employee profile -----------------
Route::post('/preview-submit-profile-api',[UserProfileController::class,'previewSubmitProfileAPI']);
// ---------------- update employee profile data API -------------
// ------------------------ final submit and all save after preview -----------------------
Route::post('/submit-profile-api',[UserProfileController::class,'submitProfileAPI']);

// ----------------------- update profile details ----------------
Route::post('/update-profile-api',[UserProfileController::class,'updateProfileAPI']);
// -------------- get ddo code by office ----------------
Route::get('/get-ddo-code-api',[UserProfileController::class,'getDddoCodeApi']);
// Route::post('/update-profile-api',[UserProfileController::class,'updateProfileDataAPI'])->name('update.profile.data.api');
// Route::post('/update-employee-profile-api',[UserProfileController::class,'updateEmployeeProfileAPI']);
