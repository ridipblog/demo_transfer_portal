<?php

use App\Http\Controllers\employees_access\UserDashboardController;
use Illuminate\Support\Facades\Route;
//  ---------------- employees dashboard -----------------
Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('employees.dashboard');
// ------------------ employee search profile for request  ------------------
Route::get('/search-profile/{preference_search_district?}', [UserDashboardController::class, 'searchUserProfile'])->name('search.profile');
// ---------------- download NOC by user -------------
Route::get('/download-noc-by-user', [UserDashboardController::class, 'downloadNOCByUser'])->name('download.noc.user');
// ----------- transfer history index routes ---------------
Route::get('/transfer-history', [UserDashboardController::class, 'transferHistoryIndex'])->name('transfer.history');
