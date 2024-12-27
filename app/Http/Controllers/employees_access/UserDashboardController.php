<?php

namespace App\Http\Controllers\employees_access;

use App\Http\Controllers\Controller;
use App\Models\appointing_authorities;
use App\Models\department\departments;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\Transfer\TransfersModel;
use App\Models\trash\RejectedDocumentsModel;
use App\Models\User\EmploymentDetailsModel;
use App\Models\User\PreferenceDistrictModel;

use App\Models\User_auth\UserCredentialsModel;
use App\Models\verification\VerificationRemarksDocumentModel;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $view_data = [
            'is_error' => false,
            'message' => null,
            'employee_all_data' => []
        ];
        $transfer_data = null;
        $incomming_data_table = [];
        $preferenceDistricts = [];
        $userCountsByEmploymentDistrict = [];
        $profile_data = null;
        $is_request_done = null;
        $rejected_data = null;
        $verifier_add_documents = null;

        try {
            App::setLocale(session::get('locale'));

            $logged_persion = Auth::guard('user_guard')->user()->user_credentials;
            if ($logged_persion->profile_verify_status == 3) {
                return redirect(app()->getLocale() . '/employees/update-profile');
            }
            $view_data['logged_persion'] = $logged_persion;
            $conditions = [
                ['id', $logged_persion->id]
            ];
            $related_models = [
                // 'documents' => [
                //     ['document_type', 1]
                // ]
            ];
            $with_conditions = [
                'documents' => function ($query) {
                    $query->where('document_type', 1);
                }
            ];
            $query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, $related_models, $with_conditions);
            $profile_data = $query->first();

            if (in_array($logged_persion->profile_verify_status, [0, 2, 3]) || $logged_persion->noc_generate != 1) {
                $query = EmployeeModule::getEmployeesAllData();
                $employee_all_data = $query->where(function ($query) {
                    $query->whereIn('profile_verify_status', [0, 2, 3])
                        ->orWhere('noc_generate', '!=', 1);
                })
                    ->where('id', $logged_persion->id)
                    ->get();

                // ------------ is any additional document by verification ---------------
                $rejected_data = RejectedDocumentsModel::with(['authority_rejections'])
                    ->where([
                        ['user_id', $logged_persion->id],
                        ['old_update_on', null],
                        ['old_documents', null]
                    ])
                    ->orderBy('created_at', 'desc')->first();
                // dd($employee_all_data);
                if (count($employee_all_data) == 0) {
                    $view_data['is_error'] = true;
                    $view_data['message'] = "Employee  data not found";
                } else {
                    $view_data['employee_all_data'] = $employee_all_data[0];
                }
            } else {
                // $conditions = [
                //     // ['employee_id',$this->viewData->id],
                // ];
                $related_models = [
                    // 'appointing_authorities'=>[],
                    'transfer_employee_user' => [],
                    'transfer_employee_target_user' => [],
                    'transfer_employee_user.employment_details.districts' => [],
                    'transfer_employee_target_user.employment_details.districts' => [],
                    'transfer_employee_target_user.employment_details.departments' => [],
                    'transfer_employee_target_user.employment_details.post_names' => [],
                    'transfer_employee_target_user.employment_details.offices_finassam' => []
                ];
                // $query = EmployeeModule::dynamicOneModelsQuery(new TransfersModel(), $conditions, $related_models);
                $query = TransfersModel::query()->with([
                    'appointing_authorities',
                    'appointing_authorities.districts',
                    'appointing_authorities.departments'
                ])->whereHas('transfer_employee_user', function ($sub_query) {})->whereHas('transfer_employee_target_user', function ($sub_query) {})->whereHas('transfer_employee_user.employment_details.districts', function ($sub_query) {})->whereHas('transfer_employee_target_user.employment_details.districts', function ($sub_query) {})->whereHas('transfer_employee_target_user.employment_details.post_names', function ($sub_query) {})->whereHas('transfer_employee_target_user.employment_details.offices_finassam', function ($sub_query) {});
                // ----------------- new code ----------------
                $query->where(function ($sub_query) use ($logged_persion) {
                    $sub_query->where('target_employee_id', $logged_persion->id)
                        ->where('request_status', 1);
                })->orWhere('employee_id', $logged_persion->id);
                $query->orderBy('id', 'desc');
                $transfer_data = $query->first();
                $is_request_done = EmployeeModule::isTransferDone()->exists();
                $logged_user = Auth::guard('user_guard')->user();
                $conditions = [
                    ['target_employee_id', $logged_user->user_id],
                ];
                $related_models = [
                    'transfer_employee_user' => [],
                    'transfer_employee_user.documents' => [
                        ['document_type', 1]
                    ],
                    'transfer_employee_user.employment_details.departments' => [],
                    'transfer_employee_user.employment_details.districts' => [],
                    'transfer_employee_user.employment_details.offices_finassam' => [],
                    'transfer_employee_user.employment_details.post_names' => []
                ];
                $with_conditions = [
                    'transfer_employee_user' => function ($query) {},
                    'transfer_employee_user.documents' => function ($query) {
                        $query->where('document_type', 1);
                    },
                    'transfer_employee_user.employment_details.departments' => function ($query) {},
                    'transfer_employee_user.employment_details.districts' => function ($query) {},
                    'transfer_employee_user.employment_details.offices_finassam' => function ($query) {},
                    'transfer_employee_user.employment_details.post_names' => function ($query) {}

                ];
                $main_query = EmployeeModule::dynamicOneModelsQuery(new TransfersModel(), $conditions, $related_models, $with_conditions);
                // ------------- start latest code add here ---------------
                // $main_query->whereIn('request_status',[1,2]);
                $main_query->where('request_status', 0);
                // ------------- end latest code add here ---------------
                $main_query->orderBy('id', 'desc')->take(5);
                $incomming_data_table['incomming_requests'] = $main_query->get();
                $incomming_data_table['is_request_process'] = EmployeeModule::isRequestProcess()->first();

                $logged_user = Auth::guard('user_guard')->user()->user_credentials;
                $preferenceDistricts = $logged_user->preferences_district;
                // -----------------old code for count preference --------------
                // $related_users = UserCredentialsModel::where([
                //     ['profile_verify_status', 1],
                //     ['noc_generate', 1],
                //     ['id', '!=', $logged_user->id]
                // ])
                //     ->whereHas('employment_details', function ($query) use ($preferenceDistricts, $logged_user) {
                //         $query->whereIn('district_id', $preferenceDistricts->pluck('district_id')->toArray())
                //             // ->where('depertment_id', $logged_user->employment_details->depertment_id);
                //             ->where('dept_post_id', $logged_user->employment_details->dept_post_id);
                //     })->whereHas('preferences_district', function ($query) use ($logged_user) {
                //         $query->where('district_id', $logged_user->employment_details->district_id);
                //     })
                //     ->with(['employment_details', 'preferences_district'])
                //     ->get();

                // Group users by their employment district and count them
                // $groupedUsers = $related_users->groupBy(function ($user) {
                //     return $user->employment_details->district_id; // Group by employment district
                // });
                // // Fill the counts for each preference district
                // foreach ($preferenceDistricts as $district) {
                //     $districtId = $district->district_id;
                //     $userCountsByEmploymentDistrict[$districtId] = $groupedUsers->has($districtId) ? $groupedUsers[$districtId]->count() : 0;
                // }

                // ------------------------ new code for count preference -------------
                $main_query = EmploymentDetailsModel::query()
                    ->with(['districts'])
                    ->whereIn('district_id', $preferenceDistricts->pluck('district_id')->toArray())
                    ->where('directorate_id', $logged_user->employment_details->directorate_id)
                    ->where('dept_post_id', $logged_user->employment_details->dept_post_id)
                    ->whereHas('user_credentials', function ($query) {
                        $query->where('profile_verify_status', 1)
                            ->where('noc_generate', 1);
                    })
                    ->whereHas('preference_district_employment', function ($query) use ($logged_user) {
                        $query->where('district_id', $logged_user->employment_details->district_id);
                    });
                $main_query->whereDoesntHave('employee_transfer_request_employment', function ($query) use ($logged_user) {
                    $query->where(function ($sub_query) use ($logged_user) {
                        $sub_query->where('target_employee_id', $logged_user->id)
                            ->where('request_status_by_target_emp', 2);
                    })->orWhere(function ($sub_query) {
                        $sub_query->whereIn('request_status', [0, 1])
                            ->whereIn('final_approval', [0, 1]);
                    });
                });
                $main_query->whereDoesntHave('employee_transfer_target_request_employment', function ($query)  use ($logged_user) {
                    $query->where(function ($sub_query) use ($logged_user) {
                        $sub_query->where('employee_id', $logged_user->id)
                            ->where('request_status_by_target_emp', 2);
                    })->orWhere(function ($sub_query) {
                        $sub_query->where('request_status', 1)
                            ->whereIn('final_approval', [0, 1]);
                    });
                });
                $main_query->selectRaw('COUNT(user_id) as total_user_id,district_id')
                    ->groupBy('district_id');
                $userCountsByEmploymentDistrict = [];
                $filter_count = $main_query->get();
                $districtCountMap = $filter_count->pluck('total_user_id', 'district_id')->toArray();
                foreach ($preferenceDistricts as $district) {
                    $userCountsByEmploymentDistrict[$district->district_id] =
                        $districtCountMap[$district->district_id] ?? 0;
                }
            }
        } catch (Exception $err) {
            // dd($err->getMessage());
            $view_data['is_error'] = true;
            $view_data['message'] = __('validation_message.server_message.server_error');
        }
        return view('employee_access.employee_dashboard', [
            'view_data' => $view_data,
            'profile_data' => $profile_data,
            'is_request_done' => $is_request_done,
            'transfer_data' => $transfer_data,
            'incomming_data_table' => $incomming_data_table,
            'preference_districts' => $preferenceDistricts,
            'count_by_prefernce_district' => $userCountsByEmploymentDistrict,
            'rejected_data' => $rejected_data
        ]);
    }








    // ------------------- search user profile for request -------------------


    public function searchUserProfile(Request $request, $lang = null, $preference_search_district = null)
    {
        $view_data = [
            'is_error' => false,

            'message' => null,
        ];
        $search_profile_table = [
            'employees_profiles' => [],

            'districts' => [],
            'logged_persion' => null,
            'preference_search_district' => null
        ];
        $search_profile_table_component = [
            'offices' => []
        ];
        try {
            App::setLocale(session::get('locale'));
            // $logged_persion = ReuseModule::getOneData(new UserCredentialsModel(), [
            //     ['id', Auth::guard('user_guard')->user()->user_id]
            // ]);
            $is_request_done = EmployeeModule::isTransferDone();
            if ($is_request_done->exists()) {
                return redirect(app()->getLocale() . '/employees/dashboard');
            }
            $logged_persion = Auth::guard('user_guard')->user()->user_credentials;
            // $search_profile_table_component['offices'] = ReuseModule::getAllData(new OfficeFinAsssamModel(), [
            //     ['department_id', $logged_persion->employment_details->depertment_id]
            // ]);
            if (!$logged_persion) {
                $view_data['is_error'] = true;
                $view_data['message'] = "Logged user details not found !";
            } else {
                if ($logged_persion->profile_verify_status == 1 && $logged_persion->noc_generate == 1) {
                    $check_request_status = EmployeeModule::isRequestProcess()->first();
                    $search_profile_table['districts'] = $logged_persion->preferences_district()->whereHas('districts')->get();
                    // $search_profile_table_component['offices'] = OfficeFinAsssamModel::query()
                    //     ->whereIn('district_id', $search_profile_table['districts']->pluck('district_id')->toArray())
                    //     ->where('department_id', $logged_persion->employment_details->depertment_id)
                    //     ->get();

                    $search_profile_table_component['offices'] = OfficesDistDeptModel::query()
                        ->with(['office_fin_assam'])
                        ->whereIn('district_id', $search_profile_table['districts']->pluck('district_id')->toArray())
                        ->where('depertment_id', $logged_persion->employment_details->depertment_id)
                        ->select('office_id')
                        ->distinct()
                        ->get();
                    // dd($search_profile_table_component['offices']);
                    $conditions = [
                        ['user_id', $logged_persion->id]
                    ];
                    // $logged_employment_details = ReuseModule::getOneData(new EmploymentDetailsModel(), $conditions);
                    $conditions = [
                        ['profile_verify_status', 1],
                        ['noc_generate', 1],
                        ['id', '!=', $logged_persion->id]
                    ];
                    $related_models = [
                        'documents' => [
                            ['document_type', 1]
                        ],
                        'employment_details.departments' => [],
                        'employment_details.districts' => [],
                        'employment_details.offices_finassam' => [],
                    ];
                    $with_conditions = [
                        'documents' => function ($query) {
                            $query->where('document_type', 1);
                        },
                        'employment_details' => function ($query) {
                            $query->select('id', 'user_id', 'district_id', 'office_id', 'designation_id', 'depertment_id');
                        },
                        'preferences_district' => function ($query) {},
                        'employment_details.offices_finassam' => function ($query) {
                            $query->select('id', 'name', 'ddo', 'department_id');
                        },

                    ];
                    $preference_search_district = $preference_search_district ? Crypt::decryptString($preference_search_district) : null;
                    $check_search = true;
                    if ($preference_search_district) {
                        if (!in_array($preference_search_district, $search_profile_table['districts']->pluck('district_id')->toArray())) {
                            $check_search = false;
                        }
                    }
                    if ($check_search) {
                        $search_profile_table['preference_search_district'] = $preference_search_district;
                        $main_query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, $related_models, $with_conditions);
                        $logged_users = $logged_persion;
                        $main_query->whereHas('preferences_district', function ($query) use ($logged_users) {
                            $query->where('district_id', $logged_users->employment_details->district_id);
                        });
                        $main_query->whereHas('employment_details', function ($query) use ($logged_users, $preference_search_district) {
                            if ($preference_search_district) {
                                $query->where('district_id', $preference_search_district);
                            } else {
                                $query->whereIn('district_id', $logged_users->preferences_district->pluck('district_id')->toArray());
                            }
                            // $query->where('depertment_id', $logged_users->employment_details->depertment_id);
                            $query->where('dept_post_id', $logged_users->employment_details->dept_post_id)
                                ->where('directorate_id', $logged_users->employment_details->directorate_id);
                        });
                        $main_query->whereDoesntHave('employee_transfer_request', function ($query) use ($logged_users) {
                            $query->where(function ($sub_query) use ($logged_users) {
                                $sub_query->where('target_employee_id', $logged_users->id)
                                    ->where('request_status_by_target_emp', 2);
                            })->orWhere(function ($sub_query) {
                                $sub_query->whereIn('request_status', [0, 1])
                                    ->whereIn('final_approval', [0, 1]);
                            });
                        });
                        $main_query->whereDoesntHave('employee_transfer_target_request', function ($query)  use ($logged_users) {
                            $query->where(function ($sub_query) use ($logged_users) {
                                $sub_query->where('employee_id', $logged_users->id)
                                    ->where('request_status_by_target_emp', 2);
                            })->orWhere(function ($sub_query) {
                                $sub_query->where('request_status', 1)
                                    ->whereIn('final_approval', [0, 1]);
                            });
                        });
                        $search_filter_data = $main_query->get();
                        // $search_all_data = $main_query->get();
                        // dd($search_all_data);
                        // $search_filter_data = [];
                        // foreach ($search_all_data as $all_data) {
                        //     if (!EmployeeModule::isRequestProcess($all_data->id)->exists()) {
                        //         $search_filter_data[] = $all_data;
                        //     }
                        // }
                        $search_profile_table['employees_profiles'] = $search_filter_data;
                    } else {
                        $view_data['is_error'] = true;
                        $view_data['message'] = __('transfer_messages.transfer_message.prefence_district');
                    }
                } else {
                    $view_data['is_error'] = true;
                    $view_data['message'] = __('transfer_messages.transfer_message.varification');
                }
            }
            $view_data['logged_persion'] = $logged_persion;
        } catch (Exception $err) {
            $view_data['is_error'] = true;
            $view_data['message'] = __('validation_message.server_message.server_error');
            // dd($err->getMessage());
        }
        return view('employee_access.search_profile', [
            'view_data' => $view_data,
            'search_profile_table' => $search_profile_table,
            'search_profile_table_component' => $search_profile_table_component
        ]);
    }
    // ------------------------------ Request profile for transfer ----------------
    public function requestTransferProfile(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => null,
                'check' => false
            ];
            $incomming_request = [
                // 'request_confirmation' => 'required',
                // 'sop_confirmation' => 'required',
                'target_employee' => 'required'
            ];
            $validate = ReuseModule::validateIncomingData($request, $incomming_request, $request->all());
            if ($validate->fails()) {
                $res_data['message'] = $validate->errors()->all();
            } else {
                $target_employee_id = '';
                try {
                    App::setLocale(session::get('locale'));
                    $res_data['status'] = 401;
                    $target_employee_id = Crypt::decryptString($request->target_employee);
                    // $logged_user = ReuseModule::getOneData(new UserCredentialsModel(), [
                    //     ['id', Auth::guard('user_guard')->user()->user_id]
                    // ]);
                    $logged_user = Auth::guard('user_guard')->user();
                    if ($logged_user->user_credentials) {
                        if ($logged_user->user_credentials->profile_verify_status == 1 && $logged_user->user_credentials->noc_generate == 1) {
                            // $check_request_status = $logged_user->user_credentials->employee_transfer_request()->whereIn('request_status', [0, 1])->first();
                            $check_request_status = EmployeeModule::isRequestProcess()->first();
                            if ($check_request_status) {
                                $res_data['message'] = __('transfer_messages.transfer_message.your_pendding_request');
                            } else {
                                $check_target_request_status = EmployeeModule::isRequestProcess($target_employee_id);
                                if ($check_target_request_status->exists()) {
                                    $res_data['message'] = __('transfer_messages.transfer_message.target_pendding_request');
                                } else {
                                    if (EmployeeModule::isRejectionByEmp($logged_user->user_credentials->id, $target_employee_id)->exists()) {
                                        $res_data['message'] = __('transfer_messages.transfer_message.one_rejection');
                                    } else {
                                        $conditions = [
                                            ['id', $target_employee_id],
                                            ['profile_verify_status', 1],
                                            ['noc_generate', 1],
                                        ];
                                        $with_conditions = [
                                            'employment_details' => function ($query) {},
                                            'preferences_district' => function ($query) {}
                                        ];
                                        $main_query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, [], $with_conditions);
                                        $main_query->whereHas('employment_details', function ($query) use ($logged_user) {
                                            $query->whereIn('district_id', $logged_user->user_credentials->preferences_district->pluck('district_id')->toArray())
                                                ->where('dept_post_id', $logged_user->user_credentials->employment_details->dept_post_id)
                                                ->where('directorate_id', $logged_user->user_credentials->employment_details->directorate_id);
                                            // ->where('depertment_id', $logged_user->user_credentials->employment_details->depertment_id);
                                        })->whereHas('preferences_district', function ($query) use ($logged_user) {
                                            $query->where('district_id', $logged_user->user_credentials->employment_details->district_id);
                                        });
                                        // $target_employee_details = ReuseModule::getOneData(new UserCredentialsModel(), [
                                        //     ['id', $target_employee_id]
                                        // ]);
                                        if ($main_query->exists()) {
                                            $check_target_emp_apply = ReuseModule::getOneData(new TransfersModel(), [
                                                ['target_employee_id', $logged_user->user_credentials->id],
                                                ['employee_id', $target_employee_id],
                                                ['request_status', 0]
                                            ]);
                                            if ($check_target_emp_apply) {
                                                $res_data['message'] = __('transfer_messages.transfer_message.already_sent_by_target');
                                            } else {
                                                $save_data = TransfersModel::create([
                                                    'employee_id' => $logged_user->user_credentials->id,
                                                    'target_employee_id' => $target_employee_id
                                                ]);
                                                $res_data['message'] = __('transfer_messages.transfer_message.request_sent');
                                                $res_data['status'] = 200;
                                            }
                                        } else {
                                            $res_data['message'] = __('transfer_messages.transfer_message.preference_conditions');
                                        }
                                    }
                                    // if ($target_employee_details) {
                                    //     if ($target_employee_details->profile_verify_status == 1 && $target_employee_details->noc_generate == 1) {

                                    //         $check_preference = $logged_user->user_credentials->preferences_district()->where('district_id', $target_employee_details->employment_details->district_id);
                                    //         if ($check_preference->first()) {
                                    //             $check_target_prefence = $target_employee_details->preferences_district()->where('district_id', $logged_user->user_credentials->employment_details->district_id)->first();
                                    //             if ($check_target_prefence) {
                                    //                 $save_data = TransfersModel::create([
                                    //                     'employee_id' => $logged_user->user_credentials->id,
                                    //                     'target_employee_id' => $target_employee_id
                                    //                 ]);
                                    //                 $res_data['message'] = "Request Submitted !";
                                    //                 $res_data['status'] = 200;
                                    //             } else {
                                    //                 $res_data['message'] = "No target preference found !";
                                    //             }
                                    //         } else {
                                    //             $res_data['message'] = "No preference found !";
                                    //         }
                                    //     } else {
                                    //         $res_data['message'] = "Target employee is not verified !";
                                    //     }
                                    // } else {
                                    //     $res_data['message'] = "Target employee has lost details !";
                                    // }
                                }
                            }
                        } else {
                            $res_data['message'] = __('transfer_messages.transfer_message.pendding_profile_verify');
                        }
                    } else {
                        $res_data['message'] = __('validation_message.authentication_message.session_expire');
                    }
                } catch (Exception $err) {
                    // $res_data['message']="Server error please try later !";
                    $res_data['message'] = __('validation_message.server_message.server_error'); //$err->getMessage();
                    // $res_data['message']=$err->getMessage();
                }
            }
            return response()->json(['res_data' => $res_data]);
        }
    }

    // ------------------- download NOC by user -----------------
    public function downloadNOCByUser(Request $request)
    {
        $view_data = [
            'is_error' => false,
            'message' => null,
            'noc_details' => null
        ];
        try {
            App::setLocale(session::get('locale'));
            $logged_user = Auth::guard('user_guard')->user();
            $conditions = [
                ['profile_verify_status', 1],
                ['noc_generate', 1],
                ['id', $logged_user->user_credentials->id]
            ];
            $related_models = [
                'employment_details' => [],
                'employment_details.post_names' => [],
                'employment_details.offices_finassam' => [],
                'employment_details.departments' => [],
                'employment_details.districts' => [],
                // 'noc_generated_by_user'=>[],
                // 'noc_generated_by_user.post_names'=>[]
            ];
            $with_conditions = [
                'employment_details' => function ($query) {
                    $query->select('id', 'user_id', 'district_id', 'depertment_id', 'office_id', 'designation_id', 'pay_grade');
                },
                'employment_details.post_names' => function ($query) {},
                'employment_details.offices_finassam' => function ($query) {
                    $query->select('id', 'name', 'department_id');
                },
                'employment_details.districts' => function ($query) {},
                'employment_details.departments' => function ($query) {},
                'noc_generated_by_user' => function ($query) {
                    $query->select('id', 'name', 'designation');
                },
                'noc_generated_by_user.post_names' => function ($query) {}
            ];
            $main_query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, $related_models, $with_conditions);
            if ($main_query->exists()) {
                $view_data['noc_details'] = $main_query->first();
            } else {
                $view_data['message'] = __('transfer_messages.transfer_message.no_record');
                $view_data['is_error'] = true;
            }
        } catch (Exception $err) {
            // dd($err->getMessage());
            $view_data['message'] = __('validation_message.server_message.server_error');
            $view_data['is_error'] = true;
        }
        $pdf = Pdf::loadView('pdfs.noc', [
            'view_data' => $view_data
        ]);
        // $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('noc.pdf', [
            'view_data' => $view_data
        ]);

        // return $pdf->download('JTS.pdf');
    }
    // ------------- transfer history index page --------------
    public function transferHistoryIndex(Request $request)
    {
        return view('employee_access.transfer_history');
    }
}
