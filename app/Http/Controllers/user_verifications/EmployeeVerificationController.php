<?php

namespace App\Http\Controllers\user_verifications;

use App\Http\Controllers\Controller;
use App\Models\User\EmploymentDetailsModel;
use App\Models\User_auth\UserCredentialsModel;
use App\Models\verification\VerificationRemarksDocumentModel;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EmployeeVerificationController extends Controller
{
    public function checkByVerifer(Request $request)
    {
        // if ($request->ajax()) {
        // }
        $res_data = [
            'status' => 400,
            'message' => null
        ];
        try {
            $logged_user = Auth::guard('user_guard')->user();
            $incomming_data = [
                'remarks_documents' => 'array',
                'remarks_text' => 'array',
                'employee_id' => 'required',
                'forms_number' => 'required|integer'
            ];
            $check_employee =
                $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
            if ($validate->fails()) {
                $res_data['message'] = $validate->errors()->all();
            } else {
                $res_data['status'] = 401;
                $employee_id = Crypt::decryptString($request->employee_id);
                $error_indexs = [];
                $file_extensions = [
                    'jpg',
                    'jpeg',
                    'png'
                ];

                // ---------------- if error show simply -----------------
                // if(count($request->remarks_documents ?? []) != count($request->remarks_text ?? [])){

                // }else{
                //     $res_data['message']="Ok";
                // }

                for ($i = 0; $i < $request->forms_number; $i++) {
                    // ------------ all field are require if form append --------------------
                    $temp_error = [
                        'document' => null,
                        'text' => null
                    ];
                    $check_document = false;
                    $check_text = false;
                    $temp_error['document'] = isset($request->file('remarks_documents')[$i]) ? (in_array($request->file('remarks_documents')[$i]->getClientOriginalExtension(), $file_extensions) ? $check_document = true : 'document extention type invalid !') : 'document is required';

                    $temp_error['text'] = isset($request->remarks_text[$i]) ? $check_text = true : 'remarks is required';
                    if (!$check_document || !$check_text) {
                        $error_indexs[] = $temp_error;
                    }
                    // ---------- all text field are require but not document --------------------
                    // if (isset($request->remarks_documents[$i]) ? (isset($request->remarks_text[$i]) ? true : false) : (isset($request->remarks_text[$i]) ? true : false)) {

                    // }else{

                    // }
                }
                if (count($error_indexs) == 0) {
                    $conditions = [
                        ['id', $employee_id],
                        ['profile_verify_status', 0]
                    ];
                    $with_models = [
                        'employment_details' => function ($query) {
                            $query->select('id', 'user_id', 'depertment_id', 'district_id');
                        },
                    ];
                    $main_query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, [], $with_models);
                    $main_query->whereHas('employment_details', function ($query) use ($logged_user) {
                        $query->where('district_id', $logged_user->appointing_authorities->district)
                            ->where('depertment_id', $logged_user->appointing_authorities->department);
                    });
                    $main_query->select('id', 'profile_verify_status');
                    if ($main_query->exists()) {
                        $res_data['status'] = 200;
                    } else {
                        $res_data['message'] = "Employee details not found !";
                    }
                } else {
                    $res_data['message'] = $error_indexs;
                }
            }
        } catch (Exception $err) {
            $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
        }
        if ($res_data['status'] == 200) {
            try {
                DB::beginTransaction();
                for ($i = 0; $i < $request->forms_number; $i++) {
                    // if(isset($request->file('remarks_documents')[$i])){
                    //     $photo_path = 'uploads/verification_remarks/' .$logged_user->appointing_authorities->id .'/'.$employee_id .'/';
                    //     $this->file_location = ReuseModule::uploadPhoto($request->remarks_documents[$i], $photo_path, $request->file($key)->getClientOriginalName());
                    // }
                    $save_data = VerificationRemarksDocumentModel::create([
                        'user_id' => $employee_id,
                        'document_location' => null,
                        'remarks' => $request->remarks_text[$i],
                        'remarks_by' => $logged_user->appointing_authorities->id

                    ]);
                }
                $update_data = UserCredentialsModel::where('id', $employee_id)
                    ->update([
                        'profile_verify_status' => 1,
                        'verified_by' => $logged_user->appointing_authorities->id,
                        'verified_remarks_status' => $request->forms_number > 0  ? 1 : 0,
                        'verified_remarks'=>$request->verifier_remarks
                    ]);
                DB::commit();
                $res_data['message'] = "Ok";
                $res_data['status'] = 200;
            } catch (Exception $err) {
                DB::rollBack();
                $res_data['message'] = "Server error please try later !";
                $res_data['status'] = 401;
            }
        }
        return response()->json(['res_data' => $res_data]);
    }
}
