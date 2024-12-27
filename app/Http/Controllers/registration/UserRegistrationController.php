<?php

namespace App\Http\Controllers\registration;

use App\Http\Controllers\Controller;
use App\Models\authority_office_dist_map;
use App\Models\department\departments;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\Public\RolesModel;
use App\Models\User_auth\AllLoginModel;
use App\Models\verification\appointing_authorities;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserRegistrationController extends Controller
{
    public function index()
    {
        $roles = RolesModel::whereNotNull('display_name')->where('id', '!=', 4)->pluck('display_name', 'id');
        // $roles = RolesModel::whereNotNull('display_name')->pluck('display_name', 'id');
        $offices = OfficeFinAsssamModel::orderBy('created_at', 'asc')->pluck('name', 'id');
        $departments = departments::pluck('name', 'id');
        $districts = DistrictModel::pluck('name', 'id');
        $appointing_authorities = appointing_authorities::all();

        // Fetching registered users and grouping by phone number
        $registeredUsers = authority_office_dist_map::leftJoin('offices_finassam', 'authority_office_dist_maps.office_id', '=', 'offices_finassam.id')
            ->join('appointing_authorities', 'appointing_authorities.id', '=', 'authority_office_dist_maps.user_id')
            ->leftJoin('office_dist_dept_map', 'authority_office_dist_maps.office_id', '=', 'office_dist_dept_map.office_id')
            ->leftJoin('districts', 'authority_office_dist_maps.district_id', '=', 'districts.id')
            ->leftJoin('all_login', 'all_login.user_id', '=', 'authority_office_dist_maps.user_id')
            ->join('roles', 'roles.id', '=', 'all_login.role_id')
            ->leftJoin('deptartments', 'authority_office_dist_maps.department_id', '=', 'deptartments.id')
            ->select(
                'appointing_authorities.phone',
                DB::raw('GROUP_CONCAT(DISTINCT appointing_authorities.name ORDER BY appointing_authorities.name ASC SEPARATOR ", ") as names'),
                DB::raw('GROUP_CONCAT(DISTINCT appointing_authorities.designation ORDER BY appointing_authorities.designation ASC SEPARATOR ", ") as designations'),
                DB::raw('GROUP_CONCAT(DISTINCT offices_finassam.name ORDER BY offices_finassam.name ASC SEPARATOR ", ") as office_names'),
                DB::raw('GROUP_CONCAT(DISTINCT districts.name ORDER BY districts.name ASC SEPARATOR ", ") as district_names'),
                DB::raw('GROUP_CONCAT(DISTINCT deptartments.name ORDER BY deptartments.name ASC SEPARATOR ", ") as department_names'),
                DB::raw('GROUP_CONCAT(DISTINCT roles.display_name ORDER BY roles.role ASC SEPARATOR ", ") as role_names')
            )
            ->groupBy('appointing_authorities.phone') // Group by phone number
            ->get();
        // dd($registeredUsers);

        $all_roles = RolesModel::whereNotIn('id', [1, 4])->get();
        // $registered_users = appointing_authorities::join('all_login', 'all_login.user_id', '=', 'appointing_authorities.id')
        // ->where('all_login.user_type',2)
        // dd(AllLoginModel::where([['user_type',2],['user_id',97]])->get());
        $registered_users = appointing_authorities::query()->whereHas('all_logins', function ($query) {})
            ->with(['all_logins' => function ($query) {
                $query->where('user_type', 2)
                    ->select('id', 'user_id', 'user_type', 'role_id');
            }, 'all_logins.roles'])
            ->get();
        return view('verification.form.user_register', compact('registered_users', 'all_roles', 'roles', 'offices', 'departments', 'districts', 'registeredUsers'));
    }




    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:appointing_authorities,name',
                'phone_number' => 'required|digits:10',
                'designation' => 'required',
                'department' => 'required',
                'role' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $appointing_authority = new appointing_authorities();
            $all_login = new AllLoginModel();

            $id = $appointing_authority->create([
                'name' => $request->input('name'),
                'designation' => $request->input('designation'),
                'phone' => $request->input('phone_number'),
                'department' => $request->input('department'),
                'first_login' => 0,
            ]);

            $password = config('custom.appointing_authority_password');

            if ($request->has('role')) {
                foreach ($request->input('role') as $index => $value) {
                    $all_login->create([
                        'user_id' => $id->id,
                        'user_type' => 2,
                        'phone' => $request->input('phone_number'),
                        'password' => Hash::make($password),
                        'role_id' => $value,
                        'status' => 1
                    ]);
                }
            }
            $officeIds = $request->input('office');
            $districtIds = $request->input('district');

            foreach ($officeIds as $index => $officeId) {
                $officeIdToInsert = ($officeId === 'All') ? null : $officeId;
                if (isset($districtIds[$index]) && $districtIds[$index] === 'All' && $officeIdToInsert != null) {
                    $district_arr = OfficesDistDeptModel::where('office_id', $officeIdToInsert)->get();
                    foreach ($district_arr as $dd) {
                        authority_office_dist_map::create([
                            'user_id' => $id->id,
                            'office_id' => $officeIdToInsert,
                            'district_id' => $dd->district_id,
                            'department_id' => $request->input('department'),
                        ]);
                    }
                } elseif ($officeIdToInsert == null && isset($districtIds[$index]) && $districtIds[$index] != 'All') {
                    $office_arr = OfficesDistDeptModel::where('district_id', $districtIds[$index])->get();
                    foreach ($office_arr as $oo) {
                        authority_office_dist_map::create([
                            'user_id' => $id->id,
                            'office_id' => $oo->office_id,
                            'district_id' => $districtIds[$index],
                            'department_id' => $request->input('department'),
                        ]);
                    }
                } else {
                    $districtIdToInsert = isset($districtIds[$index]) && $districtIds[$index] === 'All' ? null : (isset($districtIds[$index]) ? $districtIds[$index] : null);
                    authority_office_dist_map::create([
                        'user_id' => $id->id,
                        'office_id' => $officeIdToInsert,
                        'district_id' => $districtIdToInsert,
                        'department_id' => $request->input('department'),
                    ]);
                }
            }

            return redirect()->route('register-user')->with('success', 'User registered successfully');
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }

    public function fetch_district(Request $request)
    {
        try {
            $office = $request->input('office_id');
            $fetched_offices = OfficesDistDeptModel::where('office_id', $office)->pluck('district_id')->toArray();
            $district = DistrictModel::whereIn('id', $fetched_offices)->get();
            // dd($district);
            return response()->json([
                'status' => 200,
                'data' => $district,
                'message' => 'Successfully fetched'
            ]);
        } catch (Exception $err) {
            // dd($err->getMessage());
            return response()->json([
                'status' => 500,
                'message' => $err->getMessage()
            ]);
        }
    }

    public function fetch_office(Request $request)
    {
        try {
            $district = $request->input('district_id');
            $fetched_offices = OfficesDistDeptModel::where('district_id', $district)->pluck('office_id')->toArray();
            $offices = OfficeFinAsssamModel::whereIn('id', $fetched_offices)->get();
            // dd($district);
            return response()->json([
                'status' => 200,
                'data' => $offices,
                'message' => 'Successfully fetched'
            ]);
        } catch (Exception $err) {
            // dd($err->getMessage());
            return response()->json([
                'status' => 500,
                'message' => $err->getMessage()
            ]);
        }
    }




    public function check_duplicates()
    {
        // Use chunking to avoid memory overload with a large dataset
        OfficeFinAsssamModel::chunk(100, function ($offices) {
            foreach ($offices as $office) {
                // Find duplicates where the name is the same but id is different
                $duplicates = OfficeFinAsssamModel::where('name', $office->name)
                    ->where('id', '!=', $office->id)
                    ->get();

                foreach ($duplicates as $duplicate) {
                    // Delete related entries in OfficesDistDeptModel first
                    OfficesDistDeptModel::where('office_id', $duplicate->id)->delete();

                    // Then delete the duplicate office
                    $duplicate->delete();
                }
            }
        });
        return 1;
    }


    public function assign_directorate_prev(Request $request)
    {
        $map_data = authority_office_dist_map::where('directorate_id', null)
            ->distinct('user_id')
            ->pluck('user_id')->toArray();
        $users = appointing_authorities::whereIn('id', $map_data)->get(['name', 'phone', 'id'])->toArray();
        // $map = OfficesDistDeptModel::whereIn('depertment_id', $dept)->where('directorate_id', '!=', null)->where('directorate_id', '!=', 0)->distinct('directorate_id')->pluck('directorate_id')->toArray();
        // $directorates = DB::table('directorate')->whereIn('depertment_id', $dept)->get(['name', 'id'])->toArray();
        // dd($directorates);
        return view('verification.form.old_form', compact('users'));
    }

    public function fetch_prev_user_data(Request $request)
    {
        try {
            $user_id = (int)$request->input('user_id');
            $map = authority_office_dist_map::where('user_id', $user_id)->distinct('department_id')->pluck('department_id')->toArray();

            $user_data = appointing_authorities::where('id', $user_id)->first();
            $departments = departments::whereIn('id', $map)->get(['id', 'name'])->toArray();

            return response()->json([
                'status' => 200,
                'data' => $user_data,
                'departments' => $departments
            ]);
        } catch (Exception $err) {
            return response()->json([
                'status' => 500,
                'data' => $err->getMessage(),
            ]);
        }
    }

    public function fetch_directorates(Request $request)
    {
        try {
            $directorates = DB::table('directorate')->where('depertment_id', (int)$request->input('department_id'))->get(['name', 'id'])->toArray();
            return response()->json([
                'status' => 200,
                'directorates' => $directorates
            ]);
        } catch (Exception $err) {
            return response()->json([
                'status' => 500
            ]);
        }
    }

    public function re_assign(Request $request)
    {
        try {
            // Validate the input data
            $validated = $request->validate([
                'user_ids' => 'required|exists:appointing_authorities,id',
                'department_ids' => 'required|exists:deptartments,id',
                'directorate_ids' => 'required'
            ]);

            $map = authority_office_dist_map::where('user_id', $request->input('user_ids'))
                ->where('department_id', $request->input('department_ids'))
                ->get();

            $directorate = ($request->input('directorate_ids') == 'na') ? 0 : $request->input('directorate_ids');

            foreach ($map as $m) {
                $m->update([
                    'directorate_id' => $directorate
                ]);
            }

            return redirect()->back()->with('success', 'Re-assignment completed successfully.');
        } catch (Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }



    public function correct_office_name()
    {
        // Use chunking to avoid memory overload with a large dataset
        OfficeFinAsssamModel::chunk(100, function ($offices) {
            foreach ($offices as $office) {
                // Check if the name has quotes at the start and end, and remove them
                if (substr($office->name, 0, 1) === '"' && substr($office->name, -1) === '"') {
                    $office->name = substr($office->name, 1, -1); // Remove the first and last character
                    $office->save(); // Update the database with the new name
                }
            }
        });

        return 1;
    }
}