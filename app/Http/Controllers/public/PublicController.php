<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\verification\appointing_authorities;
use App\Models\Public\CasteModel;
use App\Models\Public\DepertmentModel;
use App\Models\Public\DepertPostsMapModel;
use App\Models\Public\DisabilityTypesModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\ForgotPasswordManagerModel;
use App\Models\Public\GovtIDTypeModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\Public\PayScaleModel;
use App\Models\Public\RegistrationOTPVerifyModel;
use App\Models\User\AdditionaInfoModel;
use App\Models\User\DocumentModel;
use App\Models\User\EmploymentDetailsModel;
use App\Models\User\PersionalDetailsModel;
use App\Models\User\PreferenceDistrictModel;
use App\Models\User_auth\AllLoginModel;
use App\Models\User_auth\UserCredentialsModel;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use App\Rules\dependentValidateRule;
use App\Rules\validatePasswordRule;
use App\Rules\ValidatePhoneRule;
use App\View\Components\public\user_registration\AdditionalInfoComponent;
use App\View\Components\public\user_registration\BasicInformationComponent;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    // ----------- home page rendering ---------------
    public function home(Request $request)
    {
        return view('public.home');
    }

    // --------------- about page rendering -------------------
    public function about(Request $request)
    {
        return view('public.about');
    }

    // ----------------- FAQ page rendering ------------------

    public function faq(Request $request)
    {
        return view('public.faq');
    }

    // --------------- register page rendering ------------------
    public function register(request $request)
    {
        $view_data = [
            'is_error' => false,
        ];
        try {
            // $response=Http::withHeaders([
            //     'Api-key' => '$2a$05$HJ2SEB6.PilCuaGfz9KHwe.0.XL1GZuYTPaNAhUu9X7gAr1huCOaO',
            //     'Accept' => 'application/json',
            // ])->get('https://fin.assam.gov.in/assamfinanceservices/api/employeeDetails?type=1&ppan=2013242700110401');
            //     if($response->successful()){
            //         // dd($response->json()['profile']['id']);
            //     }else{
            //         dd($response);
            //     }
            if ($request->query('request_pan_number')) {
                $view_data['request_pan_number'] = $request->query('request_pan_number');
            }
        } catch (Exception $err) {
            $view_data['is_error'] = true;
        }
        return view('public.register', [
            'view_data' => $view_data
        ]);
    }
    // --------------------  registration API------------------
    // public function registrationAPI(Request $request, $is_return = false)
    // {
    //     // ---------------- start old code -------------------
    //     // if ($request->ajax()) {
    //     //     $res_data = [
    //     //         'status' => 400,
    //     //         'message' => null
    //     //     ];
    //     //     $incomming_data = [
    //     //         'first_name' => 'required',
    //     //         'last_name' => 'required',
    //     //         'gender' => 'required',
    //     //         'date_of_birth' => 'required|date',
    //     //         'parent_name' => 'required',
    //     //         'caste' => 'required|integer',
    //     //         'phone' => ['required', 'integer', new ValidatePhoneRule(), 'unique:user_credentials,phone'],
    //     //         'email' => 'required|email|unique:user_credentials,email',
    //     //         'govt_identy_type' => 'required|integer',
    //     //         'card_number' => 'required'
    //     //     ];
    //     //     try {
    //     //         $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
    //     //         if ($validate->fails()) {
    //     //             $res_data['message'] = $validate->errors()->all();
    //     //         }
    //     //     } catch (Exception $err) {
    //     //         $res_data['message'] = "Server error please try later !";
    //     //         $res_data['status'] = 401;
    //     //     }
    //     //     if (!$res_data['message']) {
    //     //         $res_data['status'] = 200;
    //     //     }
    //     //     if ($res_data['status'] == 200) {
    //     //         try {
    //     //             $otp = rand(100000, 999999);
    //     //             date_default_timezone_set('Asia/Kolkata');
    //     //             $send_time = date('Y-m-d H:i:s');
    //     //             RegistrationOTPVerifyModel::updateOrInsert(
    //     //                 ['phone' => $request->phone],
    //     //                 [
    //     //                     'OTP' => $otp,
    //     //                     'expire_time' => $send_time,
    //     //                     'is_used' => 1
    //     //                 ]
    //     //             );
    //     //             Session::put([
    //     //                 'first_name' => $request->first_name,
    //     //                 'last_name' => $request->last_name,
    //     //                 'gender' => $request->gender,
    //     //                 'date_of_birth' => $request->date_of_birth,
    //     //                 'parent_name' => $request->parent_name,
    //     //                 'caste' => $request->caste,
    //     //                 'phone' => $request->phone,
    //     //                 'email' => $request->email,
    //     //                 'govt_identy_type' => $request->govt_identy_type,
    //     //                 'card_number' => $request->card_number,
    //     //             ]);
    //     //             $res_data['status'] = 200;
    //     //         } catch (Exception $err) {
    //     //             $res_data['message'] = "Server error please try later !";
    //     //             $res_data['status'] = 401;
    //     //         }
    //     //     }

    //     //     return response()->json(['res_data' => $res_data]);
    //     // }

    //     // ------------------- end old code ----------------

    //     // --------------- start new code ------------------

    //     if ($request->ajax()) {
    //         $res_data = [
    //             'status' => 400,
    //             'message' => null
    //         ];
    //         $incomming_data = [
    //             'first_name' => 'required',
    //             'last_name' => 'required',
    //             'gender' => 'required',
    //             'date_of_birth' => 'required|date',
    //             'parent_name' => 'required',
    //             'caste' => 'required|integer',
    //             'phone' => ['required', 'integer', new ValidatePhoneRule(), 'unique:all_login,phone'],
    //             'alternative_number' => isset($request->alternative_number) ? ['integer', new ValidatePhoneRule()] : [''],
    //             'email' => 'required|email|unique:user_credentials,email',
    //             'password' => ['required', new validatePasswordRule()],
    //             'confirm_password' => ['required', new validatePasswordRule()],
    //             'disability_type' => 'required|integer',
    //             // 'govt_identy_type' => 'integer',
    //             'card_number' => 'required|unique:persional_details,card_number',
    //             'district' => 'required|integer',
    //             'depertment' => 'required|integer',
    //             'ddo_code' => 'required',
    //             'office' => 'required|integer',
    //             'designation' => 'required|integer',
    //             'date_of_joining' => 'required|date',
    //             'current_posting_date' => 'required|date',
    //             'pay_grade' => 'required|integer',
    //             'pay_band' => 'required',
    //             'ex_serviceman' => 'required',
    //             'preference_location' => 'required|array|min:3',
    //             'case_pendding' => 'required',
    //             'before_mutual_transfer' => 'required',
    //             'mutual_transfer_number' => 'required_if:before_mutual_transfer,yes',
    //             'pending_govt_dues' => 'required',
    //             'photo' => 'required|max:2048|mimes:jpg,jpeg,png',
    //             'signature' => 'required|max:2048|mimes:jpg,jpeg,png',
    //             'pan_card' => 'required|max:2048|mimes:jpg,jpeg,png',
    //             'depertmental_card' => 'required|max:2048|mimes:jpg,jpeg,png',
    //             'no_govt_due_certificate' => 'required_if:pending_govt_dues,no|max:2048|mimes:jpg,jpeg,png'
    //         ];
    //         // $res_data['no_mutual'] = $request->before_mutual_transfer;
    //         // $res_data['status'] = 200;
    //         // return response()->json(['res_data' => $res_data]);
    //         try {
    //             $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
    //             if ($validate->fails()) {
    //                 $res_data['message'] = $validate->errors()->all();
    //             } else {
    //                 if ($request->password != $request->confirm_password) {
    //                     $res_data['message'] = ['Both password and confirm password is must same'];
    //                 }
    //             }
    //         } catch (Exception $err) {
    //             $res_data['status'] = 401;
    //             $res_data['message'] = "Server error please try later !";
    //         }
    //         if (!$res_data['message']) {
    //             if (count($request->preference_location) !== count(array_unique($request->preference_location))) {
    //                 $res_data['message'] = ['preference location must be unique'];
    //             } else {
    //                 $res_data['status'] = 401;

    //                 if ($request->preview == 'preview') {
    //                     $res_data['status'] = 200;
    //                 } else {
    //                     try {
    //                         $otp = rand(100000, 999999);
    //                         date_default_timezone_set('Asia/Kolkata');
    //                         $send_time = date('Y-m-d H:i:s');
    //                         RegistrationOTPVerifyModel::updateOrInsert(
    //                             ['phone' => $request->phone],
    //                             [
    //                                 'OTP' => $otp,
    //                                 'expire_time' => $send_time,
    //                                 'is_used' => 1
    //                             ]
    //                         );
    //                         $pre_session_data = [
    //                             'first_name' => $request->first_name,
    //                             'middle_name' => $request->middle_name,
    //                             'last_name' => $request->last_name,
    //                             'gender' => $request->gender,
    //                             'date_of_birth' => $request->date_of_birth,
    //                             'parent_name' => $request->parent_name,
    //                             'caste' => $request->caste,
    //                             'phone' => $request->phone,
    //                             'alternative_number' => $request->alternative_number,
    //                             'email' => $request->email,
    //                             'password' => $request->password,
    //                             'disability_type' => $request->disability_type,
    //                             // 'govt_identy_type' => $request->govt_identy_type,
    //                             'card_number' => $request->card_number,
    //                             'district' => $request->district,
    //                             'depertment' => $request->depertment,
    //                             'ddo_code' => $request->ddo_code,
    //                             'office' => $request->office,
    //                             'designation' => $request->designation,
    //                             'date_of_joining' => $request->date_of_joining,
    //                             'current_posting_date' => $request->current_posting_date,
    //                             'pay_grade' => $request->pay_grade,
    //                             'pay_band' => $request->pay_band,
    //                             'ex_serviceman' => $request->ex_serviceman,
    //                             'preference_location' => $request->preference_location,
    //                             'case_pendding' => $request->case_pendding,
    //                             'before_mutual_transfer' => $request->before_mutual_transfer,
    //                             'mutual_transfer_number' => $request->mutual_transfer_number,
    //                             'pending_govt_dues' => $request->pending_govt_dues,
    //                             'photo' => file_get_contents($request->photo),
    //                             'photo_name' => $request->file('photo')->getClientOriginalName(),
    //                             'signature' => file_get_contents($request->signature),
    //                             'signature_name' => $request->file('signature')->getClientOriginalName(),
    //                             'pan_card' => file_get_contents($request->pan_card),
    //                             'pan_card_name' => $request->file('pan_card')->getClientOriginalName(),
    //                             'depertmental_card' => file_get_contents($request->depertmental_card),
    //                             'depertmental_card_name' => $request->file('depertmental_card')->getClientOriginalName(),
    //                         ];
    //                         $request->pending_govt_dues === 'no' ? $pre_session_data['no_govt_due_certificate'] = file_get_contents($request->no_govt_due_certificate) : '';
    //                         $request->pending_govt_dues === 'no' ? $pre_session_data['no_govt_due_certificate_name'] = $request->file('no_govt_due_certificate')->getClientOriginalName() : '';
    //                         Session::put($pre_session_data);
    //                         $res_data['status'] = 200;
    //                         $res_data['message'] = "click submit";
    //                     } catch (Exception $err) {
    //                         $res_data['message'] = "Server error please try later !";
    //                     }
    //                 }
    //             }
    //         }
    //         return response()->json(['res_data' => $res_data]);
    //     }
    // }

    // --------------- new registration API ------------------
    public function registrationAPI(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            $incomming_data = [
                'full_name' => 'required',
                'phone' => ['required', 'integer', new ValidatePhoneRule(), 'unique:user_credentials,phone'],
                'email' => 'required|unique:user_credentials,email',
                'password' => ['required', new validatePasswordRule()],
                'confirm_passowrd' => ['required', new validatePasswordRule()],
                'terms_and_sop' => 'required'
            ];
            try {
                App::setLocale(session::get('locale'));
                $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
                if ($validate->fails()) {
                    $res_data['message'] = $validate->errors()->all();
                } else {
                    if ($request->password !== $request->confirm_passowrd) {
                        $res_data['message'] = 'confirm password must be matched with Password ';
                        $res_data['status'] = 402;
                    } else {
                        $otp = rand(100000, 999999);
                        date_default_timezone_set('Asia/Kolkata');
                        $send_time = date('Y-m-d H:i:s');
                        RegistrationOTPVerifyModel::updateOrInsert(
                            ['phone' => $request->phone],
                            [
                                'OTP' => $otp,
                                'expire_time' => $send_time,
                                'is_used' => 1
                            ]
                        );
                        Session::put([
                            'full_name' => $request->full_name,
                            'phone' =>  $request->phone,
                            'email' => $request->email,
                            'password' => $request->password,
                        ]);
                        $otp_response = ReuseModule::sendRegistrationOTP($otp, $request->phone);
                        $res_data['status'] = 200;
                    }
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;

                $res_data['message'] = __('validation_message.server_message.server_error'); //$err->getMessage();
            }
            return response()->json(['res_data' => $res_data]);
        }
    }

    // ---------------- registration OTP page render -----------------------
    public function registrationOTP(Request $request)
    {
        return view('public.registration_otp');
    }
    // ------------------ old registration OTP verify API -------------------
    // public function registrationOTPAPI(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $res_data = [
    //             'status' => 400,
    //             'message' => null
    //         ];
    //         $session_data = [
    //             'first_name' => 'required',
    //             'last_name' => 'required',
    //             'gender' => 'required',
    //             'date_of_birth' => 'required|date',
    //             'parent_name' => 'required',
    //             'caste' => 'required|integer',
    //             'phone' => ['required', 'integer', new ValidatePhoneRule(), 'unique:all_login,phone'],
    //             'alternative_number' => isset($request->alternative_number) ? ['integer', new ValidatePhoneRule()] : [''],
    //             'email' => 'required|email|unique:user_credentials,email',
    //             'password' => ['required', new validatePasswordRule()],
    //             'disability_type' => 'required|integer',
    //             // 'govt_identy_type' => 'required|integer',
    //             'card_number' => 'required|unique:persional_details,card_number',
    //             'district' => 'required|integer',
    //             'depertment' => 'required|integer',
    //             'ddo_code' => 'required',
    //             'office' => 'required|integer',
    //             'designation' => 'required|integer',
    //             'date_of_joining' => 'required|date',
    //             'current_posting_date' => 'required|date',
    //             'pay_grade' => 'required|integer',
    //             'pay_band' => 'required',
    //             'ex_serviceman' => 'required',
    //             'preference_location' => 'required|array|min:3',
    //             'case_pendding' => 'required',
    //             'before_mutual_transfer' => 'required',
    //             'mutual_transfer_number' => 'required_if:before_mutual_transfer,yes',
    //             'pending_govt_dues' => 'required',
    //             'photo' => 'required',
    //             'signature' => 'required',
    //             'pan_card' => 'required',
    //             'depertmental_card' => 'required',
    //             'no_govt_due_certificate' => 'required_if:pending_govt_dues,no'

    //         ];
    //         try {
    //             $validate = ReuseModule::validateIncomingData($request, $session_data, Session::all());
    //             if ($validate->fails()) {
    //                 $res_data['message'] = $validate->errors()->all();
    //             } else {
    //                 $incomming_data = [
    //                     'registration_otp' => 'required|integer'
    //                 ];
    //                 $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
    //                 if ($validate->fails()) {
    //                     $res_data['message'] = $validate->errors()->all();
    //                 } else {
    //                     $res_data['status'] = 401;
    //                     $otp_details = ReuseModule::getOneData(new RegistrationOTPVerifyModel(), [
    //                         ['phone', Session::get('phone')]
    //                     ]);
    //                     if ($otp_details) {
    //                         date_default_timezone_set('Asia/Kolkata');
    //                         $expire_time = $otp_details->expire_time;
    //                         $recive_time = date('Y-m-d H:i:s');
    //                         $new_expire_time = new DateTime($expire_time);
    //                         $time_diff = $new_expire_time->diff(new DateTime($recive_time));
    //                         if ($time_diff->y == 0 && $time_diff->m == 0 && $time_diff->d == 0 && $time_diff->h == 0 && $time_diff->i <= 1 && $time_diff->s <= 60 && $otp_details->is_used == 1) {
    //                             if ($otp_details->OTP == $request->registration_otp) {
    //                                 $res_data['status'] = 200;
    //                             } else {
    //                                 $res_data['message'] = "OTP is not currect !";
    //                             }
    //                         } else {
    //                             $res_data['message'] = "OTP is expire , please resend .";
    //                         }
    //                     } else {
    //                         $res_data['message'] = "Mobile number is not exists verification !";
    //                     }
    //                 }
    //             }
    //         } catch (Exception $err) {
    //             $res_data['message'] = "Server error please try later !";
    //             $res_data['status'] = 401;
    //         }
    //         if ($res_data['status'] == 200) {
    //             $res_data['status'] = 401;
    //             // DB::beginTransaction();
    //             // RegistrationOTPVerifyModel::where(
    //             //     [
    //             //         ['phone', Session::get('phone')]
    //             //     ]
    //             // )
    //             //     ->update([
    //             //         'is_used' => 2
    //             //     ]);
    //             // $save_credentials = UserCredentialsModel::create([
    //             //     'frist_name' => Session::get('first_name'),
    //             //     'last_name' => Session::get('last_name'),
    //             //     'email' => Session::get('email'),
    //             //     'phone' => Session::get('phone'),
    //             //     'password' => Hash::make("password"),
    //             // ]);
    //             // PersionalDetailsModel::create([
    //             //     'user_id' => $save_credentials->id,
    //             //     'gender' => Session::get('gender'),
    //             //     'date_of_birth' => Session::get('date_of_birth'),
    //             //     'parent_name' => Session::get('parent_name'),
    //             //     'caste_id' => Session::get('caste'),
    //             //     'govt_identy_type' => Session::get('govt_identy_type'),
    //             //     'card_number' => Session::get('card_number'),
    //             // ]);
    //             // $res_data['status'] = 200;
    //             // $res_data['first_name'] = Session::get('first_name');
    //             // $res_data['message'] = "Registration Completed !";
    //             // DB::commit();
    //             // Session::flush();


    //             // $fileContent = Session::get('photo');
    //             // $file_name = Str::uuid() . '_' . time().Session::get('photo_name');
    //             // $final_path= Storage::disk('public')->put('uploads/' . $file_name,$fileContent);
    //             // $res_data['link']=$final_path;

    //             try {
    //                 DB::beginTransaction();
    //                 $save_user = UserCredentialsModel::create([
    //                     'frist_name' => Session::get('first_name'),
    //                     'middle_name' => Session::get('middle_name'),
    //                     'last_name' => Session::get('last_name'),
    //                     'email' => Session::get('email'),
    //                     'phone' => Session::get('phone'),
    //                 ]);
    //                 $save_logins = AllLoginModel::create([
    //                     'user_id' => $save_user->id,
    //                     'user_type' => 1,
    //                     'phone' => Session::get('phone'),
    //                     'password' => Hash::make(Session::get('password')),
    //                     'role_id' => 4
    //                 ]);
    //                 if ($save_user) {
    //                     $save_basic = PersionalDetailsModel::create([
    //                         'user_id' => $save_user->id,
    //                         'gender' => Session::get('gender'),
    //                         'date_of_birth' => Session::get('date_of_birth'),
    //                         'parent_name' => Session::get('parent_name'),
    //                         'alt_phone_number' => Session::get('alternative_number'),
    //                         'caste_id' => Session::get('caste'),
    //                         'card_number' => Session::get('card_number'),
    //                         'disability_type_id' => Session::get('disability_type'),
    //                     ]);
    //                     if ($save_basic) {
    //                         $save_employment = EmploymentDetailsModel::create([
    //                             'user_id' => $save_user->id,
    //                             'district_id' => Session::get('district'),
    //                             'depertment_id' => Session::get('depertment'),
    //                             'ddo_code' => Session::get('ddo_code'),
    //                             'office_id' => Session::get('office'),
    //                             'designation_id' => Session::get('designation'),
    //                             'date_of_joining' => Session::get('date_of_joining'),
    //                             'current_posting_date' => Session::get('current_posting_date'),
    //                             'pay_grade' => Session::get('pay_grade'),
    //                             'pay_band' => Session::get('pay_band'),
    //                             'ex_serviceman' => Session::get('ex_serviceman')
    //                         ]);
    //                         $save_additional_data = AdditionaInfoModel::create([
    //                             'user_id' => $save_user->id,
    //                             'criminal_case' => Session::get('case_pendding'),
    //                             'mutual_transfer' => Session::get('before_mutual_transfer'),
    //                             'no_mutual_transfer' => Session::get('mutual_transfer_number'),
    //                             'pending_govt_dues' => Session::get('pending_govt_dues'),
    //                         ]);
    //                         if ($save_employment) {
    //                             $preference_no = 1;
    //                             $all_districts = array_map(function ($district_id) use ($save_user, &$preference_no) {

    //                                 $pre_districts = [
    //                                     'user_id' => $save_user->id,
    //                                     'district_id' => $district_id,
    //                                     'preference_no' => $preference_no
    //                                 ];
    //                                 $preference_no++;
    //                                 return $pre_districts;
    //                             }, Session::get('preference_location'));
    //                             $save_preference_documents = PreferenceDistrictModel::insert($all_districts);
    //                             if ($save_preference_documents) {
    //                                 $photo_path = 'uploads/employees/' . $save_user->id . '/';
    //                                 $photo_file_path = ReuseModule::uploadPhoto('photo', $photo_path, 'photo_name', 'session');
    //                                 $signature_path = ReuseModule::uploadPhoto('signature', $photo_path, 'signature_name', 'session');
    //                                 $govt_identify_card_path = ReuseModule::uploadPhoto('pan_card', $photo_path, 'pan_card_name', 'session');
    //                                 $depertmental_card_name_path = ReuseModule::uploadPhoto('depertmental_card', $photo_path, 'depertmental_card_name', 'session');

    //                                 $save_document = DocumentModel::create([
    //                                     'user_id' => $save_user->id,
    //                                     'documet_location' => $photo_file_path,
    //                                     'document_type' => 1
    //                                 ]);
    //                                 $save_document = DocumentModel::create([
    //                                     'user_id' => $save_user->id,
    //                                     'documet_location' => $signature_path,
    //                                     'document_type' => 2
    //                                 ]);
    //                                 $save_document = DocumentModel::create([
    //                                     'user_id' => $save_user->id,
    //                                     'documet_location' => $govt_identify_card_path,
    //                                     'document_type' => 3
    //                                 ]);
    //                                 $save_document = DocumentModel::create([
    //                                     'user_id' => $save_user->id,
    //                                     'documet_location' => $depertmental_card_name_path,
    //                                     'document_type' => 4
    //                                 ]);
    //                                 if (Session::get('pending_govt_dues') === 'no') {
    //                                     $no_govt_due_certificate_path = ReuseModule::uploadPhoto('no_govt_due_certificate', $photo_path, 'no_govt_due_certificate_name', 'session');
    //                                     $save_document = DocumentModel::create([
    //                                         'user_id' => $save_user->id,
    //                                         'documet_location' => $no_govt_due_certificate_path,
    //                                         'document_type' => 5
    //                                     ]);
    //                                 }
    //                                 RegistrationOTPVerifyModel::where(
    //                                     [
    //                                         ['phone', Session::get('phone')]
    //                                     ]
    //                                 )
    //                                     ->update([
    //                                         'is_used' => 2
    //                                     ]);
    //                             }
    //                         }
    //                     }
    //                     DB::commit();
    //                     Session::flush();
    //                     $res_data['status'] = 200;
    //                 }
    //             } catch (Exception $err) {
    //                 DB::rollBack();
    //                 if ($save_user) {
    //                     if (Storage::disk('public')->exists('uploads/employees/' . $save_user->id)) {
    //                         Storage::disk('public')->deleteDirectory('uploads/employees/' . $save_user->id);
    //                     }
    //                 }
    //                 $res_data['message'] = "Server error please try later !";
    //                 // $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
    //             }
    //         }

    //         return response()->json(['res_data' => $res_data]);
    //     }
    // }
    // ------------------ new registration verifycation details -----------------
    public function registrationOTPAPI(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            $session_data = [
                'full_name' => 'required',
                'phone' =>  ['required', 'integer', new ValidatePhoneRule(), 'unique:user_credentials,phone'],
                'email' => 'required|unique:user_credentials,email',
                'password' => ['required', new validatePasswordRule()]
            ];
            try {
                App::setLocale(session::get('locale'));
                $validate = ReuseModule::validateIncomingData($request, $session_data, Session::all());
                if ($validate->fails()) {
                    $res_data['message'] = $validate->errors()->all();
                } else {
                    $res_data['status'] = 401;
                    $otp_details = ReuseModule::getOneData(new RegistrationOTPVerifyModel(), [
                        ['phone', Session::get('phone')]
                    ]);
                    if ($otp_details) {
                        date_default_timezone_set('Asia/Kolkata');
                        $expire_time = $otp_details->expire_time;
                        $recive_time = date('Y-m-d H:i:s');
                        $new_expire_time = new DateTime($expire_time);
                        $time_diff = $new_expire_time->diff(new DateTime($recive_time));
                        if ($time_diff->y == 0 && $time_diff->m == 0 && $time_diff->d == 0 && $time_diff->h == 0 && $time_diff->i <= 1 && $time_diff->s <= 60 && $otp_details->is_used == 1) {
                            if ($otp_details->OTP == $request->registration_otp) {
                                $res_data['message'] = __('validation_message.static_validate_errors.registration_completed');
                                $res_data['status'] = 200;
                            } else {
                                $res_data['message'] = __('validation_message.static_validate_errors.otp_wrong');
                            }
                        } else {
                            $res_data['message'] = __('validation_message.static_validate_errors.otp_expire');
                        }
                    } else {
                        $res_data['message'] = __('validation_message.static_validate_errors.phone_not_exists');
                    }
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
                // $res_data['message']=$err->getMessage();
            }
            if ($res_data['status'] == 200) {
                $res_data['status'] = 401;
                try {
                    DB::beginTransaction();
                    RegistrationOTPVerifyModel::where(
                        [
                            ['phone', Session::get('phone')]
                        ]
                    )
                        ->update([
                            'is_used' => 2
                        ]);
                    $save_credentials = UserCredentialsModel::create([
                        'full_name' => Session::get('full_name'),
                        'phone' => Session::get('phone'),
                        'email' => Session::get('email')
                    ]);
                    $user_id = $save_credentials->id;
                    $ref_emp_code = strlen($user_id);
                    $struct_ref = 'SWGSRT000000';
                    $user_ref_code = substr_replace($struct_ref, $user_id, -$ref_emp_code);
                    $update_credentials = UserCredentialsModel::where('id', $save_credentials->id)
                        ->update([
                            'user_ref_code' => $user_ref_code
                        ]);
                    if ($save_credentials) {
                        $save_login = AllLoginModel::create([
                            'user_id' => $save_credentials->id,
                            'user_type' => 1,
                            'phone' => Session::get('phone'),
                            'password' => Hash::make(Session::get('password')),
                            'role_id' => 4
                        ]);
                        if ($save_login) {
                            $save_persional = PersionalDetailsModel::create([
                                'user_id' => $save_credentials->id
                            ]);
                            if ($save_persional) {
                                $save_employment = EmploymentDetailsModel::create([
                                    'user_id' => $save_credentials->id
                                ]);
                                if ($save_employment) {
                                    $save_additional = AdditionaInfoModel::create([
                                        'user_id' => $save_credentials->id
                                    ]);
                                    DB::commit();
                                    Session::flush();
                                    $res_data['status'] = 200;
                                    $res_data['ref_id'] = $user_ref_code;
                                }
                            }
                        }
                    }
                } catch (Exception $err) {
                    // DB::rollBack();
                    $res_data['message'] = "Server error please try later !";
                    // $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ---------------- user login page render -----------------


    // default Credentials for verification module generate
    public function generate_credentials()
    {
        $defaultPassword = config('custom.appointing_authority_password');
        try {
            DB::beginTransaction();
            $aa = appointing_authorities::create([
                'name' => 'Irrigation Approving officer1',
                'designation' => 'designation',
                'phone' => '9085581131',
                'department' => 22,
                'district' => 20,
                'office' => 1,
            ]);
            AllLoginModel::create([
                'user_id' => $aa->id,
                'user_type' => 2,
                'phone' => $aa->phone,
                'password' => Hash::make('Password123'),
                'role_id' => 6,
                'status' => 1
            ]);
            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }


    public function userLogin(Request $request)
    {
        // $returns = $this->generate_credentials();
        // if($returns == 1){
        return view('public.user-login');
        // }else{
        //     Log::error("user_creation: ".$returns);
        //     dd('Some error occurred');
        // }
    }


    // ---------------- depertment login page render -----------------
    public function depertmentLogin(Request $request)
    {
        return view('public.user-login', [
            'login_page' => "depertment_login"
        ]);
    }
    // ------------- user login API----------------
    public function userLoginAPI(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => ''
            ];
            $incoming_data = [
                'phone' => 'required|integer|exists:user_credentials,phone',
                'password' => 'required'
            ];
            $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
            if ($validate->fails()) {
                $res_data['message'] = $validate->errors()->all();
            } else {
                $res_data['status'] = 401;
                try {
                    App::setLocale(session::get('locale'));
                    $attemp_data = [
                        "phone" => $request->phone,
                        'password' => $request->password,
                        'role_id' => 4,
                        'status' => 1
                    ];
                    if (Auth::guard('user_guard')->attempt($attemp_data)) {
                        $res_data['message'] = Auth::guard('user_guard')->user();
                        $res_data['status'] = 200;
                    } else {
                        $res_data['message'] = __('validation_message.authentication_message.credentials');
                    }
                } catch (Exception $err) {
                    $res_data['message'] = __('validation_message.server_message.server_error');
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ---------------------- forgot password --------------------
    public function forgotPassword(Request $request)
    {
        return view('public.forgot_password');
    }
    // ------------------- send OTP for forgot password API --------------
    public function forgotPasswordAPI(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'message' => '',
                'status' => 400
            ];
            $incoming_data = [
                'phone' => ['required', 'integer', new ValidatePhoneRule(), 'exists:user_credentials,phone']
            ];
            try {
                App::setLocale(session::get('locale'));
                $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
                if ($validate->fails()) {
                    $res_data['message'] = $validate->errors()->all();
                } else {
                    $otp = rand(100000, 999999);
                    date_default_timezone_set('Asia/Kolkata');
                    $send_time = date('Y-m-d H:i:s');
                    ForgotPasswordManagerModel::updateOrInsert(
                        ['phone' => $request->phone],
                        [
                            'OTP' => $otp,
                            'expire_time' => $send_time,
                            'is_used' => 1
                        ]
                    );
                    Session::put([
                        'phone' => $request->phone
                    ]);
                    $otp_response = ReuseModule::sendForgotPasswordOTP($otp, $request->phone);
                    $res_data['status'] = 200;
                }
            } catch (Exception $err) {

                $res_data['message'] = __('validation_message.server_message.server_error');
                $res_data['status'] = 401;
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ----------------- set new password or verify otp -----------------
    public function setNewPassword(Request $request)
    {
        return view('public.set_new_password');
    }
    // ------------------- verify forgot password OTP ---------------------
    public function verifyBySetPassword(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => ''
            ];
            $required = '';
            if ($request->api_type == "set_password") {
                $required = 'required';
            }
            $incoming_data = [
                'otp' => $request->api_type == "verify_otp" ? 'required|integer' : 'integer',
                'password' => [$required, new validatePasswordRule()],
                'confirm_password' => [$required, new validatePasswordRule()]
            ];
            $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
            if ($validate->fails()) {
                $res_data['message'] = $validate->errors()->all();
            } else {
                $res_data['status'] = 401;
                $is_process = false;
                try {
                    $otp_details = ReuseModule::getOneData(new ForgotPasswordManagerModel(), [
                        ['phone', Session::get('phone')]
                    ]);
                    if ($otp_details) {
                        date_default_timezone_set('Asia/Kolkata');
                        $expire_time = $otp_details->expire_time;
                        $recive_time = date('Y-m-d H:i:s');
                        $new_expire_time = new DateTime($expire_time);
                        $time_diff = $new_expire_time->diff(new DateTime($recive_time));
                        if ($time_diff->y == 0 && $time_diff->m == 0 && $time_diff->d == 0 && $time_diff->h == 0 && $time_diff->i <= 1 && $time_diff->s <= 60 && $otp_details->is_used == 1) {
                            if ($otp_details->otp == $request->otp) {
                                if ($request->api_type == "verify_otp") {
                                    $res_data['status'] = 200;
                                    return response()->json(['res_data' => $res_data]);
                                }
                                if ($request->password === $request->confirm_password) {
                                    $is_process = true;
                                } else {
                                    $res_data['message'] = "confirm_password is not match with new password";
                                }
                            } else {
                                $res_data['message'] = "OTP is not currect";
                            }
                        } else {
                            $res_data['message'] = "OTP is expire, please re-send !";
                        }
                    } else {
                        $res_data['message'] = "Data not found for OTP !";
                    }
                } catch (Exception $err) {
                    $res_data['message'] = "Server error please try later !";
                }
                if ($is_process) {
                    try {
                        DB::beginTransaction();
                        ReuseModule::updateRecords(new AllLoginModel(), [
                            ['phone', Session::get('phone')]
                        ], [
                            'password' => Hash::make($request->password)
                        ]);
                        ReuseModule::updateRecords(new ForgotPasswordManagerModel(), [
                            ['phone', Session::get('phone')]
                        ], [
                            'is_used' => 2
                        ]);
                        DB::commit();
                        Session::flush();
                        $res_data['status'] = 200;
                    } catch (Exception $err) {
                        DB::rollBack();
                        $res_data['message'] = "Server error please try later !";
                        // $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
                    }
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ------------------ get offices and posts name by depertment ------------------
    public function getOfficePost(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 401,
                'offices' => [],
                'posts' => [],
                'message' => null
            ];
            try {
                $conditions = [
                    ['dept_id', $request->query('depertment_id') ?? true]
                ];
                $related_models = [
                    'post_names' => []
                ];
                if ($request->query('is_district') == "false" || $request->query('is_directorate') == "false") {
                    $main_query = EmployeeModule::dynamicOneModelsQuery(new DepertPostsMapModel(), $conditions, $related_models);
                    $res_data['posts'] = $main_query->get();
                    $res_data['dept'] = $request->query('depertment_id');
                }

                // $main_query = EmployeeModule::dynamicOneModelsQuery(new OfficeFinAsssamModel(), [
                //     ['department_id', $request->query('depertment_id')],
                //     ['district_id',$request->query('district_id') ?? true]
                // ]);
                // $main_query->select('id', 'name', 'district_id','ddo','department_id');
                // $res_data['offices'] = $main_query->get();
                $main_query = OfficesDistDeptModel::query();
                $main_query->with(['office_fin_assam'])
                    ->where([
                        ['district_id', $request->query('district_id')],
                        ['depertment_id', $request->query('depertment_id')],
                        ['directorate_id',$request->query('directorate_id')]
                    ]);
                $res_data['offices'] = $main_query->get();
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = "Server error please try later !";
                // $res_data['message']=$err->getMessage();
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ------------------ get offices and pay grade by depertment and post ------------------
    public function getPayGrade(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 401,
                'pay_grade' => ''
            ];
            try {
                $conditions = [
                    ['dept_id', $request->query('depertment_id')],
                    ['post_id', $request->query('post_id')]
                ];
                $main_query = EmployeeModule::dynamicOneModelsQuery(new DepertPostsMapModel(), $conditions);
                $res_data['pay_grade'] = $main_query->first()->grade_pay ?? '';
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['status'] = 401;
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ------------------ resend OTP -----------------
    public function resendForgotPassOTP(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => []
            ];
            $model = null;
            $required = null;

            try {
                App::setLocale(session::get('locale'));
                if (in_array($request->resend_for, ['forgot_password', 'registration_otp'])) {
                    if ($request->resend_for == "forgot_password") {
                        $model = new ForgotPasswordManagerModel();
                        $required = ['required', 'integer', new ValidatePhoneRule(), 'exists:user_credentials,phone'];
                    } else if ($request->resend_for == "registration_otp") {
                        $model = new RegistrationOTPVerifyModel();
                        $required = ['required', 'integer', new ValidatePhoneRule(), 'unique:user_credentials,phone'];
                    }
                    $session_data = [
                        'phone' => $required
                    ];
                    $validate = ReuseModule::validateIncomingData($request, $session_data, Session::all());
                    if ($validate->fails()) {
                        $res_data['message'] = $validate->errors()->all();
                    } else {
                        $res_data = $this->setResendOTP($model, Session::get('phone'));
                    }
                } else {
                    $res_data['status'] = 401;
                    $res_data['message'] = "keys are not define ";
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = "Server error please try later !";
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ------------------ set resend OTP--------------
    public function setResendOTP($model, $phone)
    {
        $res_data = [
            'status' => 401,
            'message' => null,
        ];
        $otp_details = $model::where('phone', $phone)->first();
        if ($otp_details) {
            date_default_timezone_set('Asia/Kolkata');
            $otp = rand(100000, 999999);
            $send_time = date('Y-m-d H:i:s');
            $expire_time = $otp_details->expire_time;
            $recive_time = date('Y-m-d H:i:s');
            $new_expire_time = new DateTime($expire_time);
            $time_diff = $new_expire_time->diff(new DateTime($recive_time));
            if ($time_diff->i >= 1) {
                $res_data['status'] = 200;
                $model::where('phone', $phone)->update(
                    [
                        'OTP' => $otp,
                        'expire_time' => $send_time,
                        'is_used' => 1
                    ]
                );
                $otp_response = ReuseModule::sendForgotPasswordOTP($otp, $phone);
                $res_data['status'] = 200;
                $res_data['message'] = __('validation_message.static_validate_errors.otp_sent');
            } else {
                $res_data['message'] = __('validation_message.static_validate_errors.after_minutes');
            }
        } else {
            $res_data['status'] = 402;
            $res_data['message'] = "Set your first OTP ";
        }
        return $res_data;
    }
    // -------------- get offices by district ---------------
    public function getOfficeByDistrict(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null,
                'offices' => []
            ];
            try {
                $logged_user = Auth::guard('user_guard')->user()->user_credentials;
                $main_query = OfficesDistDeptModel::query()->with(['office_fin_assam'])->where([
                    ['depertment_id', $logged_user->employment_details->depertment_id],
                ]);
                if ($request->input('district_id')) {
                    $main_query->where('district_id', $request->input('district_id'));
                } else {
                    $preferences = $logged_user->preferences_district()->whereHas('districts')->get();
                    $main_query->whereIn('district_id', $preferences->pluck('district_id')->toArray());
                }
                $main_query->select('office_id');
                $main_query->distinct();
                $res_data['offices'] = $main_query->get();
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // -------------- user logout -------------------
    public function userLogout(Request $request)
    {
        if (Auth::guard('user_guard')->user()) {
            Auth::guard('user_guard')->logout();
        }

        return redirect(app()->getLocale() . '/user-login');
    }
    // -------------- fetch offices by district and depertment --------------
    public function fetchOfficeDistDept(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $district_id = $request->input('district_id');
        $depertment_id = $request->input('depertment_id');
        if ($district_id && $depertment_id) {
            try {
                $main_query = OfficesDistDeptModel::with('office_fin_assam')
                ->where('depertment_id', $depertment_id);
                if ($district_id !== 'all') {
                    $main_query->where('district_id', $district_id);
                }
                $res_data['offices'] = $main_query->get();
                $res_data['status']=200;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
        } else {
            $res_data['message'] = "Select district and depertment ";
        }
        return response()->json(['res_data' => $res_data]);
    }
    // --------------------- chanage lang ---------------------
    public function chanageLang(Request $request)
    {
        // $request->validate([
        //     'lang' => 'required|in:en,as',
        // ]);
        Session::put('locale', $request->lang);
        App::setLocale($request->lang);
        return redirect()->back();
    }
}
