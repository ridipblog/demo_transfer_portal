<?php

namespace  App\our_modules\reuse_modules;

use App\Models\Public\OfficesDistDeptModel;
use App\Models\verification\appointing_authorities;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReuseModule
{
    // -------------- get all data from model ---------------
    public static function getAllData($model, $conditions = null)
    {
        return $model::where($conditions)
            ->get();
    }
    // ----------------- get one data from model -----------------
    public static function getOneData($model, $conditions = null)
    {
        return $model::where($conditions)
            ->first();
    }
    // ------------------ update records --------------
    public static function updateRecords($model, $conditions, $update_data)
    {
        $model::where($conditions)
            ->update($update_data);
    }
    // ---------------- validate incomming data  ---------------
    public static function validateIncomingData($request, $request_field, $validate_type)
    {
        // App::setLocale(session::get('locale'));
        $error_message = [
            // 'required' => ':attribute '.__('validation_message.dynamic_validate_errors.required'),
            'required' => ':attribute is required field !',
            'integer' => ':attribute is only number format !',
            'regex' => 'phone number must be 10 digit ',
            'max' => ':attribute  size only 5 megabytes',
            'mimes' => ':attribute file type is not valid ',
            'email' => 'Please enter a valid email',
            'confirmed' => ':attribute is does not match with confirmation',
            'date' => ':attribute is date only ',
            'unique' => ':attribute is already exists ',
            'array' => ':attribute is array type',
            'required_if' => ':attribute is require field !',
            'exists' => ':attribute is not found in database !',
            'phone.exists' => 'phone number is not exists ,please register your number'
        ];
        $validate = Validator::make(
            $validate_type,
            $request_field,
            $error_message
        );
        return $validate;
    }
    // --------------- upload file -----------------
    public static function uploadPhoto($content, $path, $name = null, $form_where = 'request')
    {
        if ($form_where == 'session') {
            $fileContent = Session::get($content);
            $file_name = Str::uuid() . '_' . time() . Session::get($name);
            $location = $path . $file_name;
            $final_path = Storage::disk('public')->put($location, $fileContent);
            return $location;
        } else {
            $file_name = Str::uuid() . '_' . time() . $name;
            $location = $path . $file_name;
            $final_path = Storage::disk('public')->put($location, file_get_contents($content));
            return $location;
        }
    }

    // ----------------- fetch dynamic data ----------------
    public static function dynamicOneModelsQuery($model, $conditions = [], $related_models = null)
    {
        $main_query = $model::query();
        if ($related_models) {
            $main_query->with($related_models ? array_keys($related_models) : ['']);
            foreach ($related_models as $model_name => $condition) {
                $main_query->whereHas($model_name, function ($sub_query) use ($condition) {
                    $sub_query->where($condition);
                });
            }
        }
        $main_query->where($conditions);
        return $main_query;
    }
    // ------------------ verify pan number main govt web site ------------------
    public static function verifyPanNUmber($pan_number)
    {
        $view_data = [
            'pan_request_data' => null
        ];
        // dd(config('globalVariables.pan_retrive_api_key.api_key'));
        $response = Http::withHeaders([
            // 'Api-key' => env('PAN_RETRIVE_API'),
            'Api-Key' => config('globalVariables.pan_retrive_api_key.api_key'),
            'Accept' => 'application/json',
        ])->get('https://fin.assam.gov.in/assamfinanceservices/api/employeeDetails?type=1&pan=' . $pan_number);
        $view_data['pan_request_data'] = $response->json();
        if (isset($view_data['pan_request_data']['profile']['dob']) || isset($view_data['pan_request_data']['profile']['pan'])) {
            $dob = $view_data['pan_request_data']['profile']['dob'] ?? null;
            $view_data['pan_request_data']['profile']['dob'] = $dob ? Carbon::parse($dob)->format('Y-m-d') : null;
        }
        return $view_data['pan_request_data'];
    }
    public static function getOffices($dist_id = null, $dept_id = null)
    {
        $main_query = OfficesDistDeptModel::query();
        $main_query->with(['office_fin_assam'])
            ->where([
                ['district_id', $dist_id],
                ['depertment_id', $dept_id]
            ]);
        return $main_query;
    }
    // ------------- check same state user credentials ------------------
    public static function checkStateUserCreden($user_name, $department_id)
    {
        return appointing_authorities::where([
            ['phone', $user_name],
            ['department', $department_id]
        ])->exists();
    }

    // ----------------- send OTP------------ for registration
    public static function sendRegistrationOTP($otp, $phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107172768996209416&msg=' . $otp . '%20is%20your%20One-Time%20Password%20%28OTP%29%20to%20complete%20your%20Swagata%20Satirtha%20registration.%20Please%20do%20not%20share%20it%20with%20anyone.%0A%0ARegards%2C%0AGAD%2C%20Assam');
    }
    // ---------------- send OTP for NOC generated ----------------
    public static function sendNOCOTP($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107172769000994363&msg=Dear%20applicant%2C%20your%20profile%20has%20been%20recomended.%20Please%20visit%20swagatasatirtha.assam.gov.in%20for%20futher%20details.%20%0A%0ARegards%2C%0AGAD%2C%20Assam');
    }
    // ------------- mutual transfer request approved -------------------
    public static function sendFinalApprovalOTP($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107172769007242294&msg=Your%20mutual%20transfer%20request%20is%20approved.%20Please%20visit%20swagatasatirtha.assam.gov.in.in%20for%20further%20details.%0A%0ARegards%2C%0AGAD%2C%20Assam');
    }
    public static function JointTransferOrderMessage($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107172769007242294&msg=Your%20mutual%20transfer%20request%20is%20accepted.%20Please%20visit%20swagatasatirtha.assam.gov.in%20for%20further%20details.%0A%0ARegards%2C%0AGAD%2C%20Assam');
    }
    public static function JointTransferOrderMessageReject($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107172769007242294&msg=Your%20mutual%20transfer%20request%20is%20Rejected.%20Please%20visit%20swagatasatirtha.assam.gov.in%20for%20further%20details.%0A%0ARegards%2C%0AGAD%2C%20Assam');
    }
    public static function generateOrderMessage($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107172769000994363&msg=Dear%20applicant%2C%20your%20joint%20transfer%20order%20has%20been%20generated.%20Please%20visit%20swagatasatirtha.assam.gov.in%20for%20futher%20details.%20%0A%0ARegards%2C%0AGAD%2C%20Assam');
    }
    public static function sendAuthoritiesOTP($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107173078799101011&msg=Your+OTP+for+login+is+765432.+Please+enter+this+code+to+access+your+account.+Thank+you');
    }
    public static function sendInfoAuthritesMes($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107173078804632425&msg=Dear%20Palak%2C%20your%20credentials%20to%20log%20in%20to%20Swagata%20Satirtha%20are%20as%20follows%3A%0APhone%20Number%3A%20' . $phone . '%0APassword%3A%20password%0APlease%20ensure%20this%20information%20is%20kept%20confidential');
    }
    // --------- send message to verifier when employee submitted and update profile--------------
    public static function sendVerifierMessage($phone) {}
    // --------- send message to HOD to action transfer order --------------
    public static function sendTransferActionRequest($phone) {}
    // ---------- when verifier approved profile -------------
    public static function approvedProfileByVerifier($phone)
    {
        return Http::get('https://sms.amtronindia.in/form_/send_api_master_get.php?agency=COGNITECH&password=$wag@11024&district=ALL&app_id=MutualTransfer&sender_id=SWGSRT&unicode=false&to=' . $phone . '&te_id=1107172769000994363&msg=Dear%20applicant%2C%20your%20profile%20has%20been%20verified.%20Please%20visit%20swagatasatirtha.assam.gov.in%20for%20futher%20details.%20%0A%0ARegards%2C%0AGAD%2C%20Assam');
    }
    // ---------------------- return with query ------------------
    public static function returnQuery($model, $conditions = null, $related_model = []) {}
}
