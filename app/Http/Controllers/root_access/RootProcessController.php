<?php

namespace App\Http\Controllers\root_access;

use App\Http\Controllers\Controller;
use App\Models\Public\DepertmentModel;
use App\Models\Public\DirectorateModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\verification\appointing_authorities;
use App\our_modules\reuse_modules\ReuseModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RootProcessController extends Controller
{
    public function sendMesssageToAuthrities(Request $request)
    {
        try {
            $authrities = appointing_authorities::where('phone', 'REGEXP', '^[0-9]+$')->get()->pluck('phone');
            $numbers = [];
            dd("No Used");
            foreach ($authrities as $auth) {
                ReuseModule::sendInfoAuthritesMes($auth);
                $new_array[] = $auth;
                Storage::disk('local')->put('phone_nunbers.json', json_encode($new_array, JSON_PRETTY_PRINT));
            }
            $data = Storage::disk('local')->get('phone_nunbers.json');
            $phone_numbers = json_decode($data, true);
            dd($phone_numbers);
        } catch (Exception $err) {
            dd("Server error please try later ");
        }
    }
    // ----------- assign directorate to offices ----------
    public function assignDirectorateOfficesIndex(Request $request)
    {
        $view_data = [
            'is_error' => true,
        ];
        try {
            $view_data['districts'] = DistrictModel::get();
            $view_data['depertments'] = DepertmentModel::get();
            $main_query=OfficesDistDeptModel::with(['office_fin_assam','deptartments','districts','directorate'])
            ->where('directorate_id','<>',NULL)->get();
            $view_data['map_data']=$main_query;
            $view_data['is_error'] = false;
        } catch (Exception $err) {
            $view_data['message'] = "Server error please try later !";
        }
        return view('assign_directorate', [
            'view_data' => $view_data
        ]);
    }
    public function assignDirectorateOffices(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            $incomming_data = [
                'district' => 'required',
                'depertment' => 'required',
                'directorate_id' => 'required',
                'office' => 'required'
            ];
            $validator = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
            if ($validator->fails()) {
                $res_data['message'] = $validator->errors()->all();
            } else {
                $res_data['status']=401;
                try {
                    $main_query = OfficesDistDeptModel::where('depertment_id', $request->depertment);
                    if ($request->district != 'all') {
                        $main_query->where('district_id', $request->district);
                    }
                    if (!in_array('all', $request->office)) {
                        $main_query->whereIn('office_id', $request->office);
                    }
                    $main_query->update([
                        'directorate_id' => $request->directorate_id
                    ]);
                    $res_data['message'] = "Succesfully assigned directorate to offices  ";
                    $res_data['status'] = 200;
                } catch (Exception $err) {
                    $res_data['message'] = "Server error please try later !";
                    $res_data['message'] = $err->getMessage();
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    public function addDrectorateIndex(Request $request)
    {
        $view_data = [
            'is_error' => true,
        ];
        try {
            $view_data['depertments'] = DepertmentModel::get();
            $view_data['directorates'] = DirectorateModel::query('deptartments')->get();
            $view_data['is_error'] = false;
        } catch (Exception $err) {
            $view_data['message'] = "Server error please try later !";
        }
        return view('add_directorate', [
            'view_data' => $view_data
        ]);
    }
    // ------------- add diretorate post ------------------
    public function addDrectorate(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        if ($request->department_id && $request->directorate) {
            try {
                DirectorateModel::create([
                    'name' => $request->directorate,
                    'depertment_id' => $request->department_id
                ]);
                $res_data['message'] = "Directorate Added Successfully !";
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
                $res_data['message'] = $err->getMessage();
            }
        } else {
            $res_data['message'] = "Please fill required fields";
        }
        return response()->json(['res_data' => $res_data]);
    }
    // ------------ fetch directorate and depertment ---------------
    public function fetchDirectDept(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        if ($request->depertment_id) {
            try {
                $res_data['directorates'] = DirectorateModel::with(['deptartments'])
                    ->where('depertment_id', $request->depertment_id)->get();
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
                $res_data['message'] = $err->getMessage();
            }
        } else {
        }
        return response()->json(['res_data' => $res_data]);
    }
}
