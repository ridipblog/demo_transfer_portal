<?php

use App\Http\Controllers\employees_access\UserDashboardController;
use App\Http\Controllers\employees_access\verification\candidate\CandidateController;
use App\Http\Controllers\employees_access\verification\VerificationController;
use App\Http\Controllers\user_verifications\EmployeeVerificationController;
use Illuminate\Support\Facades\Route;
use Mockery\VerificationDirector;

//  ---------------- employees dashboard -----------------
// Route::get('/verifier-dashboard', [VerificationController::class, 'verifier_index'])->name('verifier.dashboard');


Route::get('/pending-noc', [CandidateController::class, 'noc_pending_index'])->name('verifier.noc.pending');

// ------------------ employee search profile for request  ------------------
Route::get('/verifier-search-profile', [UserDashboardController::class, 'searchUserProfile'])->name('verifier.search.profile');


// Route::get('/candidate-verify/{type}', [VerificationController::class, 'candidate_verify_index']);

Route::get('/logout', [VerificationController::class, 'logout']);

Route::post('/fetch-candidates', [CandidateController::class, 'fetch_candidates']);


Route::post('/fetch-noc-pending-candidates', [CandidateController::class, 'fetch_noc_pending_candidates']);

Route::post('/verify-candidates', [CandidateController::class, 'verify_candidates']);

Route::post('/reject-candidates', [CandidateController::class, 'reject_candidates'])->name('candidate.reject');

Route::post('/noc-print', [CandidateController::class, 'noc_print'])->name('candidate.noc_print');

// status
Route::post('/noc-update', [CandidateController::class, 'noc_update'])->name('candidate.noc_update');

// Route::get('/candidate-profile/{id?}/{type}', [CandidateController::class, 'candidate_profile_index'])->name('candidate.profile');

// Route::get('/approval-dashboard', [VerificationController::class, 'approver_index'])->name('verification.approver.dashboard');

// Route::get('/change-role', [VerificationController::class, 'role_change_index'])->name('change.role');

// approver
// Route::get('/approval-dashboard', [VerificationController::class, 'approver_index'])->name('verification.approver.dashboard');

// Route::get('/approval-dashboard', [VerificationController::class, 'approver_index'])->name('verification.approver.dashboard');



// Route::get('/approval-all-requests', [VerificationController::class, 'approval_all'])->name('verification.approval-all');

// Route::get('/jts-pdf', [VerificationController::class, 'approval_all'])->name('verification.jts');

// Route::post('/fetch-candidates/approval', [CandidateController::class, 'fetch_candidates_approval']);

Route::post('/fetch-office', [VerificationController::class, 'fetch_office_json']);


// ------------------- verifier verification with documents & remarks API --------------
// Route::post('/verifier-user-verification',[EmployeeVerificationController::class,'checkByVerifer']);

// Route::get('/jto-certificate/{id}', [CandidateController::class, 'jto_certificate']);

Route::get('/approval-dashboard/new', [VerificationController::class, 'new_dashboard_approval']);

// Route::get('/approval-all-requests', [VerificationController::class, 'approval_all'])->name('verification.approval-all');

// Route::get('/approval-profile/{id}', [VerificationController::class, 'approver_profile_details'])->name('verification.approver.profile');