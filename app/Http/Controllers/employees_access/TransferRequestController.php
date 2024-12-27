<?php

namespace App\Http\Controllers\employees_access;

use App\Http\Controllers\Controller;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Transfer\TransfersModel;
use App\Models\User_auth\UserCredentialsModel;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransferRequestController extends Controller
{


    public function requestCancel(Request $request)
    {
        if ($request->ajax()) {
            date_default_timezone_set('Asia/Kolkata');
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            $transfer_id = $request->request_id;
            try {
                App::setLocale(session::get('locale'));
                $res_data['status'] = 401;
                $logged_user = Auth::guard('user_guard')->user();
                $transfer_id = Crypt::decryptString($transfer_id);
                $main_query = TransfersModel::where([
                    ['id', $transfer_id],
                    ['employee_id', $logged_user->user_credentials->id],
                    ['request_status', 0]
                ]);
                if ($main_query->exists()) {
                    $main_query->update([
                        'request_status' => 2,
                        'remarks' => 'self rejected '
                    ]);
                    $res_data['status'] = 200;
                    $res_data['message'] = __('transfer_messages.transfer_message.request_cancel');
                } else {
                    $res_data['message'] = __('transfer_messages.transfer_message.details_not_found');
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    public function actionOnrequest(Request $request)
    {
        if ($request->ajax()) {
            date_default_timezone_set('Asia/Kolkata');
            $res_data = [
                'status' => 400,
                'message' => null
            ];
            $transfer_id = $request->request_id;
            try {
                App::setLocale(session::get('locale'));
                $res_data['status'] = 401;
                $logged_user = Auth::guard('user_guard')->user();
                $transfer_id = Crypt::decryptString($transfer_id);
                $main_query = TransfersModel::query()->with(['transfer_employee_user' => function ($query) {
                    $query->select('id', 'phone');
                }])->where([
                    ['id', $transfer_id],
                    ['target_employee_id', $logged_user->user_credentials->id],
                    ['request_status', 0],
                    ['final_approval', 0]
                ])->whereHas('transfer_employee_user', function ($query) {});
                if ($main_query->exists()) {
                    if (in_array($request->request_action, ['accept', 'reject'])) {
                        $check_request_status = EmployeeModule::isRequestProcess()->first();
                        if ($request->request_action != "reject" && $check_request_status) {
                            $res_data['message'] = __('transfer_messages.transfer_message.your_pendding_request');
                        } else {
                            $ref_emp_code = strlen($transfer_id);
                            $struct_ref = 'JTO/03/000000';
                            $transfer_ref_code = substr_replace($struct_ref, $transfer_id, -$ref_emp_code);
                            $request_employee = $main_query->first();
                            if ($request->request_action != "reject" && EmployeeModule::isRejectionByEmp($logged_user->user_credentials->id, $request_employee->employee_id)->exists()) {
                                $res_data['message'] = __('transfer_messages.transfer_message.one_rejection');
                            } else {
                                $main_query->update([
                                    'request_status' => $request->request_action == "accept" ? 1 : 2,
                                    'request_status_by_target_emp' => $request->request_action == "accept" ? 0 : 2,
                                    'transfer_ref_code' => $request->request_action == "accept" ? $transfer_ref_code : null
                                ]);

                                if (isset($request_employee->transfer_employee_user->phone)) {
                                    if ($request->request_action == "accept") {
                                        // dd($request_employee->transfer_employee_user->phone);
                                        ReuseModule::JointTransferOrderMessage($request_employee->transfer_employee_user->phone);
                                    } else {
                                        ReuseModule::JointTransferOrderMessageReject($request_employee->transfer_employee_user->phone);
                                    }
                                }
                                $res_data['status'] = 200;
                                $action_text = $request->request_action == "accept" ? "accepted " : "rejected";
                                if ($request->request_action == "accept") {
                                    $dynamic_action_text = __('transfer_messages.transfer_message.accepted');
                                } else {
                                    $dynamic_action_text = __('transfer_messages.transfer_message.rejected');
                                }
                                $res_data['message'] = __('transfer_messages.transfer_message.action_pre_text') . $dynamic_action_text;
                            }
                        }
                    } else {
                        $res_data['message'] = __('transfer_messages.transfer_message.no_action');
                    }
                } else {
                    $res_data['message'] = __('transfer_messages.transfer_message.details_not_found');
                }
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = __('validation_message.server_message.server_error');
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ----------------- search profiles by input and select -------------
    public function searchProfileAPI(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 400,
                'message' => '',
                'employees_profiles' => []
            ];
            try {
                App::setLocale(session::get('locale'));
                $logged_persion = Auth::guard('user_guard')->user()->user_credentials;
                if (!$logged_persion) {
                    $res_data['message'] = "Logged user details not found !";
                } else {
                    if ($logged_persion->profile_verify_status == 1 && $logged_persion->noc_generate == 1) {
                        // $check_request_status = EmployeeModule::isRequestProcess()->first();
                        $conditions = [
                            ['user_id', $logged_persion->id]
                        ];
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
                            'employment_details.offices_finassam' => []
                        ];
                        $with_conditions = [
                            'documents' => function ($query) {
                                $query->where('document_type', 1);
                            },
                            'persional_details' => function ($query) {
                                $query->select('id', 'user_id', 'pan_number');
                            },
                            'employment_details' => function ($query) {
                                $query->select('id', 'user_id', 'district_id', 'office_id', 'designation_id', 'depertment_id');
                            },
                            'preferences_district' => function ($query) {},
                            'employment_details.offices_finassam' => function ($query) {
                                $query->select('id', 'name', 'ddo', 'department_id');
                            }
                        ];
                        if ($request->search_district_id ? (!in_array($request->search_district_id, $logged_persion->preferences_district->pluck('district_id')->toArray())) : false) {
                            $res_data['message'] = "Selected district is not in your preference list";
                        } else {
                            $main_query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, $related_models, $with_conditions);
                            $logged_users = $logged_persion;
                            $main_query->whereHas('preferences_district', function ($query) use ($logged_users) {
                                $query->where('district_id', $logged_users->employment_details->district_id);
                            });
                            if ($request->search_type == "by_input") {
                                if ($request->search_pan_number) {
                                    $main_query->where(function ($sub_query) use ($request) {
                                        $sub_query->where('full_name', 'like', '%' . $request->search_pan_number . '%')
                                            ->orWhereHas('persional_details', function ($query) use ($request) {
                                                $query->where('pan_number', 'like', '%' . $request->search_pan_number . '%');
                                            });
                                    });

                                    // $main_query->whereHas('persional_details', function ($query) use ($request) {
                                    //     $query->where('pan_number', 'like', '%' . $request->search_pan_number . '%');
                                    // });
                                }
                            } else if ($request->search_type == "by_select") {
                                $select_options = [
                                    'district_id' => $request->search_district_id,
                                    'office_id' => $request->search_office_id,
                                    'designation_id' => $request->search_designation_id
                                ];
                                foreach ($select_options as $key => $value) {
                                    if ($value) {
                                        $main_query->whereHas('employment_details', function ($query) use ($key, $value) {
                                            $query->where($key, $value);
                                        });
                                    }
                                }
                            }
                            if (!$request->search_district_id) {
                                $main_query->whereHas('employment_details', function ($query) use ($logged_users) {
                                    $query->whereIn('district_id', $logged_users->preferences_district->pluck('district_id')->toArray());
                                });
                            }
                            $main_query->whereHas('employment_details', function ($query) use ($request, $logged_users) {
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
                            $main_query->whereDoesntHave('employee_transfer_target_request', function ($query) use ($logged_users) {
                                $query->where(function ($sub_query) use ($logged_users) {
                                    $sub_query->where('employee_id', $logged_users->id)
                                        ->where('request_status_by_target_emp', 2);
                                })->orWhere(function ($sub_query) {
                                    $sub_query->where('request_status', 1)
                                        ->whereIn('final_approval', [0, 1]);
                                });
                            });

                            // ------------- start  multiple mutual transfer code not completed ----------------
                            // $main_query->where(function ($query) use($logged_users) {
                            //     // Include records where no transfer data exists
                            //     $query->whereDoesntHave('employee_transfer_request')
                            //         ->whereDoesntHave('employee_transfer_target_request');

                            //     // Apply conditions on employee_transfer_request
                            //     $query->orWhereHas('employee_transfer_request', function ($sub_query) use($logged_users) {
                            //         $sub_query->where(function ($inner_query_2) use ($logged_users) {
                            //             $inner_query_2->where('request_status_by_target_emp', '!=', 2)
                            //                 ->where('target_employee_id', $logged_users->id);
                            //         })->orWhere(function($inner_query){
                            //             $inner_query->where(function ($inner_query) {
                            //                 $inner_query->where('final_approval', 1)
                            //                     ->where('updated_at', '<', now()->subMonths(2));
                            //             })->orWhere('final_approval', 2)
                            //             ->orWhere('request_status', 2);
                            //         });

                            //     });

                            //     // Apply conditions on employee_transfer_target_request
                            //     $query->orWhereHas('employee_transfer_target_request', function ($sub_query) use($logged_users){
                            //         $sub_query->where(function ($inner_query_2) use ($logged_users) {
                            //             $inner_query_2->where('request_status_by_target_emp', '!=', 2)
                            //                 ->where('employee_id', $logged_users->id);
                            //         })->where(function($inner_query){
                            //             $inner_query->where(function ($inner_query) {
                            //                 $inner_query->where('final_approval', 1)
                            //                     ->where('updated_at', '<', now()->subMonths(2));
                            //             })->orWhere('final_approval', 2)
                            //                 ->orWhere('request_status', 2);
                            //         });

                            //     });
                            // });

                            // ------------- end  multiple mutual transfer code not completed ----------------

                            $search_filter_data = $main_query->get();
                            // $search_all_data = $main_query->get();
                            // $search_filter_data = [];
                            // foreach ($search_all_data as $all_data) {
                            //     if (!EmployeeModule::isRequestProcess($all_data->id)->exists()) {
                            //         $search_filter_data[] = $all_data;
                            //     }
                            // }
                            $res_data['employees_profiles'] = $search_filter_data;
                            $res_data['status'] = 200;
                            return view('includes.search_profile_info', [
                                'employees_profiles' => $res_data['employees_profiles']
                            ])->render();
                        }
                    } else {
                        $res_data['message'] = __('transfer_messages.transfer_message.varification');
                    }
                }
            } catch (Exception $err) {
                $res_data['message'] = __('validation_message.server_message.server_error');
                // $res_data['message'] = 'Server error. Please try again!'; //$err->getMessage();
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
    // ------------------- download join transfer letter -----------------
    public function downloadJoinTransformLetter(Request $request, $transfer_id = null)
    {
        $trasnfer_employee_details = null;
        $view_data = [
            'is_error' => false,
            'message' => null,
            'trasnfer_employee_details' => null
        ];
        $conditions = [
            ['request_status', 1]
        ];
        try {
            App::setLocale(session::get('locale'));
            $logged_user = Auth::guard('user_guard')->user();
            $main_query = EmployeeModule::transferEmployeesDetails($conditions);
            // --------------- new code --------------
            $main_query->where('id', Crypt::decryptString($transfer_id));
            // ------------------ new code ------------------

            $main_query->where(function ($query) use ($logged_user) {
                $query->where('target_employee_id', $logged_user->user_credentials->id)
                    ->orWhere('employee_id', $logged_user->user_credentials->id);
            });
            $main_query->orderby('id', 'desc');
            // dd($main_query->first());
            if ($main_query->exists()) {
                $view_data['trasnfer_employee_details'] = $main_query->first();
            } else {
                $view_data['message'] = __('transfer_messages.transfer_message.no_record');
                $view_data['is_error'] = true;
            }
        } catch (Exception $err) {
            // dd($err->getMessage());
            $view_data['message'] = __('validation_message.server_message.server_error');
            $view_data['is_error'] = true;
        }
        $pdf = Pdf::loadView('pdfs.jts_format', [
            'view_data' => $view_data
        ]);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('JTS.pdf', ['view_data' => $view_data]);

        //return $pdf->download('JTS.pdf');
    }
    // ----------------- get offices name by district and depettment -------------------
    public function getOfficeByDistrict(Request $request)
    {
        if ($request->ajax()) {
            $res_data = [
                'status' => 401,
                'offices' => [],
                'message' => null
            ];
            try {

                $logged_user = Auth::guard('user_guard')->user();
                $preference_district = $logged_user->user_credentials->preferences_district()->whereHas('districts')->get();
                $main_query = OfficeFinAsssamModel::query()
                    ->where('department_id', $logged_user->user_credentials->employment_details->depertment_id);
                if ($request->query('district_id')) {
                    $main_query->where('district_id', $request->query('district_id'));
                } else {
                    $main_query->whereIn('district_id', $preference_district->pluck('district_id')->toArray());
                }
                $main_query->select('id', 'name', 'district_id', 'ddo', 'department_id');
                $res_data['offices'] = $main_query->get();
                $res_data['status'] = 200;
            } catch (Exception $err) {
                $res_data['status'] = 401;
                $res_data['message'] = "Server error please try later !";
                $res_data['message'] = $err->getMessage();
            }
            return response()->json(['res_data' => $res_data]);
        }
    }
}
