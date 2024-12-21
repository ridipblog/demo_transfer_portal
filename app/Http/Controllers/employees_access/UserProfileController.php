<?php

namespace App\Http\Controllers\employees_access;

use App\Http\Controllers\Controller;
use App\Models\Public\CasteModel;
use App\Models\Public\DepertmentModel;
use App\Models\Public\DepertPostsMapModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\ProfileStatusModel;
use App\Models\trash\RejectedDocumentsModel;
use App\Models\User\AdditionaInfoModel;
use App\Models\User\DocumentModel;
use App\Models\User\EmploymentDetailsModel;
use App\Models\User\PersionalDetailsModel;
use App\Models\User\PreferenceDistrictModel;
use App\Models\User_auth\AllLoginModel;
use App\Models\User_auth\UserCredentialsModel;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use App\Rules\ValidatePhoneRule;
use Carbon\Carbon;
use Closure;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\fileExists;


class UserProfileController extends Controller
{
    public $file_location;
    public $file_index;
    public $old_track_files = [];

    // ----------------- complete pending  profile details ---------------------
    public function completeProfile(Request $request)
    {
        $view_data = [
            'is_error' => false,
            'error_message' => '',
            'save_data' => null,
            'pan_request_data' => null,
            'is_pan_found' => false,
            'search_pan_number' => null,
            'offices' => [],
            'posts' => [],

        ];

        $pan_component = [
            'is_error' => false,
            'error_message' => null,
            'is_update' => false,
            'is_final' => false
        ];
        $submit_button_component = [
            'is_error' => false,
            'error_message' => null,
            'is_update' => false,
            'is_final' => false
        ];
        try {
            App::setLocale(session::get('locale'));
            // dd(Auth::guard('user_guard')->user());
            if (Auth::guard('user_guard')->user()->user_credentials->profile_verify_status != 1 || Auth::guard('user_guard')->user()->user_credentials->noc_generate == 2) {
                if ($request->query('request_pan_number')) {
                    $view_data['search_pan_number'] = $request->query('request_pan_number');
                    $view_data['pan_request_data'] = ReuseModule::verifyPanNUmber($request->query('request_pan_number'));
                    if ($view_data['pan_request_data'] &&  isset($view_data['pan_request_data']['profile']['pan'])) {
                        $view_data['is_pan_found'] = true;
                    } else {
                        $view_data['is_pan_found'] = false;
                        $view_data['error_message'] = __('validation_message.profile_message.pan_not_found');
                    }
                }
                $logged_user = Auth::guard('user_guard')->user();
                if ($logged_user->user_credentials->noc_generate == 2 || $logged_user->user_credentials->profile_verify_status == 2) {
                    $pan_component['is_update'] = true;
                    $submit_button_component['is_update'] = true;
                }
                if ($logged_user->user_credentials->profile_verify_status == 0) {
                    $pan_component['is_final'] = true;
                    $submit_button_component['is_final'] = true;
                }
                $view_data['caste'] = ReuseModule::getAllData(new CasteModel());
                $view_data['districts'] = ReuseModule::getAllData(new DistrictModel());
                $view_data['depertments'] = ReuseModule::getAllData(new DepertmentModel());
                $conditions = [
                    ['id', Auth::guard('user_guard')->user()->user_id],
                    // ['profile_verify_status', '!=', 1]
                ];
                $query = EmployeeModule::getEmployeesAllData($conditions);
                $query->where(function ($sub_query) {
                    $sub_query->where('profile_verify_status', '!=', 1)
                        ->orWhere('noc_generate', 2);
                });
                $employee_all_data = $query->get();
                if (count($employee_all_data) == 0) {

                    $view_data['is_error'] = true;
                    $view_data['error_message'] = __('validation_message.profile_message.not_data');
                } else {
                    if ($employee_all_data[0]->employment_details->depertment_id ?? false) {

                        // $main_query = OfficeFinAsssamModel::query();
                        // if ($request->query('request_pan_number')) {
                        //     // $view_data['pan_request_data']['ddo']['department'] = " Irrigation department     ";
                        //     $view_data['pan_request_data']['ddo']['department'] = trim($view_data['pan_request_data']['ddo']['department'] ?? null);
                        //     $view_data['pan_request_data']['profile']['district'] = trim($view_data['pan_request_data']['profile']['district'] ?? null);
                        //     // $view_data['pan_request_data']['ddo']['office_name'] = 'Guwahati West-Palashbari Division, Irrigation' ?? null;
                        //     // $view_data['pan_request_data']['ddo']['ddo'] = 'AKM/IRR/005  ' ?? null;
                        //     $view_data['pan_request_data']['ddo']['office_name'] = trim($view_data['pan_request_data']['ddo']['office_name'] ?? null);
                        //     $view_data['pan_request_data']['ddo']['ddo'] = trim($view_data['pan_request_data']['ddo']['ddo'] ?? null);
                        //     // $view_data['pan_request_data']['profile']['designation'] = ' Senior Assistant  ';
                        //     $view_data['pan_request_data']['profile']['designation'] = trim($view_data['pan_request_data']['profile']['designation'] ?? null);
                        // }
                        // ------------ if pan search and depertment not null ----------------

                        // if ($request->query('request_pan_number') ? ($view_data['pan_request_data']['ddo']['department'] ?? false) : false) {
                        //     $main_query->whereHas('deptartments', function ($query) use ($view_data) {
                        //         $query->where('name', $view_data['pan_request_data']['ddo']['department']);
                        //     });
                        //     $main_query->whereHas('districts', function ($query) use ($view_data) {
                        //         $query->where('name', $view_data['pan_request_data']['profile']['district']);
                        //         // $query->whereRaw('LOWER(name) = ?', [strtolower($view_data['pan_request_data']['profile']['district'])]);
                        //     });
                        //     $office_query = $main_query;
                        //     $view_data['offices'] = $main_query->get();
                        //     $office_query->where([
                        //         ['name', $view_data['pan_request_data']['ddo']['office_name']],
                        //         ['DDO', $view_data['pan_request_data']['ddo']['ddo']]
                        //     ]);
                        //     if ($office_query->exists()) {
                        //         $view_data['pan_request_data']['ddo']['ddo'] = $office_query->first()->DDO;
                        //     } else {
                        //         $view_data['pan_request_data']['ddo']['ddo'] = null;
                        //     }
                        // }

                        // -------------------- if pan not search and depertment_id not null in database ---------------

                        // $main_query->where([
                        //     ['department_id', $employee_all_data[0]->employment_details->depertment_id],
                        //     ['district_id', $employee_all_data[0]->employment_details->district_id ?? true]
                        // ]);
                        // $view_data['offices'] = $main_query->get();


                        // $view_data['offices'] = ReuseModule::getAllData(new OfficeFinAsssamModel(), [
                        //     ['department_id', $employee_all_data[0]->employment_details->depertment_id]
                        // ]);
                        $main_query = DepertPostsMapModel::query();

                        // ----------- if pan search and depertment not null ----------------

                        // if ($request->query('request_pan_number') ? ($view_data['pan_request_data']['ddo']['department'] ?? false) : false) {
                        //     $main_query->whereHas('deptartments', function ($query) use ($view_data) {
                        //         $query->where('name', $view_data['pan_request_data']['ddo']['department']);
                        //     });

                        //     $grade_pay_query = $main_query;
                        //     $view_data['posts'] = $main_query->get();
                        //     $grade_pay_query->whereHas('deptartments', function ($query) use ($view_data) {
                        //         $query->where('name', $view_data['pan_request_data']['ddo']['department']);
                        //     });
                        //     $grade_pay_query->whereHas('post_names', function ($query) use ($view_data) {
                        //         $query->where('name', $view_data['pan_request_data']['profile']['designation']);
                        //     });
                        //     if ($grade_pay_query->exists()) {
                        //         $view_data['pan_request_data']['profile']['grade_pay'] = $grade_pay_query->first()->grade_pay;
                        //     } else {
                        //         $view_data['pan_request_data']['profile']['grade_pay'] = null;
                        //     }
                        // }

                        // ------------- if pan not search and depertment id not null in database ---------------


                        $main_query->where('dept_id', $employee_all_data[0]->employment_details->depertment_id);
                        $view_data['posts'] = $main_query->get();


                        // $view_data['posts'] = EmployeeModule::dynamicOneModelsQuery(new DepertPostsMapModel(), [
                        //     ['dept_id', $employee_all_data[0]->employment_details->depertment_id]
                        // ], [
                        //     'post_names' => []
                        // ])->get();
                    }
                    if ($employee_all_data[0]->employment_details->depertment_id && $employee_all_data[0]->employment_details->district_id) {
                        $view_data['offices'] = ReuseModule::getOffices($employee_all_data[0]->employment_details->district_id, $employee_all_data[0]->employment_details->depertment_id)->get();
                    }
                    $view_data['save_data'] = $employee_all_data[0];
                }
            } else {
                return redirect(app()->getLocale() . '/employees/dashboard');
            }
        } catch (Exception $err) {
            // dd($err->getMessage());
            $view_data['is_error'] = true;
            $view_data['error_message'] = __('validation_message.server_message.server_error');
        }
        return view('employee_access.complete_profile', [
            'view_data' => $view_data,
            'pan_component' => $pan_component,
            'submit_button_component' => $submit_button_component
        ]);
    }

    // --------------- save or final submit profile details ------------------
    public function saveOrSubmitProfile($request, $api_type = "save")
    {
        $res_data = [
            'message' => null,
            'status' => 400
        ];
        $required = '';
        if ($api_type == "final_submit" || $api_type == "preview_final_submit" || $api_type == "update_data") {
            $required = "required";
        }
        // $required = $api_type == ('final_submit' || 'preview_final_submit') ? 'required' : '';
        $res_data['type'] = $required;
        try {
            App::setLocale(session::get('locale'));
            $logged_user = Auth::guard('user_guard')->user();
            $process_status = [
                'save',
                'final_submit',
                'update_data'
            ];
            // -------------- old entry logic ----------------

            // $logged_user->user_credentials->profile_verify_status != 1) || ($logged_user->user_credentials->profile_verify_status != 0 && $api_type != "update_data")

            // -------------- old entry logic ----------------
            if (($logged_user->user_credentials->profile_verify_status != 1 && $api_type != "update_data") || (($logged_user->user_credentials->profile_verify_status == 2 || $logged_user->user_credentials->noc_generate == 2)  && $api_type == "update_data")) {
                $all_documents = ReuseModule::getAllData(new DocumentModel(), [
                    ['user_id', $logged_user->user_id]
                ]);
                $documents = [
                    'photo' => $request->photo,
                    'signature' => $request->signature,
                    'pan_card' => $request->pan_card,
                    'depertmental_card' => $request->depertmental_card,
                    'no_govt_due_certificate' => $request->no_govt_due_certificate,
                    'appointment_letter' => $request->appointment_letter,
                    'service_book' => $request->service_book
                ];
                $incomming_data = [
                    'full_name' => 'required',
                    'gender' => $required,
                    'date_of_birth' => $required,
                    'father_name' => $required,
                    'mother_name' => $required,
                    'category' => $required . '|integer',
                    'alternative_number' => isset($request->alternative_number) ? ['integer', new ValidatePhoneRule()] : [''],
                    'email' => ['required', 'email', Rule::unique('user_credentials', 'email')->ignore($logged_user->user_id, 'id')],
                    // 'pan_number' => [$required, Rule::unique('persional_details', 'pan_number')->ignore($logged_user->user_id, 'user_id')],
                    'pan_number' => ['required', Rule::unique('persional_details', 'pan_number')->ignore($logged_user->user_id, 'user_id')],
                    'district' => $required . '|integer',
                    'depertment' => $required . '|integer',
                    // 'ddo_code' => $required,
                    'office' => $required,
                    'designation' => $required . '|integer',
                    'date_of_joining' => $required,
                    'current_posting_date' => $required,
                    'pay_grade' => $required . $request->pay_grade ? '|integer' : '',
                    'pay_band' => $required,
                    'preference_location' => [$required, 'array', $required ? 'min:5' : ''],
                    'times_mutual_transfer'=>$required,
                    // 'case_pendding' => $required,
                    // 'departmental_proceedings' => $required,
                    // 'before_mutual_transfer' => $required,
                    // 'mutual_transfer_number' => 'required_if:before_mutual_transfer,yes',
                    // 'pending_govt_dues' => $required,
                    'photo' => ['max:5000', 'mimes:jpg,jpeg,png'],
                    'signature' => 'max:5000|mimes:jpg,jpeg,png',
                    'pan_card' => 'max:5000|mimes:jpg,jpeg,png',
                    'depertmental_card' => 'max:5000|mimes:jpg,jpeg,png',
                    // 'no_govt_due_certificate' => 'max:5000|mimes:jpg,jpeg,png',
                    // 'appointment_letter' => 'max:5000|mimes:jpg,jpeg,png',
                    // 'first_page_of_service_book' => 'max:5000|mimes:jpg,jpeg,png'
                ];

                $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
                if ($validate->fails()) {
                    $res_data['message'] = $validate->errors()->all();
                } else {
                    if (isset($request->preference_location) ? count($request->preference_location) !== count(array_unique($request->preference_location)) : false) {
                        $res_data['message'] = ['preference location must be unique'];
                    } else {

                        $res_data['status'] = 200;
                        if ($api_type == "preview_final_submit" || $api_type == "final_submit") {
                            $save_document_index = $all_documents->pluck('document_type')->toArray();
                            $document_keys = array_keys($documents);
                            $error_message = [];
                            $res_data['document_keys'] = $document_keys;
                            for ($i = 1; $i <= 5; $i++) {
                                if (!in_array($i, $save_document_index)) {
                                    $check = $document_keys[$i - 1];
                                    if ($i == 5 && $request->pending_govt_dues != "no") {
                                        $check = null;
                                    }
                                    if ($check ? (!$request->hasFile($check)) : false) {
                                        $check = str_replace('_', ' ', $check);
                                        array_push($error_message, $check . ' is required field !');
                                        $res_data['status'] = 400;
                                    }
                                }
                            }
                            $res_data['message'] = $error_message;
                            // if ($api_type == "preview_final_submit") {
                            //     return $res_data;
                            // }
                        }
                    }
                }
            } else {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.profile_message.already_verified');
            }
        } catch (Exception $err) {
            $res_data['message'] = __('validation_message.server_message.server_error');
            // $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
            $res_data['status'] = 401;
        }
        $dept_post_id = null;
        if ($res_data['status'] == 200) {
            try {
                if ($request->depertment && $request->designation) {
                    $dept_post_id = ReuseModule::getOneData(new DepertPostsMapModel(), [
                        ['dept_id', $request->depertment],
                        ['post_id', $request->designation]
                    ]);
                    if ($dept_post_id) {
                        $res_data['status'] = 200;
                    } else {
                        $res_data['status'] = 401;
                        $res_data['message'] = "Depertment & Post not found !";
                    }
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
            }
        }
        if ($res_data['status'] == 200) {
            if (isset($request->preference_location) ? in_array($request->district, $request->preference_location) : false) {
                $res_data['message'] = ['Current district is cannot be select as preference '];
                $res_data['status'] = 400;
            }
        }
        if ($res_data['status'] == 200) {
            if ($api_type == "preview_final_submit") {
                return $res_data;
            }
            try {
                DB::beginTransaction();
                $save_data_process = UserCredentialsModel::where(
                    'id',
                    $logged_user->user_id
                )->update([
                    'full_name' => $request->full_name,
                    'email' => $request->email
                ]);
                // $save_office = null;
                // if ($request->office) {
                //     // $save_office = OfficeFinAsssamModel::create([
                //     //     'name' => $request->office,
                //     //     'assign_by' => $logged_user->user_id
                //     // ]);
                //     $update_office = OfficeFinAsssamModel::updateOrInsert([
                //         'assign_by' => $logged_user->user_id
                //     ], [
                //         'name' => $request->office,
                //         'department_id'=>$request->depertment,
                //         'district_id'=>$request->district
                //     ]);
                //     $save_office = OfficeFinAsssamModel::where('assign_by', $logged_user->user_id)
                //         ->first();
                // }
                if ($save_data_process) {
                    $profile_update_data = [
                        'gender' => $request->gender,
                        'date_of_birth' => $request->date_of_birth,
                        'father_name' => $request->father_name,
                        'mother_name' => $request->mother_name,
                        'alt_phone_number' => $request->alternative_number,
                        'category_id' => $request->category,
                    ];
                    $api_type != 'update_data' ? $profile_update_data['pan_number'] = $request->pan_number : '';
                    $save_data_process = PersionalDetailsModel::where(
                        'user_id',
                        $logged_user->user_id
                    )->update(
                        $profile_update_data
                    );
                    if ($save_data_process) {

                        $save_data_process = EmploymentDetailsModel::where(
                            'user_id',
                            $logged_user->user_id
                        )->update([
                            'district_id' => $request->district,
                            'depertment_id' => $request->depertment,
                            // 'ddo_code' => $request->ddo_code,
                            'office_id' => $request->office,
                            // 'office_id' =>  $save_office->id ?? null,
                            'designation_id' => $request->designation,
                            'first_date_of_joining' => $request->date_of_joining,
                            'current_date_of_joining' => $request->current_posting_date,
                            'pay_grade' => $request->pay_grade,
                            'pay_band' => $request->pay_band,
                            'dept_post_id' => $dept_post_id->id ?? null
                        ]);
                        if ($save_data_process) {
                            $preference_no = 1;
                            $preference_map_data = [];
                            foreach ($request->preference_location ? $request->preference_location : [] as $location) {
                                // PreferenceDistrictModel::updateOrInsert(
                                //     [
                                //         'user_id' => $logged_user->user_id,
                                //         'preference_no' => $preference_no
                                //     ],
                                //     [
                                //         'district_id' => $location
                                //     ]
                                // );

                                //optimzied code
                                $preference_map_data[] = [
                                    'user_id' => $logged_user->user_id,
                                    'preference_no' => $preference_no,
                                    'district_id' => $location
                                ];
                                $preference_no++;
                            }
                            //optimized code
                            $update_preference_map = PreferenceDistrictModel::upsert($preference_map_data, ['user_id', 'preference_no'], ['district_id']);
                            $save_data_process = AdditionaInfoModel::where('user_id', $logged_user->user_id)
                                ->update([
                                    // 'criminal_case' => $request->case_pendding,
                                    // 'departmental_proceedings' => $request->departmental_proceedings,
                                    // 'mutual_transfer' => $request->before_mutual_transfer,
                                    // 'no_mutual_transfer' => $request->mutual_transfer_number,
                                    // 'pending_govt_dues' => $request->pending_govt_dues,
                                    'times_mutual_transfer'=>$request->times_mutual_transfer
                                ]);
                            if ($save_data_process) {
                                $document_map_data = [];

                                $this->file_index = 1;

                                foreach ($documents as $key => $value) {
                                    if ($request->hasFile($key)) {
                                        $photo_path = 'uploads/employees/' . $logged_user->user_id . '/';
                                        $this->file_location = ReuseModule::uploadPhoto($value, $photo_path, $request->file($key)->getClientOriginalName());
                                        // $save_document_process = DocumentModel::updateOrInsert(
                                        //     [
                                        //         'user_id' => $logged_user->user_id,
                                        //         'document_type' => $this->file_index
                                        //     ],
                                        //     [
                                        //         'documet_location' => $this->file_location
                                        //     ]
                                        // );
                                        // if ($save_document_process) {
                                        // array_push($this->old_track_files, $this->file_index);
                                        // }
                                        array_push($this->old_track_files, $this->file_index);
                                        $document_map_data[] = [
                                            'user_id' => $logged_user->user_id,
                                            'document_type' => $this->file_index,
                                            'documet_location' => $this->file_location,
                                        ];
                                    }
                                    $this->file_index++;
                                }
                                $update_document_map_data = DocumentModel::upsert($document_map_data, ['user_id', 'document_type'], ['documet_location']);
                                if (($logged_user->user_credentials->profile_verify_status == 3 && $api_type == "final_submit") || (($logged_user->user_credentials->profile_verify_status == 2 || $logged_user->user_credentials->noc_generate == 2) && $api_type == "update_data")) {
                                    UserCredentialsModel::where('id', $logged_user->user_id)
                                        ->update([
                                            'profile_verify_status' => 0,
                                            'noc_generate' => 0
                                        ]);
                                }
                                if ((($logged_user->user_credentials->profile_verify_status == 2 || $logged_user->user_credentials->noc_generate == 2) && $api_type == "update_data")) {
                                    $filter_updated_document = $all_documents->whereIn('document_type', $this->old_track_files)
                                        ->map(function ($document) {
                                            return [
                                                'user_id' => $document['user_id'],
                                                'document_type' => $document['document_type'],
                                                'documet_location' => $document['documet_location'],
                                            ];
                                        })->values();
                                    $update_json_data = RejectedDocumentsModel::create([
                                        'user_id' => $logged_user->user_credentials->id,
                                        'old_update_on' => $logged_user->user_credentials->updated_at,
                                        'old_documents' => $update_document_map_data != 0 ? json_encode($filter_updated_document) : null
                                    ]);
                                }
                                // if ($save_office) {
                                //     OfficeFinAsssamModel::where('assign_by', $logged_user->user_id)
                                //         ->where('id', '!=', $save_office->id)
                                //         ->delete();
                                // }
                                DB::commit();

                                // if you want to delete old stored docuemnt --------------
                                // foreach ($all_documents as $document) {
                                //     foreach ($this->old_track_files as $index) {
                                //         if ($document->document_type == $index) {
                                //             Storage::disk('public')->delete($document->documet_location);
                                //             break;
                                //         }
                                //     }
                                // }
                                // -------- optimized code for delete exists image if needed -------------
                                // $documents_by_type = $all_documents->keyBy('document_type');
                                // foreach ($this->old_track_files as $index) {
                                //     if(isset($documents_by_type[$index])){
                                //         Storage::disk('public')->delete($documents_by_type[$index]->documet_location ?? '');
                                //     }
                                // }
                                $res_data['status'] = 200;
                            }
                        }
                    }
                }
            } catch (Exception $err) {
                DB::rollBack();
                if ($this->file_location) {
                    Storage::disk('public')->delete($this->file_location);
                }
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
                // $res_data['message'] = $err->getMessage();
            }
        }
        return $res_data;
    }
    // ------------------- save employee profile  details ---------------
    public function saveProfileAPI(Request $request)
    {
        if ($request->ajax()) {
            try {
                $verify_pan_number = ReuseModule::verifyPanNUmber($request->pan_number);
                if ($verify_pan_number &&  isset($verify_pan_number['profile']['pan'])) {
                    $res_data = $this->saveOrSubmitProfile($request);
                    if ($res_data['status'] == 200) {
                        $res_data['message'] = __('validation_message.profile_message.data_save');
                    }
                } else {
                    $res_data['status'] = 401;
                    $res_data['message'] = __('validation_message.profile_message.pan_not_found');
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
                // $res_data['message'] = $err->getMessage();
            }

            return response()->json(['res_data' => $res_data]);
        }
    }
    // ------------------- preview final submit profile data -----------------
    public function previewSubmitProfileAPI(Request $request)
    {
        if ($request->ajax()) {
            try {
                $verify_pan_number = ReuseModule::verifyPanNUmber($request->pan_number);
                if ($verify_pan_number &&  isset($verify_pan_number['profile']['pan'])) {
                    $res_data = $this->saveOrSubmitProfile($request, 'preview_final_submit');
                    if ($res_data['status'] == 200) {
                        $res_data['message'] = "Data preview !";
                    }
                } else {
                    $res_data['status'] = 401;
                    $res_data['message'] = __('validation_message.profile_message.pan_not_found');
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ------------------ final submit profile data ------------------
    public function submitProfileAPI(Request $request)
    {
        if ($request->ajax()) {
            try {
                $verify_pan_number = ReuseModule::verifyPanNUmber($request->pan_number);
                if ($verify_pan_number &&  isset($verify_pan_number['profile']['pan'])) {
                    $res_data = $this->saveOrSubmitProfile($request, 'final_submit');
                    if ($res_data['status'] == 200) {
                        $res_data['message'] = __('validation_message.profile_message.data_submit');
                    }
                } else {
                    $res_data['status'] = 401;
                    $res_data['message'] = __('validation_message.profile_message.pan_not_found');
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ---------------- update profile data ------------------
    public function updateProfileAPI(Request $request)
    {
        if ($request->ajax()) {
            try {
                $verify_pan_number = ReuseModule::verifyPanNUmber($request->pan_number);
                if ($verify_pan_number &&  isset($verify_pan_number['profile']['pan'])) {
                    $res_data = $this->saveOrSubmitProfile($request, 'update_data');
                    if ($res_data['status'] == 200) {
                        $res_data['message'] = __('validation_message.profile_message.data_updated');
                    }
                } else {
                    $res_data['status'] = 401;
                    $res_data['message'] = __('validation_message.profile_message.pan_not_found');
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
            }
        }
        return response()->json(['res_data' => $res_data]);
    }
    // ---------------------- update employee profile -----------------
    public function updateEmployeeProfile(Request $request)
    {
        $view_data = [
            'is_error' => false,
            'error_message' => '',

        ];
        $conditions = [
            ['id', Auth::guard('user_guard')->user()->user_id],
            // ['profile_verify_status', 0],
            // ['status',1]
        ];

        try {
            // dd(Auth::guard('user_guard')->user()->id);
            $view_data['caste'] = ReuseModule::getAllData(new CasteModel());
            $view_data['districts'] = ReuseModule::getAllData(new DistrictModel());
            $view_data['depertments'] = ReuseModule::getAllData(new DepertmentModel());
            $query = EmployeeModule::getEmployeesAllData($conditions);
            $employee_all_data = $query->get();
            if (count($employee_all_data) == 0) {
                $view_data['error_message'] = 'No data found !';
                $view_data['is_error'] = true;
            } else {
                if ($employee_all_data[0]->profile_verify_status != 0) {
                    $view_data['error_message'] = "You can't edit proifle after employment verification completed !";
                    $view_data['is_error'] = true;
                } else {
                    $view_data['employee_all_data'] = $employee_all_data[0];
                    $view_data['is_error'] = false;
                }
                // dd($employee_all_data[0]);
            }
        } catch (Exception $err) {
            dd($err->getMessage());
            $view_data['is_error'] = true;
        }
        return view('employee_access.update_employee_profile', [
            'view_data' => $view_data
        ]);
    }
    // ----------------- get ddo code by office -----------
    public function getDddoCodeApi(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null,
                'ddo_code' => null
            ];
            if ($request->query('office_id') !== null) {
                try {
                    $ddo_code = OfficeFinAsssamModel::where('id', $request->query('office_id'))
                        ->select('id', 'ddo')->first();
                    $res_data['status'] = 200;
                    $res_data['ddo_code'] = $ddo_code->ddo ?? '';
                } catch (Exception $err) {
                    $res_data['message'] = __('validation_message.server_message.server_error');
                }
            } else {
                $res_data['message'] = "Select a office name ";
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ----------------- update employee profile data ----------------------
    public function updateEmployeeProfileAPI(REquest $request)
    {
        $res_data = [
            'message' => null,
            'status' => 400
        ];
        try {
            $incomming_data = [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required|date',
                'parent_name' => 'required',
                'caste' => 'required|integer',
                'phone' => ['required', 'integer', new ValidatePhoneRule(), Rule::unique('all_login', 'phone')->ignore(Auth::guard('user_guard')->user()->id)],
                'alternative_number' => isset($request->alternative_number) ? ['integer', new ValidatePhoneRule()] : [''],
                'email' => ['required', 'email', Rule::unique('user_credentials', 'email')->ignore(Auth::guard('user_guard')->user()->id)],
                // 'govt_identy_type' => 'required|integer',
                'disability_type' => 'required|integer',
                'card_number' => ['required', Rule::unique('persional_details', 'card_number')->ignore(Auth::guard('user_guard')->user()->id)],
                'district' => 'required|integer',
                'depertment' => 'required|integer',
                'office' => 'required|integer',
                'designation' => 'required|integer',
                'date_of_joining' => 'required|date',
                'current_posting_date' => 'required|date',
                'ex_serviceman' => 'required',
                'preference_location' => 'required|array|min:3',
                'case_pendding' => 'required',
                'before_mutual_transfer' => 'required',
                'mutual_transfer_number' => 'required_if:before_mutual_transfer,yes',
                'pending_govt_dues' => 'required',
                'photo' => 'max:2048|mimes:jpg,jpeg,png',
                'signature' => 'max:2048|mimes:jpg,jpeg,png',
                'pan_card' => 'max:2048|mimes:jpg,jpeg,png',
                'depertmental_card' => 'max:2048|mimes:jpg,jpeg,png',
                'no_govt_due_certificate' => ['max:2048', 'mimes:jpg,jpeg,png'],
                'appointment_letter' => ['max:2048', 'mimes:jpg,jpeg,png'],
                'first_page_of_service_book' => ['max:2048', 'mimes:jpg,jpeg,png']
            ];
            $res_data['data'] = $request->pending_govt_dues;

            $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
            if ($validate->fails()) {
                $res_data['message'] = $validate->errors()->all();
            } else {
                $logged_persion = ReuseModule::getOneData(new UserCredentialsModel(), [
                    ['id', Auth::guard('user_guard')->user()->user_id]
                ]);
                if ($logged_persion->profile_verify_status != 0) {
                    $res_data['status'] = 401;
                    $res_data['message'] = "Your profile is already " . ($logged_persion->profile_verify_status == 1 ? 'verified.' : 'rejected.');
                }
            }
        } catch (Exception $err) {
            $res_data['status'] = 401;
            $res_data['message'] = "Server error please try later !";
            $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
        }
        if (!$res_data['message']) {
            if (count($request->preference_location) !== count(array_unique($request->preference_location))) {
                $res_data['message'] = ['preference location must be unique'];
            } else {
                $res_data['status'] = 401;
                try {
                    $current_user = Auth::guard('user_guard')->user();
                    $check_document = ReuseModule::getOneData(new DocumentModel(), [
                        ['user_id', $current_user->user_id],
                        ['document_type', 5]
                    ]);
                    if ($request->pending_govt_dues === "no") {
                        if (!$check_document && !$request->no_govt_due_certificate) {
                            $res_data['message'] = ['no govt due certificate is require field !'];
                            $res_data['status'] = 400;
                        }
                    }
                    if ($res_data['status'] != 400) {
                        DB::beginTransaction();
                        $update_logins = AllLoginModel::where(
                            'id',
                            $current_user->id,
                        )->update([
                            'phone' => $request->phone
                        ]);
                        $update_user = UserCredentialsModel::where(
                            'id',
                            $current_user->user_id
                        )->update(
                            [
                                'frist_name' => $request->first_name,
                                'middle_name' => $request->middle_name,
                                'last_name' => $request->last_name,
                                'email' => $request->email,
                                'phone' => $request->phone,
                            ]
                        );
                        if ($update_user) {
                            $update_basic = PersionalDetailsModel::where(
                                'user_id',
                                $current_user->user_id
                            )
                                ->update([
                                    'gender' => $request->gender,
                                    'date_of_birth' => $request->date_of_birth,
                                    'parent_name' => $request->parent_name,
                                    'alt_phone_number' => $request->alternative_number,
                                    'caste_id' => $request->caste,
                                    // 'govt_identy_type' => $request->govt_identy_type,
                                    'card_number' => $request->card_number,
                                    'disability_type_id' => $request->disability_type
                                ]);
                            if ($update_basic) {
                                $update_employment = EmploymentDetailsModel::where(
                                    'user_id',
                                    $current_user->user_id
                                )
                                    ->update([
                                        'district_id' => $request->district,
                                        'depertment_id' => $request->depertment,
                                        'office_id' => $request->office,
                                        'designation_id' => $request->designation,
                                        'date_of_joining' => $request->date_of_joining,
                                        'current_posting_date' => $request->current_posting_date,
                                        'ex_serviceman' => $request->ex_serviceman
                                    ]);
                                if ($update_employment) {
                                    $preference_no = 1;
                                    foreach ($request->preference_location as $location) {
                                        PreferenceDistrictModel::where(
                                            [
                                                ['user_id', $current_user->user_id],
                                                ['preference_no', $preference_no]
                                            ]
                                        )->update([
                                            'district_id' => $location
                                        ]);
                                        $preference_no++;
                                    }
                                    $update_additional_info = AdditionaInfoModel::where(
                                        'user_id',
                                        $current_user->user_id
                                    )->update([
                                        'criminal_case' => $request->case_pendding,
                                        'mutual_transfer' => $request->before_mutual_transfer,
                                        'no_mutual_transfer' => $request->mutual_transfer_number,
                                        'pending_govt_dues' => $request->pending_govt_dues,
                                    ]);
                                    $all_documents = ReuseModule::getAllData(new DocumentModel(), [
                                        ['user_id', $current_user->user_id]
                                    ]);
                                    $documents = [
                                        'photo' => $request->photo,
                                        'signature' => $request->signature,
                                        'pan_card' => $request->pan_card,
                                        'depertmental_card' => $request->depertmental_card,
                                        'no_govt_due_certificate' => $request->no_govt_due_certificate
                                    ];
                                    $this->file_index = 1;
                                    foreach ($documents as $key => $value) {
                                        if ($request->hasFile($key)) {

                                            $photo_path = 'uploads/employees/' . $current_user->user_id . '/';
                                            $this->file_location = ReuseModule::uploadPhoto($value, $photo_path, $request->file($key)->getClientOriginalName());
                                            $update_document = DocumentModel::where([
                                                ['user_id', $current_user->user_id],
                                                ['document_type', $this->file_index]
                                            ])->update([
                                                'documet_location' => $this->file_location,
                                            ]);
                                            if (!isset($all_documents[4])) {
                                                DocumentModel::create([
                                                    'user_id' => $current_user->user_id,
                                                    'document_type' => 5,
                                                    'documet_location' => $this->file_location,
                                                ]);
                                            }
                                            if ($update_document) {
                                                // if (isset($all_documents[$this->file_index-1]['documet_location'])) {
                                                //     Storage::disk('public')->delete($all_documents[$this->file_index-1]['documet_location']);
                                                // }
                                                array_push($this->old_track_files, $this->file_index);
                                            }
                                        }
                                        $this->file_index++;
                                    }
                                    DB::commit();
                                    foreach ($this->old_track_files as $index) {
                                        if (isset($all_documents[$index - 1]['documet_location'])) {
                                            Storage::disk('public')->delete($all_documents[$index - 1]['documet_location']);
                                        }
                                    }
                                    $res_data['status'] = 200;
                                    $res_data['message'] = "Data Updated Successfully ";
                                }
                            }
                        }
                    }
                } catch (Exception $err) {
                    DB::rollBack();
                    if ($this->file_location) {
                        Storage::disk('public')->delete($this->file_location);
                    }
                    $res_data['message'] = "Server error please try later !";
                    $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
                }
            }
        }
        return response()->json(['res_data' => $res_data]);
    }
    // -------------- update employee profile data ------------------
    // public function updateProfileDataAPI(Request $request)
    // {
    //     // if ($request->ajax()) {
    //     $res_data = [
    //         'status' => 400,
    //         'message' => ''
    //     ];
    //     $res_data['message'] = $this->updateProfileData($request);
    //     return response()->json(['res_data' => $res_data]);
    //     // }
    // }
    // --------------- main method to update or create profile data ------------------
    // public function updateProfileData($request, $api = "new")
    // {
    //     $message = '';
    //     $form_lists = [2, 3, 4, 5];
    //     try {
    //         $is_form_process = false;
    //         if ($api == "new") {
    //             if (Auth::guard('user_guard')->user()->profile_verify_status == 0) {
    //                 if (Auth::guard('user_guard')->user()->profile_status == $request->form_id - 1) {
    //                     $is_form_process = true;
    //                 }
    //             }
    //         } else if ($api == "update") {
    //             if (Auth::guard('user_guard')->user()->profile_verify_status != 0) {
    //                 $is_form_process = true;
    //             }
    //         }
    //         if ($is_form_process) {
    //             $is_form_process = false;
    //             if (in_array($request->form_id, $form_lists)) {
    //                 $request_form_data = [
    //                     '2' => [
    //                         'address' => 'required',
    //                         'district' => 'required|integer',
    //                         'pincode' => 'required|integer'
    //                     ],
    //                     '3' => [
    //                         'district' => 'required|integer',
    //                         'depertment' => 'required|integer',
    //                         'office' => 'required|integer',
    //                         'designation' => 'required|integer',
    //                         'date_of_joining' => 'required|date',
    //                         'pay_scale' => 'required|integer',
    //                         'grade_pay' => 'required|integer',
    //                     ],
    //                     '4' => [
    //                         'district' => 'required|array'
    //                     ],
    //                     '5' => [
    //                         'govt_identy_card' => 'required|max:2048|mimes:pdf',
    //                         'employment_letter' => 'required|max:2048|mimes:pdf',
    //                         'salary_slip' => 'required|max:2048|mimes:pdf'
    //                     ]
    //                 ];
    //                 $request_forms = [
    //                     [
    //                         serialize(
    //                             [
    //                                 'address' => $request->address,
    //                                 'district_id' => $request->district,
    //                                 'pin_code' => $request->pincode
    //                             ]
    //                         ) => new PersionalDetailsModel()
    //                     ],
    //                     [
    //                         serialize(
    //                             [
    //                                 'district_id' => $request->district,
    //                                 'depertment_id' => $request->depertment,
    //                                 'office_id' => $request->office,
    //                                 'designation_id' => $request->designation,
    //                                 'date_of_joining' => $request->date_of_joining,
    //                                 'pay_scale_id' => $request->pay_scale,
    //                                 'grade_pay' => $request->grade_pay,
    //                             ]
    //                         ) => new EmploymentDetailsModel()
    //                     ],
    //                     [
    //                         serialize(
    //                             [
    //                                 'district_id' => $request->district
    //                             ]
    //                         ) => new PreferenceDistrictModel()
    //                     ],
    //                 ];
    //                 $validate = ReuseModule::validateIncomingData($request, $request_form_data[$request->form_id], $request->all());
    //                 if ($validate->fails()) {
    //                     $message = $validate->errors()->all();
    //                 } else {
    //                     $is_form_process = true;
    //                 }
    //             } else {
    //                 $message = "Select a valid form";
    //             }
    //         } else {
    //             $message = "You are in wrong form !";
    //         }
    //     } catch (Exception $err) {
    //         DB::rollBack();
    //         $message = $err->getMessage();
    //     }
    //     if ($is_form_process) {
    //         try {
    //             DB::beginTransaction();
    //             if ($request->form_id != 4 && $request->form_id != 5) {
    //                 foreach ($request_forms[$request->form_id - 2] as $request_data => $model) {
    //                     $form_values = unserialize($request_data);
    //                     $form_values['user_id'] = Auth::guard('user_guard')->user()->id;
    //                     $save_data = $model::updateOrInsert(
    //                         ['user_id' => Auth::guard('user_guard')->user()->id],
    //                         $form_values
    //                     );
    //                     $message = $save_data;
    //                 }
    //             } else {
    //                 foreach ($request_forms[$request->form_id - 2] as $request_data => $model) {
    //                     $form_values = unserialize($request_data);
    //                     $all_districts = array_map(function ($district_id) {
    //                         return [
    //                             'user_id' => Auth::guard('user_guard')->user()->id,
    //                             'district_id' => $district_id,
    //                         ];
    //                     }, $request->district);
    //                     $save_data = $model::insert(
    //                         $all_districts
    //                     );
    //                 }
    //             }

    //             if ($api == "new") {
    //                 UserCredentialsModel::where('id', Auth::guard('user_guard')->user()->id)
    //                     ->update([
    //                         'profile_status' => $request->form_id
    //                     ]);
    //             }
    //             // DB::commit();
    //         } catch (Exception $err) {
    //             DB::rollBack();
    //             $message = $err->getMessage();
    //         }
    //     }
    //     return $message;
    // }
}
