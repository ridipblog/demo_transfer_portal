<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\employees_access\verification\candidate\CandidateController;
use App\Http\Controllers\employees_access\verification\VerificationController;
use App\Http\Controllers\public\PublicController;
use App\Http\Controllers\registration\UserRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ------------ chanage language ---------------------

Route::post('/chanage-lang', [PublicController::class, 'chanageLang'])->name('chanage.lang');

// Route::get('/', function () {
//     return view('welcome');
// });
//  ---------------- start public routes ------------------
Route::group(['prefix' => '{lang?}', 'middleware' => 'setlocale', 'where' => ['lang' => 'en|as']], function () {
    Route::group(['middleware' => ['public_protect:view']], function () {
        require __DIR__ . '/public_routes/public_routes.php';
    });
});


Route::get('check-duplicates', [UserRegistrationController::class, 'check_duplicates']);


Route::get('previous-hod-assign', [UserRegistrationController::class, 'assign_directorate_prev']);

Route::post('previous-user-fetch', [UserRegistrationController::class, 'fetch_prev_user_data'])->name('fetch-prev-user');

Route::post('fetch-directorates', [UserRegistrationController::class, 'fetch_directorates'])->name('fetch-directorates');
Route::post('re-assign-user', [UserRegistrationController::class, 're_assign']);


Route::get('correct-names', [UserRegistrationController::class, 'correct_office_name']);


Route::group(['prefix' => 'verifier', 'middleware' => ['user_protect:roles,view,Verifier,Appointing Authority,Appointing User,Approver,Department Hod']], function () {
    Route::get('verifier-resubmitted-profile/{id}', [CandidateController::class, 'resubmitted_profile_details'])->name('resubmitted.profile');
});
Route::group(['prefix' => '{lang?}', 'middleware' => 'setlocale', 'where' => ['lang' => 'en|as']], function () {
    Route::group(['middleware' => ['public_protect:view']], function () {
        // Route::get('/verification-login', [VerificationController::class, 'index_login'])->name('verification-login');
        Route::get('/authority-login', [VerificationController::class, 'index_login'])->name('verification-login');
        // Route::get('/department-login', [VerificationController::class, 'verification_login_department_index'])->name('verification.verification_login_department_index');
        Route::get('/verification-department-pin', [VerificationController::class, 'department_pin_index']);
        Route::get('/verification-otp', [VerificationController::class, 'otp_index']);
    });

    Route::group(['prefix' => 'verifier', 'middleware' => ['user_protect:roles,view,Verifier,Appointing Authority,Appointing User,Approver,Department Hod']], function () {
        Route::get('/verifier-dashboard', [VerificationController::class, 'verifier_index'])->name('verifier.dashboard');
        Route::get('/candidate-verify/{type}', [VerificationController::class, 'candidate_verify_index'])->name('verifier.candidate_verify');
        Route::get('/approval-all-requests', [VerificationController::class, 'approval_all'])->name('verification.approval-all');
        Route::get('/candidate-profile/{id?}/{type}/{tab_recommend?}', [CandidateController::class, 'candidate_profile_index'])->name('candidate.profile');
        Route::get('/approval-profile/{id}', [VerificationController::class, 'approver_profile_details'])->name('verification.approver.profile');
        // Route::get('verifier-resubmitted-profile/{id}', [CandidateController::class, 'resubmitted_profile_details'])->name('resubmitted.profile');
    });

    Route::group(['prefix' => 'department', 'middleware' => ['user_protect:roles,view,Approver']], function () {
        Route::get('/department-dashboard', [VerificationController::class, 'department_index'])->name('verification.department.index');
        Route::get('/approval-all-requests', [VerificationController::class, 'department_all_request'])->name('verification.department.all_request');
        Route::get('/approval-profile/{id}', [CandidateController::class, 'department_candidate_profile'])->name('verification.department.candidate_profile');
    });
});

// public routes for authority access

Route::group(['middleware' => ['public_protect:view']], function () {

    Route::post('/verification-login-api', [VerificationController::class, 'verificationLoginAPI'])->name('verifierLoginAPI');
    Route::post('/verification-department-login-api', [VerificationController::class, 'verificationDepartmentLoginAPI'])->name('verificationDepartmentLoginAPI');
    // Route::get('/verification-department-pin', [VerificationController::class, 'department_pin_index']);

    // Route::get('/verification-login', [VerificationController::class, 'index_login'])->name('verification-login');

    Route::get('/verification-forgotPassword', [VerificationController::class, 'forgot_password_index'])->name('verifier.forgotPassword');

    Route::post('/verification-verifyPhone', [VerificationController::class, 'forgot_password_check'])->name('verifier.verifyPhone');

    Route::post('/verification-otp-verify', [VerificationController::class, 'verify_otp'])->name('verifier.verify-otp');

    Route::post('/verification-newPassword', [VerificationController::class, 'new_password'])->name('verifier.newPassword');

    Route::post('/verification-login-api', [VerificationController::class, 'verificationLoginAPI'])->name('verifierLoginAPI');

    // Route::get('/verification-otp', [VerificationController::class, 'otp_index']);

    Route::get('/register-user/main', [UserRegistrationController::class, 'index'])->name('register-user');
    Route::post('/register-user/create', [UserRegistrationController::class, 'create']);
});
Route::get('/jto-certificate/{id}', [CandidateController::class, 'jto_certificate']);
Route::post('/fetch-district', [UserRegistrationController::class, 'fetch_district']);
Route::post('/fetch-office', [UserRegistrationController::class, 'fetch_office']);






// ---------------- end public routes ---------------------

//  ---------------- start public API routes ------------------
Route::group(['middleware' => ['public_protect:API']], function () {
    require __DIR__ . '/public_routes/public_api_routes.php';
});
// ---------------- end public API routes ---------------------

// ------------------------ user logout route ----------------------
Route::get('/user-logout', [PublicController::class, 'userLogout'])->name('user.logout');


// ------------------ start all users access routes ---------------
require __DIR__ . '/public_routes/all_users_api_routes.php';
// ------------------- start employees routes ---------------

// --------------------- start employee profile routes -----------------
// -------------- protect Employee view routes -------------------
Route::group(['prefix' => '{lang?}', 'middleware' => 'setlocale', 'where' => ['lang' => 'en|as']], function () {
    Route::group(['prefix' => 'employees', 'middleware' => ['user_protect:roles,view,Employee']], function () {
        require __DIR__ . '/employees_access/employee_profile_view_routes.php';
    });
});
// -------------- start protect Employee view routes -------------------

// -------------- protect Employee API routes -------------------
Route::group(['prefix' => 'employees', 'middleware' => ['user_protect:roles,API,Employee']], function () {
    require __DIR__ . '/employees_access/employee_profile_api_routes.php';
});

// -------------- end protect Employee API routes -------------------
// --------------------- end employee profile routes -----------------

// -------------------- start employee dashboard routes -------------------
Route::group(['prefix' => '{lang?}', 'middleware' => 'setlocale', 'where' => ['lang' => 'en|as']], function () {
    Route::group(['prefix' => 'employees', 'middleware' => ['user_protect:roles,view,Employee']], function () {
        require __DIR__  . '/employees_access/employee_dash_view.php';
    });
});


// Route::group(['prefix' => 'employees','middleware'=>['user_protect:roles,view,Verifier,Appointing Authority']], function () {

//     require __DIR__  . '/employees_access/verifier_dash_view.php';
// });


// Route::group(['prefix' => 'employees','middleware'=>['user_protect:roles,view,Verifier,Appointing Authority']], function () {

//     require __DIR__  . '/employees_access/verifier_dash_view.php';
// });


// -------------------- end employees dashboard routes -------------------

// -------------------- end employees dashboard views routes -------------------
// -------------------- start employee dashboard API routes -------------------
Route::group(['prefix' => 'employees', 'middleware' => ['user_protect:roles,API,Employee']], function () {
    require __DIR__  . '/employees_access/employee_dash_api_routes.php';
    require __DIR__ . '/employees_access/transfer_request_api_routes.php';
    require __DIR__ . '/employees_access/transfer_request_view.php';
});


Route::group(['prefix' => 'verifier', 'middleware' => ['user_protect:roles,view,Verifier,Appointing Authority,Appointing User,Approver,Department Hod']], function () {
    require __DIR__  . '/employees_access/verifier_dash_view.php';
});

Route::get('/change-role', [VerificationController::class, 'role_change_index'])->name('change.role');
Route::get('/switch-role/{role_id}', [VerificationController::class, 'switch_role'])->name('switch.role');

Route::group(['prefix' => 'verifier', 'middleware' => ['user_protect:roles,view,Approver']], function () {

    Route::post('/approval-second-recommend', [VerificationController::class, 'approver_second_recommend'])->name('verification.approver.second.recommend');
    // Route::get('/approval-dashboard', [VerificationController::class, 'approver_index'])->name('verification.approver.dashboard');

    // Route::get('/approval-dashboard', [VerificationController::class, 'approver_index'])->name('verification.approver.dashboard');

    Route::post('/final-approval-profile', [VerificationController::class, 'final_approval'])->name('verification.final-approval');

    // Route::post('/final-reject-profile', [VerificationController::class, 'reject_approval'])->name('verification.reject-approval');

    Route::post('/second-recommendation-reject-profile', [VerificationController::class, 'reject_second_recommendation'])->name('verification.reject-second-recommendation');


    Route::get('/jts-pdf', [VerificationController::class, 'approval_all'])->name('verification.jts');

    Route::post('/fetch-candidates/approval', [CandidateController::class, 'fetch_candidates_approval']);

    // Route::post('/fetch-office', [VerificationController::class, 'fetch_office_json']);

    Route::get('approver/logout', [VerificationController::class, 'logout']);
});


// Route::group(['middleware' => ['public_protect:view']], function () {
//     Route::get('/department-login', [VerificationController::class, 'verification_login_department_index'])->name('verification.verification_login_department_index');
// });

Route::group(['prefix' => 'department', 'middleware' => ['user_protect:roles,view,Approver']], function () {

    // Route::get('/department-dashboard', [VerificationController::class, 'department_index'])->name('verification.department.index');

    // Route::get('/approval-all-requests', [VerificationController::class, 'department_all_request'])->name('verification.department.all_request');

    // Route::get('/approval-profile/{id}', [CandidateController::class, 'department_candidate_profile'])->name('verification.department.candidate_profile');

    Route::post('/fetch-office', [VerificationController::class, 'department_fetch_office_json']);

    Route::post('/fetch-candidates/approval', [CandidateController::class, 'department_fetch_candidates_approval']);

    Route::post('/final-approval-profile', [VerificationController::class, 'department_final_approval'])->name('verification.department.final-approval');

    Route::post('/final-reject-profile', [VerificationController::class, 'department_reject_approval'])->name('verification.department.reject-approval');
});



// -------------------- end employees dashboard API routes -------------------


// -------------------- end employees dashboard routes -------------------

// ------------------- end employees routes ---------------

// ----------------- start view admin routes ------------------


Route::group(['prefix' => 'admin'], function () {
    // ------------- admin view routes ---------------
    require __DIR__ . '/admin_routes/admin_view_routes.php';
    // ------------------- admin api routes --------------
    require __DIR__ . '/admin_routes/admin_api_routes.php';
});

// ----------------- end view admin routes ------------------

// --------------------- root access routes ---------------
require __DIR__ . '/root_access/root_access.php';


// ---------------- insert or change post name -----------------


Route::get('/add-post-names', [AuthorController::class, 'index'])->name('add.post.name.index');
Route::post('/add-post-names', [AuthorController::class, 'addPost'])->name('add.post.names');

// --------------- add office details ------------------

Route::get('/add-office-details', [AuthorController::class, 'addOfficeDetails'])->name('add.office.details');
Route::post('/add-office-details', [AuthorController::class, 'addOfficeDetailsPost'])->name('add.office.details.post');