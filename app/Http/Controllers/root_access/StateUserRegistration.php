<?php

namespace App\Http\Controllers\root_access;

use App\Http\Controllers\Controller;
use App\Models\authority_office_dist_map;
use App\Models\Public\DepertmentModel;
use App\Models\Public\RolesModel;
use App\Models\User_auth\AllLoginModel;
use App\Models\verification\appointing_authorities;
use App\our_modules\reuse_modules\ReuseModule;
use App\Rules\checkStateCredentialsRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StateUserRegistration extends Controller
{
    public function index(Request $request)
    {
        $view_data = [
            'departments' => null,
            'roles' => null,
            'registered_users' => null,
            'status' => 400
        ];
        try {
            $view_data['departments'] = DepertmentModel::orderBy('name', 'asc')->get();
            $main_query = appointing_authorities::query()
                ->with(['all_logins', 'authority_office_dist_map','authority_office_dist_map.new_deptartments'])
                ->wherehas('all_logins', function ($query) {
                    $query->with(['roles'])
                    ->where('role_id', 7);
                });
            $view_data['registered_users'] = $main_query->get();
        } catch (Exception $err) {
            dd($err->getMessage());
        }
        return view('verification.form.state_registration', [
            'view_data' => $view_data
        ]);
    }
    // ------------ register state user ---------------
    public function registerStateUser(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            try {
                $incomming_data = [
                    'name' => 'required',
                    'user_name' => ['required'],
                    'designation' => 'required',
                    'department' => ['required', 'array']
                ];
                $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
                if ($validate->fails()) {
                    $res_data['message'] = $validate->errors()->all();
                    $res_data['departments'] = $request->department;
                } else {
                    $res_data['status'] = 200;
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = $err->getMessage();
            }
            if ($res_data['status'] == 200) {
                $res_data['status'] = 401;
                try {
                    DB::beginTransaction();
                    $save_state = appointing_authorities::create([
                        'name' => $request->name,
                        'designation' => $request->designation,
                        'phone' => $request->user_name,
                        // 'department' => $request->department
                    ]);
                    $save_logins = AllLoginModel::create([
                        'user_id' => $save_state->id,
                        'user_type' => 2,
                        'phone' => $request->user_name,
                        'password' => Hash::make('password'),
                        'role_id' => 7
                    ]);
                    $maps=array_map(function($department) use($save_state){
                        return [
                            'user_id' => $save_state->id,
                            'department_id' => $department
                        ];
                    },$request->department);
                    authority_office_dist_map::insert($maps);
                    DB::commit();
                    $res_data['message'] = "State registration done ";
                    $res_data['status'] = 200;
                } catch (Exception $err) {
                    DB::rollBack();
                    $res_data['status'] = 401;
                    $res_data['message'] = $err->getMessage();
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
}
