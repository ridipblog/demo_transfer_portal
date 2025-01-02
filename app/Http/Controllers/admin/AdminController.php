<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer\TransfersModel;
use App\Models\User_auth\UserCredentialsModel;
use App\our_modules\reuse_modules\ReuseModule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // --------------- login index page -----------------
    public function index(REquest $request)
    {
        return view('admin.login');
    }
    // ------------------- login API ------------------
    public function indexAPI(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'message' => null,
                'status' => 400
            ];
            $incomming_inputs = [
                'phone' => 'required|integer|exists:appointing_authorities,phone',
                'password' => 'required'
            ];
            $validate = ReuseModule::validateIncomingData($request, $incomming_inputs, $request->all());
            if ($validate->fails()) {
                $res_data['message'] = $validate->errors()->all();
            } else {
                try {
                    $res_data['status'] = 401;
                    $attemp_data = [
                        "phone" => $request->phone,
                        'password' => $request->password,
                        'user_type' => 2,
                        'role_id' => 1,
                        'status' => 1
                    ];
                    if (Auth::guard('user_guard')->attempt($attemp_data)) {
                        $res_data['message'] = Auth::guard('user_guard')->user();
                        $res_data['status'] = 200;
                    } else {
                        $res_data['message'] = "Credentials not found  !";
                    }
                } catch (Exception $err) {
                    $res_data['message'] = "Server error please try later !";
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ----------------- admin dashboard page --------------
    public function adminDashboard(Request $request)
    {
        $view_data = [
            'is_error' => false,
            'message' => null
        ];
        try {

            // -------------- fetch profile verification and recomendation status -----------------
            $main_query = UserCredentialsModel::selectRaw("
            SUM(CASE WHEN profile_verify_status = 0 THEN 1 ELSE 0 END) as pendding,
            SUM(CASE WHEN profile_verify_status = 1 THEN 1 ELSE 0 END) as verified,
            SUM(CASE WHEN profile_verify_status = 2 THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN profile_verify_status IN (0,1) THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN profile_verify_status IN (0,1,2,3) THEN 1 ELSE 0 END) as registered
        ");
            $view_data['profile_verification'] = $main_query->first();

            // -------------- fetch transfers record status -------------------
            $main_query = TransfersModel::selectRaw("
            SUM(CASE WHEN request_status = 1 THEN 1 ELSE 0 END) as total_process_transfers,
            SUM(CASE WHEN request_status = 1 AND final_approval = 0 THEN 1 ELSE 0 END) as transfer_pendding,
            SUM(CASE WHEN request_status = 1 AND final_approval = 1 THEN 1 ELSE 0 END) as transfer_accepted,
            SUM(CASE WHEN request_status = 1 AND final_approval = 2 THEN 1 ELSE 0 END) as transfer_rejected
            ");
            $view_data['transfer_counts'] = $main_query->first();
            $past_date = Carbon::now()->subDay(4)->toDateString();
            $current_date = Carbon::now();
            $date_range = collect(CarbonPeriod::create($past_date, $current_date))
                ->map(fn($date) => $date->toDateString())
                ->toArray();

            // -------------- fetch profile staus for table date wise data ----------------
            $main_query = UserCredentialsModel::selectRaw("
            DATE(created_at) as date,
            SUM(CASE WHEN profile_verify_status IN (0,1,2,3) THEN 1 ELSE 0 END) as total_registration
            ")
                ->where('created_at', '>=', $past_date)
                ->groupBy('date')
                ->orderBy('date', 'asc');
            $view_data['date_wise_registration'] = $main_query->get();
            $main_query = UserCredentialsModel::selectRaw("
            DATE(verified_on) as date,
            SUM(CASE WHEN profile_verify_status = 1 THEN 1 ELSE 0 END) as total_profile_verification
            ")
                ->where('verified_on', '>=', $past_date)
                ->groupBy('date')
                ->orderBy('date', 'asc');

            $view_data['date_wise_verification'] = $main_query->get();
            $main_query = UserCredentialsModel::selectRaw("
            DATE(noc_generated_on) as date,
            SUM(CASE WHEN profile_verify_status = 1 AND noc_generate = 1 THEN 1 ELSE 0 END) as total_profile_recomendation
            ")
                ->where('noc_generated_on', '>=', $past_date)
                ->groupBy('date')
                ->orderBy('date', 'asc');
            $view_data['date_wise_recomendation'] = $main_query->get();
            // -------------- fetch transfer staus for table date wise data ----------------
            $main_query = TransfersModel::selectRaw("
            DATE(approved_on) as date,
            SUM(CASE WHEN final_approval = 1 THEN 1 ELSE 0 END) as total_approved_transfers
            ")->where('approved_on', '>=', $past_date)
                ->groupBy('date')
                ->orderBy('date', 'asc');
            $view_data['date_wise_transfer_approved'] = $main_query->get();
            $main_query = TransfersModel::selectRaw("
            DATE(updated_at) as date,
            SUM(CASE WHEN request_status = 1 THEN 1 ELSE 0 END) as total_JTO
            ")->where('updated_at', '>=', $past_date)
                ->groupBy('date')
                ->orderBy('date', 'asc');
            $view_data['date_wise_transfer_JTO'] = $main_query->get();
            $view_data['date_range'] = $date_range;
        } catch (Exception $err) {
            dd($err->getMessage());
            $view_data['is_error'] = true;
            $view_data['message'] = "Server error please try later !";
        }
        return view('admin.admin_dashboard', [
            'view_data' => $view_data
        ]);
    }
    // ---------- revert user by admin ----------------
    public function revertUser(Request $request)
    {
        $view_data = [
            'is_error' => false,
            'message' => null,
            'all_users' => null
        ];
        try {
            $all_completed_users = UserCredentialsModel::query()
                ->with(['persional_details'])
                ->where('profile_verify_status', 0)
                ->whereHas('persional_details', function ($query) {
                    $query->select('id', 'user_id', 'pan_number');
                })
                ->select('id', 'full_name', 'email', 'phone')
                ->get();
            $view_data['all_users'] = $all_completed_users;
        } catch (Exception $err) {
            $view_data['is_error'] = true;
            // $view_data['message'] = $err->getMessage();
            $view_data['message'] = "Server erro please try later !";
        }
        return view('admin.revert_user', [
            'view_data' => $view_data
        ]);
    }
    // ---- revert user  by admin ajax ----------------
    public function revertUserPost(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            try {
                if ($request->revert_id) {
                    $user_id = Crypt::decryptString($request->revert_id);
                    $revert_user = UserCredentialsModel::where('id', $user_id)
                        ->where('profile_verify_status', 0)
                        ->update([
                            'profile_verify_status' => 3
                        ]);
                    $res_data['message'] = "Revert succesfull  ";
                    $res_data['status'] = 200;
                } else {
                    $res_data['message'] = "User key not found !";
                }
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
}
