<?php

namespace App\Http\Controllers\employees_access\verification;

use App\Http\Controllers\Controller;
use App\Models\authority_office_dist_map;
use App\Models\department\departments;
use App\Models\Public\DepertPostsMapModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\Public\RegistrationOTPVerifyModel;
use App\Models\Public\RolesModel;
use App\Models\Transfer\TransfersModel;
use App\Models\User\DocumentModel;
use App\Models\User_auth\AllLoginModel;
use App\Models\User_auth\UserCredentialsModel;
use App\Models\verification\appointing_authorities;
use App\Models\verification\office;
use App\Models\verification\verification_otp;
use App\Models\verification\VerificationRemarksDocumentModel;
use App\Models\verification_documents;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{

    public function correct()
    {
        // $actual_data = appointing_authorities::pluck('phone')->toArray(); 
     
        // $actual_data_lookup = array_flip($actual_data);

        // $a = AllLoginModel::get();

        // $ids_to_delete = [];
        // foreach ($a as $aa) {
        //     if (!isset($actual_data_lookup[$aa->phone])) {
        //         $ids_to_delete[] = $aa->id;
        //     }
        // }

        // if (!empty($ids_to_delete)) {
        //     AllLoginModel::whereIn('id', $ids_to_delete)->delete();
        // }
        // dd('done');
        DB::beginTransaction();  
        try {
            $actual_data = appointing_authorities::pluck('phone')->toArray(); 
   
            $actual_data = appointing_authorities::pluck('phone')->toArray(); 
        $actual_data_lookup = array_flip($actual_data);

        $appointing_authorities_bckp = DB::table('appointing_authorities1')->get(); 
        $user_ids = [];   
        
        foreach ($appointing_authorities_bckp as $d) {
            if (!isset($actual_data_lookup[$d->phone])) {
                array_push($user_ids, $d->id);
                appointing_authorities::create([
                    // 'id' => $d->id,
                    'name' => $d->name,
                    'designation' => $d->designation,
                    'phone' => $d->phone,
                    'department' => $d->department,
                    'office' => null,
                    'district' => null,
                    'first_login' => $d->first_login,
                    'created_at' => $d->created_at,
                    'updated_at' => $d->updated_at
                ]);
            }
        }
            
            $all_login_bckp = DB::table('all_login1')->get(); 
            foreach ($all_login_bckp as $b) {
                if (!in_array($b->user_id, $user_ids)) {
                    AllLoginModel::create([
                        'user_id' => $b->user_id,
                        'user_type' => $b->user_type,
                        'phone' => $b->phone,
                        'password' => $b->password,
                        'role_id' => 6,
                        'status' => $b->status,
                        'created_at' => $b->created_at,
                        'updated_at' => $b->updated_at
                    ]);
                }
            }
    
            $map_bkp = DB::table('authority_office_dist_maps1')->get();
            foreach ($map_bkp as $m) {
                if (!in_array($m->user_id, $user_ids)) {
                    authority_office_dist_map::create([
                        'user_id' => $m->user_id,
                        'office_id' => $m->office_id,
                        'district_id' => $m->district_id,
                        'department_id' => $m->department_id,
                        'created_at' => $m->created_at,
                        'role_id' => 6,
                        'directorate_id' => $m->directorate_id,
                        'updated_at' => $m->updated_at
                    ]);
                }
            }
    
            DB::commit(); 
        } catch (Exception $err) {
            DB::rollBack(); 
            dd($err->getMessage());
        }
    }
    public function index_login()
    {
        // dd(app()->getLocale());
        return view('verification.other-login');
    }

    // public function new_dashboard_approval()
    // {
    //     return view('verification.club_dashboard');
    // }

    // public function verifier_index()
    // {
    //     return view('verification.club_dashboard');
    // }

    // departmet///////////////////////////////////////////////////////////////////////////////////////////////
    public function verification_login_department_index(Request $request)
    {
        return view('verification.department.login');
    }


    public function department_pin_index()
    {
        if (Session::has('verifier_id')) {
            $verifier = appointing_authorities::where('id', Session::get('verifier_id'))->first();
        } else {
            if (Auth::guard('user_guard')->check()) {
                $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            } else {
                return redirect()->back();
            }
        }
        $otp = rand(100000, 999999);
        date_default_timezone_set('Asia/Kolkata');
        $send_time = date('Y-m-d H:i:s');
        verification_otp::updateOrInsert(
            ['phone' => $verifier->phone],
            [
                'OTP' => $otp,
                'expire_time' => $send_time,
                'is_used' => 0
            ]
        );
        $name = $verifier->name;
        return view('verification.department.set_new_password')->with(['name' =>  $name]);
    }

    public function department_index()
    {
        if (Auth::guard('user_guard')->check() && Auth::guard('user_guard')->user()->role_id == 2) {
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            $uu = appointing_authorities::leftJoin('deptartments', 'appointing_authorities.department', '=', 'deptartments.id')
                ->leftJoin('districts', 'appointing_authorities.district', '=', 'districts.id')
                ->leftJoin('offices_finassam', 'appointing_authorities.office', '=', 'offices_finassam.id')
                ->where('appointing_authorities.id', $verifier->id)
                ->select('offices_finassam.name as office_name', 'deptartments.name as department_name', 'districts.name as district_name', 'appointing_authorities.name as verifier_name', 'appointing_authorities.id as id')
                ->first();
            Session::put([
                'department_name' => $uu->department_name,
                'district_name' => 'All District',
                'verifier_name' => $uu->verifier_name,
                'role' =>  Auth::guard('user_guard')->user()->roles->display_name,
                'office' => 'All Office',
                'is_dept' => 1,
            ]);
            $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)->where('role_id', 7)->get();
            $transfer_data = $this->approver_dashboard_data_fetch($verifier, $authority_maps);
            $allTransfers = $transfer_data['allTransfers'];
            $approvedTransfers = $transfer_data['approvedTransfers'];
            $rejectedTransfers = $transfer_data['rejectedTransfers'];
            $pendingTransfers = $transfer_data['pendingTransfers'];
            $employees = $transfer_data['allTransfers'];
            return view('verification.department.dashboard')->with(['employees' => $employees, 'allTransfers' => $allTransfers, 'approvedTransfers' => $approvedTransfers, 'rejectedTransfers' => $rejectedTransfers, 'pendingTransfers' => $pendingTransfers]);
        } else {
            return redirect()->route('verification-login');
        }
    }


    public function department_all_request()
    {
        if (Auth::guard('user_guard')->check() && Auth::guard('user_guard')->user()->role_id == 2) {
            $user = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            $district = DistrictModel::get(['id', 'name']);
            $department = departments::where('id', $user->department)->first();
            $mapped_office = OfficesDistDeptModel::where('depertment_id', 58)
                ->with('office_fin_assam')
                ->get();
            $office = $mapped_office;

            $posts = DepertPostsMapModel::when($user->department != null, function ($query) use ($user) {
                return $query->where('dept_id', $user->department);
            })
                ->join('post_names', 'depts_posts_map.post_id', '=', 'post_names.id')
                ->select('post_names.name as post_name', 'post_names.id', 'depts_posts_map.grade_pay')
                ->get();
            return view('verification.department.search-profile', compact('district', 'department', 'office', 'posts'));
        } else {
            return redirect()->route('verification-login');
        }
    }

    public function department_fetch_office_json(Request $request)
    {
        try {
            $user = Auth::guard('user_guard')->user();
            $roleName = '';
            if ($user) {
                $roleName = $user->roles->role;
            }
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            if ($request->has('district')) {
                $district = $request->input('district');
            } else {
                $district = null;
            }

            if ($district == null || $district == 'All') {
                $mapped_office = OfficesDistDeptModel::where('depertment_id', $verifier->department)
                    ->with('office_fin_assam')
                    ->get();
                $office = $mapped_office;
                return response()->json([
                    'status' => 200,
                    'data' => $office,
                    'message' => 'Office fetched successfully'
                ]);
            } else {
                $mapped_office = OfficesDistDeptModel::where('depertment_id', $verifier->department)->where('district_id', $district)
                    ->with('office_fin_assam')
                    ->with('districts')
                    ->get();
                $office = $mapped_office;
                return response()->json([
                    'status' => 200,
                    'data' => $office,
                    'message' => 'Office fetched successfully'
                ]);
            }
        } catch (Exception $err) {
            return response()->json([
                'status' => 500,
                'message' => $err->getMessage()
            ]);
        }
    }

    public function department_final_approval(Request $request)
    {
        if (Auth::guard('user_guard')->check() && Auth::guard('user_guard')->user()->role_id == 2) {
            try {
                $id = Crypt::decryptString($request->input('id'));
                $transfer = TransfersModel::findOrFail($id);
                $c1 = UserCredentialsModel::where('id', $transfer->employee_id)->first();
                $c2 = UserCredentialsModel::where('id', $transfer->target_employee_id)->first();

                $transfer->update([
                    'final_approval' => 1,
                    'approver_remarks' => $request->input('verifier_remarks') != null ? $request->input('verifier_remarks') : null,
                    'approved_by' => Auth::guard('user_guard')->user()->user_id,
                    'approved_on' => Carbon::now()
                ]);

                ReuseModule::sendFinalApprovalOTP($c1->phone);
                ReuseModule::sendFinalApprovalOTP($c2->phone);
                session()->flash('flash_message', 1);
                session()->flash('message', 'Candidate Approved');
                // return redirect('/verifier/approval-dashboard');
                return redirect()->back();
            } catch (Exception $err) {
                Log::error('error_approval: ' . $err->getMessage());
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function department_reject_approval(Request $request)
    {
        if (Auth::guard('user_guard')->check() && Auth::guard('user_guard')->user()->role_id == 7) {
            try {
                $id = Crypt::decryptString($request->input('candidate_reject_id'));
                $transfer = TransfersModel::findOrFail($id);

                $transfer->update([
                    'final_approval' => 2,
                    'approver_remarks' => $request->input('reject_message') != null ? $request->input('reject_message') : null,
                    'approved_by' => Auth::guard('user_guard')->user()->user_id,
                    'approved_on' => Carbon::now()
                ]);
                session()->flash('flash_message', 1);
                session()->flash('message', 'Candidate Rejected');
                return redirect()->route('verification.department.all_request', ['lang' => app()->getLocale()]);
            } catch (Exception $err) {
                Log::error('error_approval: ' . $err->getMessage());
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }


    //////////////////////////////////////////////////////////////////



    public function approver_index()
    {
        if (Auth::guard('user_guard')->check()) {
            $uu = appointing_authorities::leftJoin('deptartments', 'appointing_authorities.department', '=', 'deptartments.id')
                ->leftJoin('districts', 'appointing_authorities.district', '=', 'districts.id')
                ->where('appointing_authorities.id',  Auth::guard('user_guard')->user()->user_id)
                ->select('deptartments.name as department_name', 'districts.name as district_name', 'appointing_authorities.name as verifier_name', 'appointing_authorities.id as id', 'appointing_authorities.department')
                ->first();

            $d = AllLoginModel::where('user_id', $uu->id)->leftJoin('roles', 'all_login.role_id', '=', 'roles.id')->select('roles.role', 'roles.display_name as display_name')->first();

            $authority_map = authority_office_dist_map::where('user_id', Auth::guard('user_guard')->user()->user_id)->get();
            $authority_map_count = count($authority_map);
            if ($authority_map_count == 1) {
                $authority_map2 = authority_office_dist_map::where('user_id', Auth::guard('user_guard')->user()->user_id)->first();
                if ($authority_map2->office_id != null) {
                    $office = OfficeFinAsssamModel::where('id', $authority_map2->office_id)->first();
                    $office_name = $office->name;
                } else {
                    $office_name = 'All Office';
                }

                if ($authority_map2->district_id != null) {
                    $district = DistrictModel::where('id', $authority_map2->district_id)->first();
                    $district_name = $district->name;
                } else {
                    $district_name = 'All District';
                }
            } else {
                $office_name = 'All Office';
                $district_name = 'All District';
            }

            Session::put([
                'department_name' => $uu->department_name,
                'district_name' => $uu->district_name,
                'verifier_name' => $uu->verifier_name,
                'role' => $d->display_name
            ]);

            $role_ids = AllLoginModel::where('user_id', Auth::guard('user_guard')->user()->user_id)->pluck('role_id')->toArray();
            $roles = RolesModel::whereIn('id', $role_ids)->get();
            Session::put([
                'department_name' => $uu->department_name,
                'district_name' => $district_name,
                'verifier_name' => $uu->verifier_name,
                'role' => $d->display_name,
                'office' => $office_name,
                'all_roles' => $roles
            ]);
            $employees = TransfersModel::all();
            $authority_maps = authority_office_dist_map::where('user_id', $uu->id)->get();
            // $pendingTransfers = TransfersModel::where('request_status', 1)
            //     ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
            //     ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
            //     ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
            //     ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
            //     ->where('employee_employment.depertment_id', $uu->department)
            //     ->where('target_employee_employment.depertment_id', $uu->department)
            //     ->select('employee.full_name as employee_name', 'target_employee.full_name as target_employee_name', 'transafers.id as id', 'transafers.transfer_ref_code')
            //     ->orderBy('transafers.updated_at', 'desc')
            //     ->get();
            $pendingTransfers = TransfersModel::where('request_status', 0)
                ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->where('employee_employment.depertment_id', $uu->department)
                ->where('target_employee_employment.depertment_id', $uu->department);
            if ($authority_maps->isNotEmpty()) {
                $pendingTransfers->where(function ($query) use ($authority_maps) {
                    foreach ($authority_maps as $map) {
                        if ($map->office_id && is_null($map->district_id)) {
                            $query->where('employee_employment.office_id', $map->office_id)->orWhere('target_employee_employment.office_id', $map->office_id);
                        } elseif ($map->district_id && is_null($map->office_id)) {
                            $query->where('employee_employment.district_id', $map->district_id)->orWhere('target_employee_employment.district_id', $map->district_id);
                        } elseif ($map->office_id && $map->district_id) {
                            $query->orWhere(function ($subQuery) use ($map) {
                                $subQuery->where('employee_employment.office_id', $map->office_id)->orWhere('target_employee_employment.office_id', $map->office_id)
                                    ->where('employee_employment.district_id', $map->district_id)->orWhere('target_employee_employment.district_id', $map->district_id);
                            });
                        }
                    }
                });
            }

            $pendingTransfers = $pendingTransfers
                ->select(
                    'employee.full_name as employee_name',
                    'target_employee.full_name as target_employee_name',
                    'transafers.id as id',
                    'transafers.transfer_ref_code',
                    'transafers.updated_at'
                )
                ->orderBy('transafers.updated_at', 'desc')
                ->get();

            // $allTransfers = TransfersModel::whereIn('request_status', [0, 1])
            //     ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
            //     ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
            //     ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
            //     ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
            //     ->where('employee_employment.depertment_id', $uu->department)
            //     ->where('target_employee_employment.depertment_id', $uu->department)
            //     ->select('employee.full_name as employee_name', 'target_employee.full_name as target_employee_name', 'transafers.id as id', 'transafers.transfer_ref_code', 'transafers.final_approval')
            //     ->orderBy('transafers.updated_at', 'desc')
            //     ->get();
            $allTransfers = TransfersModel::whereIn('request_status', [0, 1])
                ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->where('employee_employment.depertment_id', $uu->department)
                ->where('target_employee_employment.depertment_id', $uu->department);

            // Apply authority map filters if available
            if ($authority_maps->isNotEmpty()) {
                $allTransfers->where(function ($query) use ($authority_maps) {
                    foreach ($authority_maps as $map) {
                        // Filtering based on office and district IDs
                        if ($map->office_id && is_null($map->district_id)) {
                            $query->where('employee_employment.office_id', $map->office_id)
                                ->orWhere('target_employee_employment.office_id', $map->office_id);
                        } elseif ($map->district_id && is_null($map->office_id)) {
                            $query->where('employee_employment.district_id', $map->district_id)
                                ->orWhere('target_employee_employment.district_id', $map->district_id);
                        } elseif ($map->office_id && $map->district_id) {
                            $query->orWhere(function ($subQuery) use ($map) {
                                $subQuery->where('employee_employment.office_id', $map->office_id)
                                    ->orWhere('target_employee_employment.office_id', $map->office_id)
                                    ->where('employee_employment.district_id', $map->district_id)
                                    ->orWhere('target_employee_employment.district_id', $map->district_id);
                            });
                        }
                    }
                });
            }

            // Select specific columns, order by updated_at, and get the results
            $allTransfers = $allTransfers->select(
                'employee.full_name as employee_name',
                'target_employee.full_name as target_employee_name',
                'transafers.id as id',
                'transafers.transfer_ref_code',
                'transafers.updated_at'
            )
                ->orderBy('transafers.updated_at', 'desc')
                ->get();

            $rejectedTransfers = TransfersModel::where('final_approval', 2)
                ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->where('employee_employment.depertment_id', $uu->department)
                ->where('target_employee_employment.depertment_id', $uu->department);

            if ($authority_maps->isNotEmpty()) {
                $rejectedTransfers->where(function ($query) use ($authority_maps) {
                    foreach ($authority_maps as $map) {
                        if ($map->office_id && is_null($map->district_id)) {
                            $query->where('employee_employment.office_id', $map->office_id)
                                ->orWhere('target_employee_employment.office_id', $map->office_id);
                        } elseif ($map->district_id && is_null($map->office_id)) {
                            $query->where('employee_employment.district_id', $map->district_id)
                                ->orWhere('target_employee_employment.district_id', $map->district_id);
                        } elseif ($map->office_id && $map->district_id) {
                            $query->orWhere(function ($subQuery) use ($map) {
                                $subQuery->where('employee_employment.office_id', $map->office_id)
                                    ->orWhere('target_employee_employment.office_id', $map->office_id)
                                    ->where('employee_employment.district_id', $map->district_id)
                                    ->orWhere('target_employee_employment.district_id', $map->district_id);
                            });
                        }
                    }
                });
            }

            $rejectedTransfers = $rejectedTransfers
                ->select(
                    'employee.full_name as employee_name',
                    'target_employee.full_name as target_employee_name',
                    'transafers.id as id',
                    'transafers.transfer_ref_code',
                    'transafers.updated_at'
                )
                ->orderBy('transafers.updated_at', 'desc')
                ->get();


            $approvedTransfers = TransfersModel::where('final_approval', 1)->get();
            return view('verification.district.dashboard', compact('allTransfers', 'employees', 'pendingTransfers', 'approvedTransfers', 'rejectedTransfers'));
        } else {
            return redirect()->route('verification-login');
        }
    }


    public function verifier_index()
    {
        Session::forget('is_appointing_user');
        $user = Auth::guard('user_guard')->user()->user_type;
        if ($user == '2' && Auth::guard('user_guard')->user()->role_id != 7) {
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            if ($verifier != null) {
                $uu = appointing_authorities::leftJoin('deptartments', 'appointing_authorities.department', '=', 'deptartments.id')
                    ->leftJoin('districts', 'appointing_authorities.district', '=', 'districts.id')
                    ->leftJoin('offices_finassam', 'appointing_authorities.office', '=', 'offices_finassam.id')
                    ->where('appointing_authorities.id', $verifier->id)
                    ->select('appointing_authorities.department', 'offices_finassam.name as office_name', 'deptartments.name as department_name', 'districts.name as district_name', 'appointing_authorities.name as verifier_name', 'appointing_authorities.id as id')
                    ->first();
                $d = AllLoginModel::where('user_id', $uu->id)->leftJoin('roles', 'all_login.role_id', '=', 'roles.id')->select('roles.role')->first();

                $authority_map = authority_office_dist_map::where('user_id', $verifier->id)->get();
                $authority_map_count = count($authority_map);
                if ($authority_map_count == 1) {
                    $authority_map2 = authority_office_dist_map::where('user_id', $verifier->id)->first();
                    if ($authority_map2->office_id != null) {
                        $office = OfficeFinAsssamModel::where('id', $authority_map2->office_id)->first();
                        $office_name = $office->name;
                    } else {
                        $office_name = 'All Office';
                    }
                    if ($authority_map2->district_id != null) {
                        $district = DistrictModel::where('id', $authority_map2->district_id)->first();
                        $district_name = $district->name;
                    } else {
                        $district_name = 'All District';
                    }
                } else {
                    $office_name = 'All Office';
                    $district_name = 'All District';
                }
                $user1 = Auth::guard('user_guard')->user();
                $roleName = '';
                if ($user1) {
                    $roleName = $user1->roles->role;
                }
                $role_ids = AllLoginModel::where('user_id', $verifier->id)->pluck('role_id')->toArray();
                $switch_condition = 0;
                $switch_condition2 = 0;
                if (array_diff([7], $role_ids) === [] && count($role_ids) > 1) {
                    $switch_condition = 1;
                } else {
                    $switch_condition = 0;
                }
                if (array_diff([5, 6], $role_ids) === []) {
                    $switch_condition2 = 1;
                }
                $roles = RolesModel::whereIn('id', $role_ids)->get();
                $display_role_name = "";
                if (count($roles) > 1) {
                    foreach ($roles as $r) {
                        $display_role_name .= $r->display_name . ' / ';
                    }
                    $display_role_name = rtrim($display_role_name, ' / ');
                } else {
                    $display_role_name = Auth::guard('user_guard')->user()->roles->display_name;
                }
                Session::put([
                    'department_name' => $uu->department_name,
                    'district_name' => $district_name,
                    'verifier_name' => $uu->verifier_name,
                    'role' => $d->display_name,
                    'office' => $office_name,
                    'all_roles' => $roles,
                    'switch_condition' => $switch_condition,
                    'display_role_name' => $display_role_name,
                    'is_dept' => 0,
                ]);

                $role_names_arr = RolesModel::whereIn('id', $role_ids)->pluck('role')->toArray();

                // transfers
                $allTransfers = [];

                $approvedTransfers = [];
                $rejectedTransfers = [];
                $pendingTransfers = [];
                $employees = [];
                $dept_count = 0;
                $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)->get();
                $dept_ids = authority_office_dist_map::where('user_id', $verifier->id)->pluck('department_id')->toArray();
                if (in_array('Approver', $role_names_arr)) {
                    $authority_maps2 = authority_office_dist_map::where('user_id', $verifier->id)->where('role_id', 2)->get();
                    $transfer_data = $this->approver_dashboard_data_fetch($verifier, $authority_maps2);
                    $allTransfers = $transfer_data['allTransfers'];
                    $approvedTransfers = $transfer_data['approvedTransfers'];
                    $rejectedTransfers = $transfer_data['rejectedTransfers'];
                    $pendingTransfers = $transfer_data['pendingTransfers'];
                    $employees = $transfer_data['allTransfers'];
                    $dept_count = $transfer_data['dept_count'];
                }
                $usersQuery = UserCredentialsModel::whereIn('profile_verify_status', [0, 1])
                    ->join('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                    ->join('districts', 'employment_details.district_id', '=', 'districts.id')
                    ->join('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                    ->join('offices_finassam', 'employment_details.office_id', '=', 'offices_finassam.id')
                    ->leftJoin('documents', function ($join) {
                        $join->on('user_credentials.id', '=', 'documents.user_id')
                            ->where('documents.document_type', '=', 1);
                    })
                    ->leftJoin('post_names', 'employment_details.designation_id', '=', 'post_names.id')
                    ->whereIn('employment_details.depertment_id', $dept_ids)
                    ->select(
                        'user_credentials.*',
                        'documents.documet_location as photo_path',
                        'districts.name as district_name',
                        'deptartments.name as department_name',
                        'post_names.name as designation_name'
                    );
                $categorizedResults = [];
                foreach ($authority_maps as $map) {
                    // if (is_null($map->office_id) && is_null($map->district_id)) {
                    //     continue;
                    // }
                    $query = clone $usersQuery;
                    $query->where(function ($subQuery) use ($map) {
                        if ($map->office_id && is_null($map->district_id)) {
                            $subQuery->where('employment_details.office_id', $map->office_id);
                        } elseif ($map->district_id && is_null($map->office_id)) {
                            $subQuery->where('employment_details.district_id', $map->district_id);
                        } elseif ($map->office_id && $map->district_id) {
                            $subQuery->where('employment_details.office_id', $map->office_id)
                                ->where('employment_details.district_id', $map->district_id);
                        }
                    });
                    $resultsForRole = $query->orderBy('user_credentials.updated_at', 'desc')->get();
                    $categorizedResults[$map->role_id] = [
                        'users' => $resultsForRole,
                        'doc_paths' => [],
                    ];
                    $userIds = $resultsForRole->pluck('id')->toArray();
                    if (!empty($userIds)) {
                        $docs = DocumentModel::whereIn('user_id', $userIds)
                            ->where('document_type', 1)
                            ->get();
                        if (!$docs->isEmpty()) {
                            $docPaths = $docs->pluck('documet_location')->toArray();
                            $categorizedResults[$map->role_id]['doc_paths'] = $docPaths;
                        }
                    }
                }
                // dd($usersQuery->get());
                $all_users = null;
                $pending_users = collect();
                $verified_users = collect();
                $noc_pending = collect();
                $noc_completed = collect();

                $verify_recommend = collect();
                $verify_recommend_pending_recommend = collect();
                $verify_recommend_completed = collect();
                $verify_pending_verify = collect();

                $all_noc = collect();
                $docs_path = [];

                if (isset($categorizedResults[6]) && !isset($categorizedResults[5])) {
                    $users6 = isset($categorizedResults[6]) ? $categorizedResults[6]['users'] : collect();
                    $all_users =  $users6;
                    $pending_users = $all_users->where('profile_verify_status', 0);
                    $verified_users = $all_users->where('profile_verify_status', 1);
                }



                if (isset($categorizedResults[6]) && isset($categorizedResults[5])) {
                    $users5 = isset($categorizedResults[5]) ? $categorizedResults[5]['users'] : collect();
                    $users6 = isset($categorizedResults[6]) ? $categorizedResults[6]['users'] : collect();
                    $all_users = $users5->merge($users6);
                    $pending_users = $all_users->where('profile_verify_status', 0);
                    $verified_users = $all_users->where('profile_verify_status', 1);
                }

                if (isset($categorizedResults[5]) && !isset($categorizedResults[6])) {
                    Session::put('is_appointing_user', 0);
                    $users5 = isset($categorizedResults[5]) ? $categorizedResults[5]['users'] : collect();
                    $all_users = $users5;
                    $pending_users = $all_users->where('profile_verify_status', 0);
                    $verified_users = $all_users->where('profile_verify_status', 1);

                    $noc_pending = $all_users->where('noc_generate', 0);
                    $noc_completed = $all_users->where('noc_generate', 1);
                }

                if (isset($categorizedResults[5]) && !isset($categorizedResults[3])) {
                    $verify_recommend = $categorizedResults[5]['users'];
                    $verify_recommend_pending_recommend = $verify_recommend->where('noc_generate', 0)->where('profile_verify_status', 1);
                    $verify_recommend_completed = $verify_recommend->where('noc_generate', 1)->where('profile_verify_status', 1);
                    $verify_pending_verify = $verify_recommend->where('noc_generate', 0)->where('profile_verify_status', 0);

                    $noc_pending = $verify_recommend->where('noc_generate', 0);
                    $noc_completed = $verify_recommend->where('noc_generate', 1);
                }

                if (isset($categorizedResults[5]) && isset($categorizedResults[3])) {
                    $verify_recommend1 = $categorizedResults[5]['users'];
                    $verify_recommend2 = $categorizedResults[3]['users']->where('profile_verify_status', 1);
                    $verify_recommend = $verify_recommend1->merge($verify_recommend2);
                    $verify_recommend_pending_recommend = $verify_recommend->where('noc_generate', 0)->where('profile_verify_status', 1);
                    $verify_recommend_completed = $verify_recommend->where('noc_generate', 1)->where('profile_verify_status', 1);
                    $verify_pending_verify = $verify_recommend->where('noc_generate', 0)->where('profile_verify_status', 0);
                    $noc_pending = $verify_recommend->where('noc_generate', 0);
                    $noc_completed = $verify_recommend->where('noc_generate', 1);
                    $all_users = $verify_recommend->whereIn('profile_verify_status', [0, 1]);
                    $pending_users = $all_users->where('profile_verify_status', 0);
                    $verified_users = $all_users->where('profile_verify_status', 1);
                    Session::put('is_mixed', true);
                }
                // dd($categorizedResults);
                if (isset($categorizedResults[3]) && !isset($categorizedResults[5])) {
                    $all_noc = $categorizedResults[3]['users']->where('profile_verify_status', 1);
                    $noc_pending = $all_noc->where('noc_generate', 0)->where('profile_verify_status', 1);
                    $noc_completed = $all_noc->where('noc_generate', 1)->where('profile_verify_status', 1);
                }

                if (isset($categorizedResults[2])) {
                    $all_noc = isset($categorizedResults[2]) ? $categorizedResults[2]['users'] : collect();
                    $noc_pending = $all_noc->where('noc_generate', 0)->where('profile_verify_status', 1);
                    $noc_completed = $all_noc->where('noc_generate', 1)->where('profile_verify_status', 1);
                }

                return view('verification.club_dashboard')->with(['verify_pending_recommend_club' => $verify_recommend_pending_recommend, 'verify_completed_club' => $verify_recommend_completed, 'verify_pending_club' => $verify_pending_verify, 'verify_recommend' => $verify_recommend, 'dept_count' => $dept_count, 'employees' => $employees, 'allTransfers' => $allTransfers, 'approvedTransfers' => $approvedTransfers, 'rejectedTransfers' => $rejectedTransfers, 'pendingTransfers' => $pendingTransfers, 'user_roles_arr' => $role_names_arr, 'all_users' => $all_users, 'pending_users' => $pending_users, 'noc_pending' => $noc_pending, 'verified_profiles' => $verified_users, 'profile_pics' => $docs_path, 'noc_completed' => $noc_completed, 'all_noc' => $all_noc]);
            }
        } else {
            Log::error('Verification login: User_type: ' . $user . ', not suitable for login. user_id: ' . Auth::guard('user_guard')->user()->user_id);
            return redirect()->back();
        }
    }


    public function approver_dashboard_data_fetch($user = null, $map_data = null)
    {
        try {
            $uu = $user;
            $authority_maps = $map_data;
            // dd($authority_maps);
            if (Auth::guard('user_guard')->user()->role_id == 7) {
                $dept_ids = authority_office_dist_map::where('user_id', $user->id)->where('role_id', 7)->pluck('department_id')->toArray();
            } else {
                $dept_ids = authority_office_dist_map::where('user_id', $user->id)->where('role_id', 2)->pluck('department_id')->toArray();
            }
            $d = AllLoginModel::where('user_id', $uu->id)->leftJoin('roles', 'all_login.role_id', '=', 'roles.id')->select('roles.role', 'roles.display_name as display_name')->first();
            $dir = authority_office_dist_map::where('user_id', $user->id)->where('role_id', 2)->pluck('directorate_id')->first();

            $pendingTransfers = TransfersModel::where('request_status', 0)->where('final_approval', '!=', 2)->where('2nd_recommend', '!=', 2)->where('request_status', '!=', 0)->where('request_status', '!=', 2)
                ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->whereIn('employee_employment.depertment_id', $dept_ids)
                ->whereIn('target_employee_employment.depertment_id', $dept_ids);
            // ->where('employee_employment.directorate_id', $dir)
            // ->where('target_employee_employment.directorate_id', $dir);
            if ($dir != null) {
                $pendingTransfers->where('employee_employment.directorate_id', $dir)->where('target_employee_employment.directorate_id', $dir);
            }
            if ($authority_maps->isNotEmpty()) {
                $pendingTransfers->where(function ($query) use ($authority_maps) {
                    foreach ($authority_maps as $map) {
                        if (is_null($map->office_id) && is_null($map->district_id)) {
                            break;
                        }
                        $query->orWhere(function ($subQuery) use ($map) {
                            if ($map->office_id && is_null($map->district_id)) {
                                $subQuery->where('employee_employment.office_id', $map->office_id)
                                    ->orWhere('target_employee_employment.office_id', $map->office_id);
                            } elseif ($map->district_id && is_null($map->office_id)) {
                                $subQuery->where('employee_employment.district_id', $map->district_id)
                                    ->orWhere('target_employee_employment.district_id', $map->district_id);
                            } elseif ($map->office_id && $map->district_id) {
                                $subQuery->where(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('employee_employment.office_id', $map->office_id)
                                        ->where('employee_employment.district_id', $map->district_id);
                                })->orWhere(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('target_employee_employment.office_id', $map->office_id)
                                        ->where('target_employee_employment.district_id', $map->district_id);
                                });
                            }
                        });
                    }
                });
            }

            $pendingTransfers = $pendingTransfers
                ->select(
                    'employee.full_name as employee_name',
                    'target_employee.full_name as target_employee_name',
                    'transafers.id as id',
                    'transafers.transfer_ref_code',
                    'transafers.updated_at',
                    'transafers.final_approval'
                )
                ->orderBy('transafers.updated_at', 'desc')
                ->get();


            $allTransfers = TransfersModel::whereIn('request_status', [0, 1])
                ->where('final_approval', '!=', 2)
                ->where('2nd_recommend', '!=', 2)->where('request_status', '!=', 0)->where('request_status', '!=', 2)
                ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->whereIn('employee_employment.depertment_id', $dept_ids)
                ->whereIn('target_employee_employment.depertment_id', $dept_ids);
            // ->where('employee_employment.directorate_id', $dir)
            // ->where('target_employee_employment.directorate_id', $dir);
            if ($dir != null) {
                $allTransfers->where('employee_employment.directorate_id', $dir)->where('target_employee_employment.directorate_id', $dir);
            }
            // dd($allTransfers->get());
            // Apply authority map filters if available
            if ($authority_maps->isNotEmpty()) {
                $allTransfers->where(function ($query) use ($authority_maps) {
                    foreach ($authority_maps as $map) {
                        if (is_null($map->office_id) && is_null($map->district_id)) {
                            break;
                        }
                        $query->orWhere(function ($subQuery) use ($map) {
                            if ($map->office_id && is_null($map->district_id)) {
                                $subQuery->where('employee_employment.office_id', $map->office_id)
                                    ->orWhere('target_employee_employment.office_id', $map->office_id);
                            } elseif ($map->district_id && is_null($map->office_id)) {
                                $subQuery->where('employee_employment.district_id', $map->district_id)
                                    ->orWhere('target_employee_employment.district_id', $map->district_id);
                            } elseif ($map->office_id && $map->district_id) {
                                $subQuery->where(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('employee_employment.office_id', $map->office_id)
                                        ->where('employee_employment.district_id', $map->district_id);
                                })->orWhere(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('target_employee_employment.office_id', $map->office_id)
                                        ->where('target_employee_employment.district_id', $map->district_id);
                                });
                            }
                        });
                    }
                });
            }
            // Select specific columns, order by updated_at, and get the results
            $allTransfers = $allTransfers->select(
                'employee.full_name as employee_name',
                'target_employee.full_name as target_employee_name',
                'transafers.id as id',
                'transafers.transfer_ref_code',
                'transafers.updated_at',
                'transafers.final_approval',
                'transafers.2nd_recommend',
                'transafers.jto_generate_status',
            )
                ->orderBy('transafers.updated_at', 'desc')
                ->get();

            $rejectedTransfers = TransfersModel::where('final_approval', 2)->orWhere('2nd_recommend', '=', 2)->where('request_status', '!=', 0)->where('request_status', '!=', 2)
                ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->whereIn('employee_employment.depertment_id', $dept_ids)
                ->whereIn('target_employee_employment.depertment_id', $dept_ids);
            if ($dir != null) {
                $rejectedTransfers->where('employee_employment.directorate_id', $dir)->where('target_employee_employment.directorate_id', $dir);
            }

            if ($authority_maps->isNotEmpty()) {
                $rejectedTransfers->where(function ($query) use ($authority_maps) {
                    foreach ($authority_maps as $map) {
                        if (is_null($map->office_id) && is_null($map->district_id)) {
                            break;
                        }
                        $query->orWhere(function ($subQuery) use ($map) {
                            if ($map->office_id && is_null($map->district_id)) {
                                $subQuery->where('employee_employment.office_id', $map->office_id)
                                    ->orWhere('target_employee_employment.office_id', $map->office_id);
                            } elseif ($map->district_id && is_null($map->office_id)) {
                                $subQuery->where('employee_employment.district_id', $map->district_id)
                                    ->orWhere('target_employee_employment.district_id', $map->district_id);
                            } elseif ($map->office_id && $map->district_id) {
                                $subQuery->where(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('employee_employment.office_id', $map->office_id)
                                        ->where('employee_employment.district_id', $map->district_id);
                                })->orWhere(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('target_employee_employment.office_id', $map->office_id)
                                        ->where('target_employee_employment.district_id', $map->district_id);
                                });
                            }
                        });
                    }
                });
            }

            $rejectedTransfers = $rejectedTransfers
                ->select(
                    'employee.full_name as employee_name',
                    'target_employee.full_name as target_employee_name',
                    'transafers.id as id',
                    'transafers.transfer_ref_code',
                    'transafers.updated_at',
                    'transafers.final_approval'
                )
                ->orderBy('transafers.updated_at', 'desc')
                ->get();

            // $approvedTransfers = TransfersModel::where('final_approval', 1)->get();
            $approvedTransfers = TransfersModel::where('final_approval', 1)->where('request_status', '!=', 0)->where('request_status', '!=', 2)
                ->leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->whereIn('employee_employment.depertment_id', $dept_ids)
                ->whereIn('target_employee_employment.depertment_id', $dept_ids);
            if ($authority_maps->isNotEmpty()) {
                $approvedTransfers->where(function ($query) use ($authority_maps) {
                    foreach ($authority_maps as $map) {
                        if (is_null($map->office_id) && is_null($map->district_id)) {
                            break;
                        }
                        $query->orWhere(function ($subQuery) use ($map) {
                            if ($map->office_id && is_null($map->district_id)) {
                                $subQuery->where('employee_employment.office_id', $map->office_id)
                                    ->orWhere('target_employee_employment.office_id', $map->office_id);
                            } elseif ($map->district_id && is_null($map->office_id)) {
                                $subQuery->where('employee_employment.district_id', $map->district_id)
                                    ->orWhere('target_employee_employment.district_id', $map->district_id);
                            } elseif ($map->office_id && $map->district_id) {
                                $subQuery->where(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('employee_employment.office_id', $map->office_id)
                                        ->where('employee_employment.district_id', $map->district_id);
                                })->orWhere(function ($nestedQuery) use ($map) {
                                    $nestedQuery->where('target_employee_employment.office_id', $map->office_id)
                                        ->where('target_employee_employment.district_id', $map->district_id);
                                });
                            }
                        });
                    }
                });
            }

            $approvedTransfers = $approvedTransfers
                ->select(
                    'employee.full_name as employee_name',
                    'target_employee.full_name as target_employee_name',
                    'transafers.id as id',
                    'transafers.transfer_ref_code',
                    'transafers.updated_at',
                    'transafers.final_approval'
                )
                ->orderBy('transafers.updated_at', 'desc')
                ->get();
            $department_user_id = appointing_authorities::where('department', $user->department)->pluck('id')->toArray();
            $dept_count = AllLoginModel::whereIn('user_id', $department_user_id)->where('role_id', 7)->where('user_type', 2)->count();

            return compact('approvedTransfers', 'rejectedTransfers', 'allTransfers', 'pendingTransfers', 'dept_count');
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }

    public function role_change_index()
    {
        if (Session::has('authority_phone') && Session::has('authority_password')) {
            $verifier = appointing_authorities::where('phone', Session::get('authority_phone'))->first();
            $user = AllLoginModel::where('user_id', $verifier->id)->where('user_type', 2)->first();
            if (Hash::check(Session::get('authority_password'), $user->password)) {
                $role_ids = AllLoginModel::where('user_id', $verifier->id)->pluck('role_id')->toArray();
                $roles = RolesModel::whereIn('id', $role_ids)->get();
                return view('verification.switch_role')->with(['roles' => $roles]);
            } else {
                return redirect()->route('verification-login');
            }
        } else {
            return redirect()->route('verification-login');
        }
    }

    public function switch_role($role_id = null)
    {
        // dd('here');
        // auth-check switch
        if (Auth::guard('user_guard')->check()) {
            $id = Auth::guard('user_guard')->user()->role_id;
            // if ($id != 2 && $id != 7) {
            //     return redirect()->back();
            // }

            try {
                $role_id = Crypt::decryptString($role_id);
                $user_id = AllLoginModel::where('user_id', Auth::guard('user_guard')->user()->user_id)->where('role_id', $role_id)->where('user_type', '=', 2)->value('id');
                if ($user_id) {

                    Auth::guard('user_guard')->logout();
                    Auth::guard('user_guard')->loginUsingId($user_id);
                    $user = Auth::guard('user_guard')->user();
                    $roleName = '';
                    if ($user) {
                        $roleName = $user->roles->role;
                    }

                    if ($roleName == 'Approver') {
                        return redirect()->route('verifier.dashboard', ['lang' => app()->getLocale()]);
                    } elseif ($roleName == 'Verifier' || $roleName == 'Appointing Authority' || $roleName == 'Appointing User') {
                        return redirect()->route('verifier.dashboard', ['lang' => app()->getLocale()]);
                    } elseif ($roleName == 'Department Hod') {

                        return redirect()->route('verification.department.index', ['lang' => app()->getLocale()]);
                    }
                } else {
                    return redirect()->back();
                }
            } catch (Exception $err) {
                dd($err->getMessage());
            }
        }
        // session-check switch for initial switch
        if (Session::has('authority_phone') && Session::has('authority_password')) {
            $role_id = Crypt::decryptString($role_id);
            $verifier = appointing_authorities::where('phone', Session::get('authority_phone'))->first();
            $user = AllLoginModel::where('user_id', $verifier->id)->where('user_type', 2)->where('role_id', $role_id)->first();
            if (Hash::check(Session::get('authority_password'), $user->password)) {
                $attemp_data = [
                    "id" => $user->id, // user ID for authentication
                    'password' => Session::get('authority_password'),
                ];
                Session::forget(['authority_phone', 'authority_password']);
                if (Auth::guard('user_guard')->attempt($attemp_data)) {
                    $user = Auth::guard('user_guard')->user();
                    $roleName = '';
                    if ($user) {
                        $roleName = $user->roles->role;
                    }
                    if ($roleName == 'Approver') {
                        return redirect()->route('verification.approver.dashboard');
                    } elseif ($roleName == 'Verifier' || $roleName == 'Appointing Authority' || $roleName == 'Appointing User') {
                        return redirect()->route('verifier.dashboard');
                    }
                } else {
                    dd('Something went wrong');
                }
            } else {
                return redirect()->route('verification-login');
            }
        } else {
            return redirect()->route('verification-login');
        }
    }



    public function approver_profile_details($lang = null, $id = null, $status = null)
    {
        try {
            $switch_user_id = Auth::guard('user_guard')->user()->id;
            $switch_role = RolesModel::where('role', 'Approver')->first();
            if ($switch_role == null) {
                return redirect()->back();
            }
            $switch_status = self::auth_role_change($switch_role->id, $switch_user_id, Auth::guard('user_guard')->user()->user_id);
            if ($switch_status != false) {
                $id = Crypt::decryptString($id);
                $pendingTransfers = TransfersModel::where('id', $id)->first();
                $dept = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
                $department_user_id = appointing_authorities::where('department', $dept->department)->pluck('id')->toArray();
                $dept_count = AllLoginModel::whereIn('user_id', $department_user_id)->where('role_id', 7)->where('user_type', 2)->count();

                // for employee
                $conditions = [
                    ['id', $pendingTransfers->employee_id],
                ];
                $query = EmployeeModule::getEmployeesAllData($conditions);
                $data = $query->get();

                $docs = VerificationRemarksDocumentModel::where('user_id', $pendingTransfers->employee_id)->get();
                if ($docs->isEmpty()) {
                    $docs = [];
                }
                $docPaths = [];
                foreach ($docs as $d) {
                    $docPaths[] = [
                        'document_location' => $d->document_location,
                        'remarks' => $d->remarks,
                    ];
                }
                // for target employee
                $conditions2 = [
                    ['id', $pendingTransfers->target_employee_id],
                ];
                $query2 = EmployeeModule::getEmployeesAllData($conditions2);
                $data2 = $query2->get();

                $docs2 = VerificationRemarksDocumentModel::where('user_id', $pendingTransfers->target_employee_id)->get();
                if ($docs2->isEmpty()) {
                    $docs2 = [];
                }
                $docPaths2 = [];
                foreach ($docs2 as $d) {
                    // $docPaths2[] = $d->document_location;
                    $docPaths2[] = [
                        'document_location' => $d->document_location,
                        'remarks' => $d->remarks,
                    ];
                }
                if (count($data) == 0 || count($data2) == 0) {
                    dd("No Data found ");
                }

                if ($data[0]->verified_by != null) {
                    $verified_by = appointing_authorities::where('id', $data[0]->verified_by)->first();
                    $verified_on = $data2[0]->verified_on;
                    if ($verified_by != null) {
                        $department_name = departments::where('id', $verified_by->department)->pluck('name')->first();
                        if ($verified_by->office != null && ($data2[0]->employment_details->office_id == $verified_by->office)) {
                            $office_name = OfficeFinAsssamModel::where('id', $verified_by->office)->pluck('name')->first();
                        } else {
                            $office_name = null;
                        }
                    } else {
                        $verified_by = [];
                        $verified_on = [];
                        $department_name = null;
                        $office_name = null;
                    }
                } else {
                    $verified_by = [];
                    $verified_on = [];
                    $department_name = null;
                    $office_name = null;
                }

                if ($data[0]->noc_generated_by != null) {
                    $noc_generated_by = appointing_authorities::where('id', $data[0]->noc_generated_by)->first();
                    $noc_generated_on = $data2[0]->noc_generated_on;
                    if ($noc_generated_by != null) {
                        $noc_department_name = departments::where('id', $noc_generated_by->department)->pluck('name')->first();
                        if ($noc_generated_by->office != null && ($data2[0]->employment_details->office_id == $noc_generated_by->office)) {
                            $noc_office_name = OfficeFinAsssamModel::where('id', $noc_generated_by->office)->pluck('name')->first();
                        } else {
                            $noc_office_name = null;
                        }
                    } else {
                        $noc_generated_by = [];
                        $noc_generated_on = [];
                        $noc_department_name = null;
                        $noc_office_name = null;
                    }
                } else {
                    $noc_generated_by = [];
                    $noc_generated_on = [];
                    $noc_department_name = null;
                    $noc_office_name = null;
                }

                $jto_status = $pendingTransfers->jto_generate_status;
                $approved_on = $pendingTransfers->approved_on;
                $approver_remarks = $pendingTransfers->approver_remarks;


                $second_recommend_status = $pendingTransfers->{'2nd_recommend'};
                $second_recommended_by = $pendingTransfers->{'2nd_recommended_by'};


                // TransfersModel::where('employee_id', )

                if ($second_recommended_by != null && $second_recommend_status != 2) {
                    $ar = appointing_authorities::where('id',  $second_recommended_by)->first();
                    if ($ar != null) {
                        $sr_department_name = departments::where('id', $ar->department)->pluck('name')->first();
                        if ($ar->office != null && ($data2[0]->employment_details->office_id == $ar->office)) {
                            $sr_office_name = OfficeFinAsssamModel::where('id', $ar->office)->pluck('name')->first();
                        } else {
                            $sr_office_name = null;
                        }
                    } else {
                        $ar = null;
                        $sr_department_name = null;
                        $sr_office_name = null;
                    }
                } else {
                    $ar = null;
                    $sr_department_name = null;
                    $sr_office_name = null;
                }
                $second_recommend_remark = $pendingTransfers->{'2nd_recommend_remarks'};

                $approved_by = $pendingTransfers->{'approved_by'};
                $final_approval_status = $pendingTransfers->{'final_approval'};
                if ($approved_by != null && $final_approval_status == 1) {
                    $appr_by = appointing_authorities::where('id',  $approved_by)->first();
                    $approved_on = $pendingTransfers->{'approved_on'};
                    if ($appr_by != null) {
                        $approver_department_name = departments::where('id', $appr_by->department)->pluck('name')->first();
                        if ($appr_by->office != null && ($data2[0]->employment_details->office_id == $appr_by->office)) {
                            $approver_office_name = OfficeFinAsssamModel::where('id', $appr_by->office)->pluck('name')->first();
                        } else {
                            $approver_office_name = null;
                        }
                    } else {
                        $appr_by = null;
                        $approved_on = null;
                        $approver_department_name = null;
                        $approver_office_name = null;
                    }
                } else {
                    $appr_by = null;
                    $approved_on = null;
                    $approver_department_name = null;
                    $approver_office_name = null;
                }
                return view('verification.district.profile-details')->with(['approver_department_name' => $approver_department_name, 'approver_office_name' => $approver_office_name, 'sr_office_name' => $sr_office_name, 'sr_department_name' => $sr_department_name, 'noc_department_name' => $noc_department_name, 'noc_office_name' => $noc_office_name, 'department_name' => $department_name, 'office_name' => $office_name, 'approved_by' => $appr_by, 'approved_on' => $approved_on, 'second_recommended_on' => $pendingTransfers->{'2nd_recommended_on'}, 'ar' => $ar, 'srr' => $second_recommend_remark,  'second_recommend_status' => $second_recommend_status, 'dept_count' => $dept_count, 'approver_remarks' => $approver_remarks, 'noc_generated_by' => $noc_generated_by, 'verified_by' => $verified_by, 'noc_generated_on' => $noc_generated_on, 'verified_on' => $verified_on, 'approval_status' => $pendingTransfers->final_approval, 'id' => $id, 'request_date' => \Carbon\Carbon::parse($pendingTransfers->updated_at)->format('d-m-Y'), 'request_number' => $pendingTransfers->transfer_ref_code, 'candidate1' => $data[0], 'candidate2' => $data2[0], 'id' => $id, 'candidate_1_doc' => $docPaths, 'candidate_2_doc' => $docPaths2, 'jto_status' => $jto_status]);
            } else {
                return redirect()->back();
            }
        } catch (Exception $err) {
            Log::error('error fetching profile. [Approval] : ' . $err->getMessage());
            // return redirect('/verifier/approval-dashboard');
            return redirect()->back();
        }
    }

    public function final_approval(Request $request)
    {
        if (Auth::guard('user_guard')->check()) {
            try {
                $id = Crypt::decryptString($request->input('id'));
                $transfer = TransfersModel::findOrFail($id);
                $c1 = UserCredentialsModel::where('id', $transfer->employee_id)->first();
                $c2 = UserCredentialsModel::where('id', $transfer->target_employee_id)->first();

                $transfer->update([
                    'final_approval' => 1,
                    'approver_remarks' => $request->input('verifier_remarks') != null ? $request->input('verifier_remarks') : null,
                    'approved_by' => Auth::guard('user_guard')->user()->user_id,
                    '2nd_recommend' => 1,
                    'approved_on' => Carbon::now()
                ]);

                ReuseModule::sendFinalApprovalOTP($c1->phone);
                ReuseModule::sendFinalApprovalOTP($c2->phone);
                session()->flash('flash_message', 1);
                session()->flash('message', 'Candidate Approved');
                // return redirect('/verifier/approval-dashboard');
                return redirect()->back();
            } catch (Exception $err) {
                Log::error('error_approval: ' . $err->getMessage());
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function reject_approval(Request $request)
    {
        if (Auth::guard('user_guard')->check()) {
            try {
                $id = Crypt::decryptString($request->input('candidate_reject_id'));
                $transfer = TransfersModel::findOrFail($id);
                // $c1 = UserCredentialsModel::where('id', $transfer->employee_id)->first();
                // $c2 = UserCredentialsModel::where('id', $transfer->target_employee_id)->first();

                $transfer->update([
                    'final_approval' => 2,
                    'approver_remarks' => $request->input('reject_message') != null ? $request->input('reject_message') : null,
                    'approved_by' => Auth::guard('user_guard')->user()->user_id,
                    'approved_on' => Carbon::now()
                ]);

                // ReuseModule::sendFinalApprovalOTP($c1->phone);
                // ReuseModule::sendFinalApprovalOTP($c2->phone);
                session()->flash('flash_message', 1);
                session()->flash('message', 'Candidate Rejected');
                // return redirect('/verifier/approval-dashboard');
                return redirect()->route('verification.approval-all');
            } catch (Exception $err) {
                dd($err->getMessage());
                Log::error('error_approval: ' . $err->getMessage());
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function reject_second_recommendation(Request $request)
    {
        if (Auth::guard('user_guard')->check()) {
            try {
                $id = Crypt::decryptString($request->input('candidate_reject_id'));
                $transfer = TransfersModel::findOrFail($id);

                $transfer->update([
                    '2nd_recommend' => 2,
                    '2nd_recommend_remarks' => $request->input('reject_message') != null ? $request->input('reject_message') : null,
                    '2nd_recommended_by' => Auth::guard('user_guard')->user()->user_id,
                    // 'approved_on' => Carbon::now()
                    'final_approval' => 2,
                    'approved_by' => Auth::guard('user_guard')->user()->user_id,
                    'approver_remarks' => $request->input('reject_message') != null ? $request->input('reject_message') : null,
                ]);

                // ReuseModule::sendFinalApprovalOTP($c1->phone);
                // ReuseModule::sendFinalApprovalOTP($c2->phone);
                session()->flash('flash_message', 1);
                session()->flash('message', 'Candidate Rejected');
                // return redirect('/verifier/approval-dashboard');
                return redirect()->route('verification.approval-all', ['lang' => app()->getLocale()]);
            } catch (Exception $err) {
                dd($err->getMessage());
                Log::error('error_approval: ' . $err->getMessage());
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }


    public function approver_second_recommend(Request $request)
    {
        if (Auth::guard('user_guard')->check()) {
            try {
                $transfer_id = Crypt::decryptString($request->input('2nd_recommend_id'));
                $transfer_data = TransfersModel::where('id', $transfer_id)->first();
                $transfer_data->update([
                    '2nd_recommend' => 1,
                    '2nd_recommend_remarks' => $request->input('2nd_recommend_remarks') != null ? $request->input('2nd_recommend_remarks') : null,
                    '2nd_recommended_by' => Auth::guard('user_guard')->user()->user_id,
                    '2nd_recommended_on' => Carbon::now()
                ]);

                // ReuseModule::sendFinalApprovalOTP($c1->phone);
                // ReuseModule::sendFinalApprovalOTP($c2->phone);
                session()->flash('flash_message', 1);
                session()->flash('message', 'Candidate Recommended');
                // return redirect('/verifier/approval-dashboard');
                return redirect()->back();
            } catch (Exception $err) {
                return redirect()->back();
            }
        } else {
            return redirect()->route('verification-login');
        }
    }

    public function approval_all()
    {
        $switch_user_id = Auth::guard('user_guard')->user()->id;
        $switch_role = RolesModel::where('role', 'Approver')->first();
        $switch_status = VerificationController::auth_role_change($switch_role->id, $switch_user_id, Auth::guard('user_guard')->user()->user_id);
        if ($switch_status != false) {
            if (Auth::guard('user_guard')->check()) {
                $user = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();

                $district = DistrictModel::get(['id', 'name']);
                $department = departments::where('id', $user->department)->first();
                $office = OfficeFinAsssamModel::where('department_id', $department->id)->get(['id', 'name']);
                $posts = DepertPostsMapModel::when($user->department != null, function ($query) use ($user) {
                    return $query->where('dept_id', $user->department);
                })
                    ->join('post_names', 'depts_posts_map.post_id', '=', 'post_names.id')
                    ->select('post_names.name as post_name', 'post_names.id', 'depts_posts_map.grade_pay')
                    ->get();

                $department_user_id = appointing_authorities::where('department', $user->department)->pluck('id')->toArray();
                $dept_count = AllLoginModel::whereIn('user_id', $department_user_id)->where('role_id', 7)->where('user_type', 2)->count();
                return view('verification.district.search-profiles', compact('district', 'department', 'office', 'posts', 'dept_count'));
            } else {
                return redirect('/verifier/approval-dashboard');
            }
        } else {
            return redirect()->back();
        }
    }

    public function approver_fetch_candidates(Request $request)
    {
        if (Auth::guard('user_guard')->check()) {
            try {
                $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
                $type = '';
                if ($request->input('status') == 1) {
                    $data = TransfersModel::leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                        ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                        ->select('employee.full_name as employee_name', 'target_employee.full_name as target_employee_name', 'transafers.id as id')
                        ->orderBy('transafers.updated_at', 'desc')
                        ->where('request_status', 1)
                        ->get();
                    $type = 'approved';
                } elseif ($request->input('status') == 0) {
                    $data = TransfersModel::leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                        ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                        ->select('employee.full_name as employee_name', 'target_employee.full_name as target_employee_name', 'transafers.id as id')
                        ->orderBy('transafers.updated_at', 'desc')
                        ->where('request_status', 0)
                        ->get();
                    $type = 'pending';
                } else {
                    $data = TransfersModel::leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                        ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                        ->select('employee.full_name as employee_name', 'target_employee.full_name as target_employee_name', 'transafers.id as id')
                        ->orderBy('transafers.updated_at', 'desc')
                        ->where('request_status', 0)
                        ->get();
                    $type = 'pending';
                }

                $data = $data->map(function ($user) {
                    $user->encrypted_id = Crypt::encryptString($user->id);
                    return $user;
                });

                return response()->json([
                    'status' => 200,
                    'data' => $data,
                    'message' => "Successfully fetched " . $type . " candidate data",
                    'type' => $type
                ]);
            } catch (Exception $e) {
                Log::error('fetch approved candidate error: ' . $e->getMessage());
                return response()->json([
                    'status' => 500,
                    'data' => Null,
                    'message' => 'Server error'
                ]);
            }
        } else {
            return response()->json([
                'status' => 403,
                'data' => null,
                'message' => 'Unauthorized user'
            ]);
        }
    }

    public function logout()
    {
        // dd('here');
        try {
            $role = Auth::guard('user_guard')->user()->role_id;
            Auth::guard('user_guard')->logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->to(app()->getLocale() . '/authority-login');
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }


    public function forgot_password_index()
    {
        return view('verification.forgot_password_verification');
    }

    public function verificationLoginAPI(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $incoming_data = [
            'phone_or_email' => 'required',
            'password' => 'required'
        ];
        $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
        if ($validate->fails()) {
            $res_data['message'] = $validate->errors()->all();
        } else {
            $res_data['status'] = 401;
            try {
                $attemp_data = [
                    "phone" => $request->phone_or_email,
                    'password' => $request->password,
                    'user_type' => 2
                ];
                $verifier = appointing_authorities::where('phone', $request->input('phone_or_email'))->first();
                if ($verifier == null) {
                    $res_data['message'] = "Phone number not found !";
                    return response()->json(['res_data' => $res_data]);
                }
                // $user = AllLoginModel::where('user_id', $verifier->id)->where('user_type', 2)->where('role_id', '!=', 7)->first();
                $user = AllLoginModel::where('user_id', $verifier->id)->where('user_type', 2)->where('role_id', '!=', 1)->where('role_id', '!=', 4)->first();
                if ($user == null) {
                    $res_data['message'] = "User not found !";
                    return response()->json(['res_data' => $res_data]);
                }

                if ($verifier->first_login == 0) {
                    if (Hash::check($request->input('password'), $user->password)) {
                        Session::put('verifier_id', $verifier->id);
                        $res_data['first_login'] = $verifier->first_login;
                        $res_data['status'] = 200;
                    } else {
                        $res_data['message'] = "Credentials not found !";
                        return response()->json(['res_data' => $res_data]);
                    }
                } else {
                    $roles = AllLoginModel::where('user_id', $verifier->id)
                        ->where('user_type', 2)
                        ->pluck('role_id')
                        ->toArray();
                    $count_row = count($roles);
                    if ($count_row == 1 && in_array(7, $roles)) {
                        $department_dash = 1;
                    } else {
                        $department_dash = 0;
                    }

                    // if (in_array(2, $roles)) {
                    //     $department_dash = 1;
                    // }
                    // /////////////////////////////////////////////////////////////////////////////////
                    if (in_array(5, $roles) && in_array(6, $roles)) {
                        $attemp_data = [
                            "phone" => $request->phone_or_email,
                            'password' => $request->password,
                            'user_type' => 2,
                            'role_id' => 6
                        ];
                    }
                    if (in_array(3, $roles) && in_array(5, $roles)) {
                        $attemp_data = [
                            "phone" => $request->phone_or_email,
                            'password' => $request->password,
                            'user_type' => 2,
                            'role_id' => 5
                        ];
                    }
                    if (in_array(7, $roles) && in_array(2, $roles)) {
                        $attemp_data = [
                            "phone" => $request->phone_or_email,
                            'password' => $request->password,
                            'user_type' => 2,
                            'role_id' => 2
                        ];
                    }
                    if (in_array(7, $roles) && in_array(3, $roles)) {
                        $attemp_data = [
                            "phone" => $request->phone_or_email,
                            'password' => $request->password,
                            'user_type' => 2,
                            'role_id' => 3
                        ];
                    }


                    if (in_array(2, $roles)) {
                        $department_dash = 1;
                    }
                    // //////////////////////////////////////////////////////////////////////////////////
                    if (Auth::guard('user_guard')->attempt($attemp_data)) {
                        $user = Auth::guard('user_guard')->user();
                        $roleName = '';
                        if ($user) {
                            $roleName = $user->roles->role;
                        }
                        $res_data['role'] = $roleName;
                        $res_data['message'] = Auth::guard('user_guard')->user();
                        $first_login = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
                        $res_data['first_login'] = $first_login->first_login;
                        $res_data['status'] = 200;
                        $res_data['count_row'] = $count_row;
                        $res_data['department_dash'] = $department_dash;
                    } else {
                        $res_data['message'] = "Credentials not found !";
                    }
                }
            } catch (Exception $err) {
                Log::error('login verification: ' . $err->getMessage());
                $res_data['message'] = "Server error please try later !";
            }
        }
        return response()->json(['res_data' => $res_data]);
    }


    public function verificationDepartmentLoginAPI(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $incoming_data = [
            'user_name' => 'required',
            'password' => 'required'
        ];
        $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
        if ($validate->fails()) {
            $res_data['message'] = $validate->errors()->all();
        } else {
            $res_data['status'] = 401;
            try {
                $attemp_data = [
                    "phone" => $request->user_name,
                    'password' => $request->password,
                    'user_type' => 2
                ];
                $verifier = appointing_authorities::where('phone', $request->input('user_name'))->first();
                if ($verifier == null) {
                    $res_data['message'] = "Username number not found !";
                    return response()->json(['res_data' => $res_data]);
                }

                $user = AllLoginModel::where('user_id', $verifier->id)->where('user_type', 2)->where('role_id', 7)->first();
                if ($user == null) {
                    $res_data['message'] = "User not found !";
                    return response()->json(['res_data' => $res_data]);
                }

                if ($verifier->first_login == 0) {
                    if (Hash::check($request->input('password'), $user->password)) {
                        Session::put('verifier_id', $verifier->id);
                        $res_data['first_login'] = $verifier->first_login;
                        $res_data['status'] = 200;
                    } else {
                        $res_data['message'] = "Credentials not found !";
                        return response()->json(['res_data' => $res_data]);
                    }
                } else {
                    $roles = AllLoginModel::where('user_id', $verifier->id)
                        ->where('user_type', 2)
                        ->join('roles', 'all_login.role_id', '=', 'roles.id')
                        ->select('all_login.role_id', 'roles.role')
                        ->get();
                    $count_row = count($roles);
                    $roleData = [];
                    foreach ($roles as $role) {
                        $roleData[] = [
                            'role_id' => $role->role_id,
                            'role_name' => $role->role,
                        ];
                    }
                    $roleIds = array_column($roleData, 'role_id');

                    if (in_array(7, $roleIds)) {
                        if (Auth::guard('user_guard')->loginUsingId($user->id)) {
                            $user = Auth::guard('user_guard')->user();
                            $roleName = '';
                            if ($user) {
                                $roleName = $user->roles->role;
                            }
                            $res_data['role'] = $roleName;
                            $res_data['message'] = Auth::guard('user_guard')->user();
                            $first_login = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
                            $res_data['first_login'] = $first_login->first_login;
                            $res_data['status'] = 200;
                            $res_data['count_row'] = $count_row;
                        } else {
                            $res_data['message'] = "Credentials not found !";
                        }
                    } else {
                        $res_data['message'] = "Credentials not found !";
                    }
                }
            } catch (Exception $err) {
                Log::error('login verification: ' . $err->getMessage());
                $res_data['message'] = "Server error please try later !";
            }
        }
        return response()->json(['res_data' => $res_data]);
    }





    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function candidate_verify_index(Request $request, $lang = null, $type = null)
    {
        $switch_user_id = Auth::guard('user_guard')->user()->id;
        if ($type == null) {
            return redirect()->back();
        } else {
            try {
                $type = Crypt::decryptString($type);
            } catch (Exception $err) {
                return redirect()->back();
            }
        }
        $switch_role = RolesModel::where('role', $type)->first();
        if ($switch_role == null) {
            return redirect()->back();
        }
        $switch_status = self::auth_role_change($switch_role->id, $switch_user_id, Auth::guard('user_guard')->user()->user_id);
        if ($switch_status != false) {
            if (Session::has('is_appointing_user')) {
                Session::forget('is_appointing_user');
                Session::put('is_appointing_user_reversed', true);
            }

            $id = Auth::guard('user_guard')->user()->user_id;
            $userD = appointing_authorities::where('id', $id)->first();
            if (Auth::guard('user_guard')->check()) {
                $user = Auth::guard('user_guard')->user();

                // $authority_maps2 = authority_office_dist_map::where('user_id', $id)
                //     ->when(Auth::guard('user_guard')->user()->roles->role != 'Approver', function ($query) {
                //         return $query->where('role_id', Auth::guard('user_guard')->user()->role_id)
                //             ->distinct()
                //             ->pluck('office_id')
                //             ->toArray();
                //     })
                //     ->when(Auth::guard('user_guard')->user()->roles->role == 'Approver', function ($query) {
                //         return collect([null]);
                //     });
                // $authority_maps3 = authority_office_dist_map::where('user_id', $id)
                //     ->when(Auth::guard('user_guard')->user()->roles->role != 'Approver', function ($query) {
                //         return $query->where('role_id', Auth::guard('user_guard')->user()->role_id)
                //             ->distinct()
                //             ->pluck('district_id')
                //             ->toArray();
                //     })
                //     ->when(Auth::guard('user_guard')->user()->roles->role == 'Approver', function ($query) {
                //         return collect([null]);
                //     });
                $roleName = '';
                if ($user) {
                    $roleName = $user->roles->role;
                }

                // if ($authority_maps2->contains(null)) {
                //     $district = DistrictModel::join('office_dist_dept_map', 'office_dist_dept_map.depertment_id', '=', 'appointing_authority.department')->where('appointing_authority.id', $userD->id)->distinct('districts.name')->get();
                //     $office = OfficeFinAsssamModel::join('office_dist_dept_map', 'office_dist_dept_map.depertment_id', '=', 'appointing_authority.department')->where('appointing_authority.id', $userD->id)->distinct('offices_finassam.name')->get();
                // } else {
                //     $office = OfficeFinAsssamModel::join('office_dist_dept_map', 'office_dist_dept_map.depertment_id', '=', 'appointing_authority.department')->where('appointing_authority.id', $userD->id)->whereIn('id', $authority_maps2)->distinct('offices_finassam.name')->get();

                //     $district = DistrictModel::join('office_dist_dept_map', 'office_dist_dept_map.depertment_id', '=', 'appointing_authority.department')->where('appointing_authority.id', $userD->id)->whereIn('id', $authority_maps3)->distinct('districts.name')->get();
                // }

                if ($roleName == 'Appointing Authority' || 'Verifier') {
                    $office = OfficeFinAsssamModel::where('department_id', $userD->department)->when($userD->district !== null, function ($query) use ($userD) {
                        return $query->where('district_id', $userD->district);
                    })->get();
                    if ($userD->district == null) {
                        $district = DistrictModel::all();
                    } else {
                        $district  = [];
                    }
                } else {
                    $office = OfficeFinAsssamModel::where('department_id', $userD->department)->where('district_id', $userD->district)->get();
                }

                $posts = DepertPostsMapModel::when($userD->department != null, function ($query) use ($userD) {
                    return $query->where('dept_id', $userD->department);
                })
                    ->join('post_names', 'depts_posts_map.post_id', '=', 'post_names.id')
                    ->select('post_names.name as post_name', 'post_names.id', 'depts_posts_map.grade_pay')
                    ->get();
                return view('verification.pages.search-profiles')->with(['office' => $office, 'district' => $district, 'posts' => $posts]);
            } else {

                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public static function auth_role_change($role_id = null, $authenticated_id = null, $user_id = null)
    {
        try {
            if (Auth::guard('user_guard')->user()->id == $authenticated_id) {
                $user = AllLoginModel::where('user_id', $user_id)->where('role_id', $role_id)->where('user_type', '=', 2)->first();
                if ($user == null) {
                    return false;
                }
                Auth::guard('user_guard')->logout();
                // Session::flush();
                $attemp_data = [
                    "id" => $user->id,
                    'password' => $user->password,
                ];
                if (Auth::guard('user_guard')->loginUsingId($user->id)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $err) {
            return false;
        }
    }

    public function otp_index()
    {
        if (Session::has('verifier_id')) {
            $verifier = appointing_authorities::where('id', Session::get('verifier_id'))->first();
        } else {
            if (Auth::guard('user_guard')->check()) {
                $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            } else {
                return redirect()->back();
            }
        }

        if (Auth::guard('user_guard')->check() == true) {
            if (Auth::guard('user_guard')->user()->role_id == 7) {
                $this->department_pin_index();
            }
        }

        $otp = rand(100000, 999999);
        date_default_timezone_set('Asia/Kolkata');
        $send_time = date('Y-m-d H:i:s');
        verification_otp::updateOrInsert(
            ['phone' => $verifier->phone],
            [
                'OTP' => $otp,
                'expire_time' => $send_time,
                'is_used' => 0
            ]
        );
        $phone = $verifier->phone;
        $maskedPhone = substr($phone, 0, 4) . '*****' . substr($phone, -3);
        return view('verification.set_new_password_verification')->with(['phone' =>  $maskedPhone]);
    }





    // verfify otp
    public function verify_otp(Request $request)
    {
        $incoming_data = [
            'otp' => 'required',
        ];
        $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
        if ($validate->fails()) {
            $res_data['status'] = 422;
            $res_data['message'] = $validate->errors()->all();
        } else {
            if (Session::has('verifier_id')) {
                $verifier = appointing_authorities::where('id', Session::get('verifier_id'))->first();
            } else {
                if (Auth::guard('user_guard')->check()) {
                    $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
                } else {
                    return redirect()->back();
                }
            }
            try {
                if ($verifier == null) {
                    $res_data['message'] = "No users found";
                    return response()->json(['res_data' => $res_data]);
                }
                $res_data['status'] = 401;
                $otp_details = verification_otp::where('phone', $verifier->phone)->orderBy('updated_at', 'desc')->first();

                if ($otp_details) {
                    date_default_timezone_set('Asia/Kolkata');
                    $expire_time = $otp_details->expire_time;
                    $recive_time = date('Y-m-d H:i:s');
                    $new_expire_time = new DateTime($expire_time);
                    $time_diff = $new_expire_time->diff(new DateTime($recive_time));
                    if ($otp_details->is_used == 0) {
                        if ($otp_details->otp == $request->input('otp')) {
                            $otp_details->update(['is_used' => 1]);
                            $res_data['status'] = 200;
                            $res_data['message'] = 'PIN verified';
                        } else {
                            $res_data['message'] = "PIN is not correct !";
                        }
                    } else {
                        $res_data['status'] = 410;
                        $res_data['message'] = "PIN is expired .";
                    }
                } else {
                    $res_data['status'] = 403;
                    $res_data['message'] = "Username does not exists verification !";
                }
            } catch (Exception $err) {
                $res_data['status'] = 500;
                $res_data['message'] = "Server error please try later !";
            }
        }
        return response()->json(['res_data' => $res_data]);
    }


    // generate new password
    public function new_password(Request $request)
    {
        if (Session::has('verifier_id')) {
            $verifier = appointing_authorities::where('id', Session::get('verifier_id'))->first();
        } else {
            if (Auth::guard('user_guard')->check()) {
                $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            } else {
                return redirect()->back();
            }
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'otp' => 'required'
        ]);
        if ($validator->fails()) {
            $res_data['status'] = 401;
            $res_data['message'] = $validator->errors()->all();
            return response()->json(['res_data' => $res_data]);
        } else {
            if ($verifier == null) {
                $res_data['status'] = 404;
                $res_data['message'] = "No users found";
                return response()->json(['res_data' => $res_data]);
            }

            $all_logins = AllLoginModel::where('user_id', $verifier->id)->where('user_type', 2)->get();

            $otp_details = verification_otp::where('phone', $verifier->phone)->orderBy('updated_at', 'desc')->first();
            if ($otp_details->otp != $request->input('otp') && $otp_details->is_used == 0) {
                $res_data['message'] = 'otp mismatch/suspicious activity';
                $res_data['status'] = 500;
                return response()->json(['res_data' => $res_data]);
            }
            foreach ($all_logins as $all) {
                $AllLoginModel = AllLoginModel::where('id', $all->id)->first();
                $AllLoginModel->update([
                    'password' => Hash::make($request->input('password'))
                ]);
            }
            // $all_logins->update([
            //     'password' => Hash::make($request->input('password'))
            // ]);
            $verifier->update(['first_login' => 1]);
            $attemp_data = [
                "phone" => $verifier->phone,
                'password' => $request->input('password')
            ];
            if (Auth::guard('user_guard')->attempt($attemp_data)) {
                $user = Auth::guard('user_guard')->user();
                $roleName = '';
                if ($user) {
                    $roleName = $user->roles->role;
                }
                $res_data['message'] = 'Password successfully updated';
                $res_data['status'] = 200;
                $res_data['role'] = $roleName;
                return response()->json(['res_data' => $res_data]);
            } else {
                $res_data['message'] = "Credentials not found !";
            }
        }
    }

    public function forgot_password_check(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|min:10',
            ]);
            if ($validator->fails()) {
                $res_data['status'] = 401;
                $res_data['message'] = $validator->errors()->all();
                return response()->json(['res_data' => $res_data]);
            } else {
                $verifier = AllLoginModel::where('phone', $request->input('phone'))->first();
                $user = appointing_authorities::where('id', $verifier->user_id)->first();
                if ($verifier == null) {
                    $res_data['status'] = 404;
                    $res_data['message'] = 'No user found';
                    return response()->json(['res_data' => $res_data]);
                } else {
                    $res_data['status'] = 200;
                    $res_data['message'] = 'Success';
                    Session::put('phone', $verifier->phone);
                    Session::put('verifier_id', $user->id);
                    return response()->json(['res_data' => $res_data]);
                }
            }
        } catch (Exception $e) {
            $res_data['status'] = 500;
            $res_data['message'] = $e->getMessage();
            return response()->json(['res_data' => $res_data]);
        }
    }


    public function fetch_office_json(Request $request)
    {
        try {
            $user = Auth::guard('user_guard')->user();
            $roleName = '';
            if ($user) {
                $roleName = $user->roles->role;
            }
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            if ($request->has('district')) {
                $district = $request->input('district');
            } else {
                $district = null;
            }
            $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)->get();
            $office_ids = [];
            foreach ($authority_maps as $map) {
                if (is_null($map->office_id)) {
                    $office_ids = [];
                    break;
                }
                $office_ids[] = $map->office_id;
            }
            if ($district == null || $district == 'All') {
                if (empty($office_ids)) {
                    $mapped_office = OfficesDistDeptModel::where('depertment_id', $verifier->department)
                        ->with('office_fin_assam')
                        ->distinct()
                        ->get(['office_id']);
                    $office = $mapped_office;
                    return response()->json([
                        'status' => 200,
                        'data' => $office,
                        'message' => 'Office fetched successfully'
                    ]);
                } else {
                    $mapped_office = OfficesDistDeptModel::where('depertment_id', $verifier->department)
                        ->whereIn('office_id', $office_ids)
                        ->with('office_fin_assam')
                        ->distinct()
                        ->get(['office_id']);
                    $office = $mapped_office;
                    return response()->json([
                        'status' => 200,
                        'data' => $office,
                        'message' => 'Office fetched successfully'
                    ]);
                }
            } else {
                if (empty($office_ids)) {
                    $mapped_office = OfficesDistDeptModel::where('depertment_id', $verifier->department)->where('district_id', $district)
                        ->with('office_fin_assam')
                        ->with('districts')
                        ->distinct()
                        ->get(['office_id']);
                    $office = $mapped_office;
                    return response()->json([
                        'status' => 200,
                        'data' => $office,
                        'message' => 'Office fetched successfully'
                    ]);
                } else {
                    $mapped_office = OfficesDistDeptModel::where('depertment_id', $verifier->department)->where('district_id', $district)->whereIn('office_id', $office_ids)
                        ->with('office_fin_assam')
                        ->with('districts')
                        ->distinct()
                        ->get(['office_id']);
                    $office = $mapped_office;

                    return response()->json([
                        'status' => 200,
                        'data' => $office,
                        'message' => 'Office fetched successfully'
                    ]);
                }
            }
        } catch (Exception $err) {
            return response()->json([
                'status' => 500,
                'message' => $err->getMessage()
            ]);
        }
    }
}
