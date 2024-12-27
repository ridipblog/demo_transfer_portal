<?php

namespace App\Http\Controllers\root_access;

use App\Http\Controllers\Controller;
use App\Models\authority_office_dist_map;
use App\Models\department\departments;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\Public\RolesModel;
use App\Models\User_auth\AllLoginModel;
use App\Models\verification\appointing_authorities;
use App\our_modules\reuse_modules\ReuseModule;
use App\Rules\ValidatePhoneRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Public\OfficeFinAsssamModel;

class AuthoritiesController extends Controller
{
    // ---------------- get  offices by district and deperttment -------------
    public function getOfficesByDist(Request $request)
    {
        // dd('hehe');
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null,
                'offices' => ''
            ];
            try {
                $offices = OfficesDistDeptModel::query()
                    ->with(['office_fin_assam'])
                    ->where([
                        ['district_id', $request->input('district_id')],
                        ['depertment_id', $request->input('depertment_id')]
                    ]);
                $res_data['offices'] = $offices->get();
                // $res_data['status'] = 200;

                //         $officesss = OfficesDistDeptModel::query()
                //     ->with(['office_fin_assam', 'districts'])
                //     ->where('depertment_id', $request->input('depertment_id'))
                //     ->where('district_id', $request->input('district_id'))
                //     ->distinct('office_id')->pluck('office_id')->toArray();


                // $offices = OfficeFinAsssamModel::whereIn('id', $officesss)->get();
                //     //   dd($offices);  
                //         $res_data['offices'] = $offices;
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ---------------- get districts by offices --------------
    public function getDistrictByOffices(Request $request)
    {
        if ($request->ajax()) {
            $view_data = [
                'status' => 400,
                'message' => null,
                'related_districts' => ''
            ];
            try {
                $districts = OfficesDistDeptModel::query()
                    ->with(['office_fin_assam', 'districts'])
                    ->where('depertment_id', $request->input('depertment_id'))
                    ->whereIn('office_id', $request->input('offices'))
                    ->get();
                $view_data['related_districts'] = $districts;
                $view_data['status'] = 200;
            } catch (Exception $err) {
            }

            return view('verification.form.display_district', [
                'view_data' => $view_data
            ])->render();
        }
    }


    // ------------------------get directorate by department
    public function getDirectorateByDepartment(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null,
                'related_directorate' => ''
            ];
            try {
                $directorates = DB::table('directorate')->where('depertment_id', $request->input('department_id'))->pluck('name', 'id');
                $res_data['related_directorate'] = $directorates;
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }

            return response()->json(['res_data' => $res_data]);
        }
    }

    // ---------------- add new form of roles -----------------
    public function addNewForm(Request $request)
    {
        if ($request->ajax()) {
            $view_data = [
                'status' => 400,
                'districts' => null,
                'roles' => null,
                'total_assign_form' => $request->input('total_assign_form'),
                'count_assign_form' => $request->count_assign_form
            ];
            try {
                $view_data['roles'] = RolesModel::whereNotIn('id', [1, 4, 7])->get();
                $view_data['districts'] = DistrictModel::get();
                $view_data['departments'] = departments::pluck('name', 'id');
                $view_data['status'] = 200;
            } catch (Exception $err) {
            }
            return view('verification.form.assign_form', [
                'view_data' => $view_data
            ])->render();
        }
    }
    // ----------------- authority registration api -------------
    public function authorityRegistrationAPI(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            try {
                $incomming_data = [
                    'name' => 'required',
                    'phone_number' => ['required', 'integer', new ValidatePhoneRule(), 'unique:appointing_authorities,phone'],
                    'designation' => 'required',
                    'department' => 'required|integer',
                    'department' => ['array'],
                    'district' => ['array'],
                    'office' => ['array'],
                    'directorate' => ['array'],
                ];

                $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
                if ($validate->fails()) {
                    $res_data['message'] = $validate->errors()->all();
                } else {
                    $res_data['status'] = 401;
                    if (empty($request->role) && empty($request->common_role)) {
                        $res_data['message'] = "Select A Role";
                    } else {
                        if (($request->count_assign_form == 0) || ($request->count_assign_form == count($request->role ?? []) && !in_array(null, $request->role ?? []))) {
                            $res_data['status'] = 200;
                        } else {
                            $res_data['message'] = "Specify role properly !";
                        }
                    }
                }
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
                $res_data['message'] = $err->getMessage();
            }
            if ($res_data['status'] == 200) {
                try {
                    DB::beginTransaction();
                    $assign_forms = [];
                    $save_user = appointing_authorities::create([
                        'name' => $request->name,
                        'designation' => $request->designation,
                        'phone' => $request->phone_number,
                        'department' => $request->department[0],
                    ]);
                    $roles = $request->role;
                    if (!empty($request->role)) {
                        if ($request->common_role) {
                            array_push($roles, $request->common_role);
                        }
                        $minimiz_role = array_unique($roles);
                    } else {
                        $minimiz_role = [$request->common_role];
                    }
                    // $minimiz_role = array_unique(empty($roles) ? [$request->common_role] : array_push($roles,$request->common_role));
                    $all_logins = array_map(function ($role) use ($request, $save_user) {
                        return [
                            'user_id' => $save_user->id,
                            'user_type' => 2,
                            'phone' => $request->phone_number,
                            'password' => Hash::make('password'),
                            'role_id' => $role,
                        ];
                    }, $minimiz_role);
                    $save_logins = AllLoginModel::insert($all_logins);
                    if ($request->common_role) {
                        array_push($assign_forms, ['user_id' => $save_user->id, 'office_id' => null, 'directorate_id' => null, 'district_id' => null, 'department_id' => null, 'role_id' => $request->common_role, 'unique_key' => "null_null_{$request->common_role}"]);
                    }

                    if (count($request->role ?? []) != 0) {
                        foreach ($request->role as $key => $role) {
                            $new_form = [];
                            if (isset($request->office[$key])) {
                                foreach ($request->office[$key] as $office_id) {
                                    // array_push($assign_forms, ['user_id' => $save_user->id, 'office_id' => $office_id, 'district_id' => null, 'department_id' => $request->department, 'role_id' => $role,'unique_key'=>"{$office_id}_null_{$role}"]);
                                    $new_form = ['user_id' => $save_user->id, 'office_id' => $office_id, 'directorate_id' => isset($request->directorate[$key]) ? $request->directorate[$key] : 0, 'district_id' => null, 'department_id' => isset($request->department[$key]) ? $request->department[$key] : null, 'role_id' => $role, 'unique_key' => "{$office_id}_null_{$role}"];
                                    if (!in_array($new_form['unique_key'], array_map(function ($forms) {
                                        return $forms['unique_key'];
                                    }, $assign_forms))) {
                                        array_push($assign_forms, $new_form);
                                    }
                                }
                            } else {
                                if ($request->district[$key] != 'All') {
                                    // array_push($assign_forms, ['user_id' => $save_user->id, 'office_id' => null, 'district_id' => $request->district[$key], 'department_id' => $request->department, 'role_id' => $role,'unique_key'=>"null_{$request->district[$key]}_{$role}"]);
                                    $new_form = ['user_id' => $save_user->id, 'office_id' => null, 'directorate_id' => isset($request->directorate[$key]) ? $request->directorate[$key] : 0, 'district_id' => $request->district[$key], 'department_id' => isset($request->department[$key]) ? $request->department[$key] : null, 'role_id' => $role, 'unique_key' => "null_{$request->district[$key]}_{$role}"];
                                } else {
                                    // array_push($assign_forms, ['user_id' => $save_user->id, 'office_id' => null, 'district_id' => null, 'department_id' => $request->department, 'role_id' => $role,'unique_key'=>"null_null_{$role}"]);
                                    $new_form = ['user_id' => $save_user->id, 'office_id' => null, 'directorate_id' => isset($request->directorate[$key]) ? $request->directorate[$key] : 0, 'district_id' => null, 'department_id' => isset($request->department[$key]) ? $request->department[$key] : null, 'role_id' => $role, 'unique_key' => "null_null_{$role}"];
                                }
                                if (!in_array($new_form['unique_key'], array_map(function ($forms) {
                                    return $forms['unique_key'];
                                }, $assign_forms))) {
                                    array_push($assign_forms, $new_form);
                                }
                            }
                        }
                    }
                    foreach ($assign_forms as &$forms) {
                        unset($forms['unique_key']);
                    }
                    // dd($assign_forms);
                    // $filter_assign_forms=array_unique(array_map(function($forms){
                    //     return $forms['unique_key'];
                    // },$assign_forms));
                    // $final_assign_forms=[];
                    // foreach($assign_forms as $forms){
                    //     if(in_array($forms,$filter_assign_forms['unique_key'])){
                    //         array_push(form)
                    //     }
                    // }
                    $save_assign_mform = authority_office_dist_map::insert($assign_forms);
                    $res_data['assign_form'] = $assign_forms;
                    DB::commit();
                    $res_data['status'] = 200;
                    $res_data['message'] = "Registration sucessfull !";
                } catch (Exception $err) {
                    DB::rollBack();
                    $res_data['message'] = $err->getMessage();
                    $res_data['status'] = 401;
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ----------------- view assign data ---------------
    public function viewAssignData(Request $request)
    {
        if ($request->ajax()) {
            $view_data = [
                'status' => 400,
                'message' => null,
                'assign_data' => null
            ];
            try {
                $user_id = Crypt::decryptString($request->user_id);
                // $user_id = 50;

                $main_query = appointing_authorities::query();
                $main_query->where('id', $user_id);
                $depertment_id = $main_query->first()->department ?? null;
                $assign_data = null;
                if ($depertment_id) {
                    $assign_data = $main_query
                        ->with([
                            'authority_office_dist_map' => function ($query) use ($depertment_id) {
                                $query->with(['office_fin_assam' => function ($office_query) use ($depertment_id) {
                                    $office_query->with(['office_dist_dept_map' => function ($office_dis_dep_map_query) use ($depertment_id) {
                                        $office_dis_dep_map_query->where('depertment_id', $depertment_id);
                                        $office_dis_dep_map_query->with(['districts']);

                                        // $office_dis_dep_map_query->whereColumn('department', 'authority_office_dist_map.department_id');
                                    }]);
                                }]);
                            },
                            'authority_office_dist_map.districts',
                            'authority_office_dist_map.roles'
                        ])
                        ->first();
                }
                // dd($assign_data);
                $view_data['assign_data'] = $assign_data;
                $view_data['status'] = 200;
            } catch (Exception $err) {
                // dd($err->getMessage());
            }
            return view('verification.form.view_assign_data', [
                'view_data' => $view_data
            ])->render();
        }
    }
}