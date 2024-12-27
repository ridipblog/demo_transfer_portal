<?php

namespace  App\our_modules\employees_modules;

use App\Models\Transfer\TransfersModel;
use App\Models\trash\RejectedDocumentsModel;
use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Support\Facades\Auth;

class EmployeeModule
{
    public $loggedUser;
    public $logged_employment_details;
    public $profile_conditions = [
        ['profile_verify_status', 1],
        ['noc_generate', 1],
    ];
    public $profile_related_module = [];
    public function __construct($loggedUser = null, $logged_employment_details = null)
    {
        $this->loggedUser = $loggedUser;
        $this->logged_employment_details = $logged_employment_details;
        $this->profile_conditions[] = ['id', '!=', $this->loggedUser->id];
        $this->profile_related_module = [
            'employment_details' => [
                ['depertment_id', $this->logged_employment_details->depertment_id],
            ],
            'documents' => [
                ['document_type', 1]
            ],
            'preferences_district' => [
                ['district_id', $this->logged_employment_details->district_id]
            ]
        ];
    }
    // -------------------- fetch all employee data -----------------
    public static function getEmployeesAllData($conditions = null)
    {
        $query = UserCredentialsModel::query()->with(
            [
                'persional_details',
                'persional_details.caste',
                'employment_details',
                'employment_details.districts',
                'employment_details.departments',
                'employment_details.offices_finassam',
                'employment_details.post_names',
                'preferences_district',
                'preferences_district.districts',
                'additional_info',
                'documents' => function ($sub_query) {
                    $sub_query->orderBy('document_type', 'asc');
                }
            ]
        )
            ->whereHas('persional_details')
            ->whereHas('employment_details')
            ->whereHas('additional_info')
            ->where($conditions);
        return $query;
    }
    // ----------------- fetch dynamic data ----------------
    public static function dynamicOneModelsQuery($model, $conditions = [], $related_models = null, $with_conditions = null)
    {
        $main_query = $model::query();
        if ($related_models || $with_conditions) {
            // -------------------- frist code -----------------
            // $main_query->with($related_models ? array_keys($related_models) : ['']);
            // foreach ($related_models as $model_name => $condition) {
            //     $main_query->whereHas($model_name, function ($sub_query) use ($condition) {
            //         $sub_query->where($condition);
            //     });
            // }
            // --------------------- second code ----------------------
            $main_query->with($with_conditions ? $with_conditions : ($related_models ? array_keys($related_models) : ['']));
            foreach ($related_models as $model_name => $condition) {
                $main_query->whereHas($model_name, function ($sub_query) use ($condition) {
                    $sub_query->where($condition);
                });
            }
        }
        $main_query->where($conditions);
        return $main_query;
    }
    // ---------------- search employee profile configuration -------------
    public function fetchSearchProfile() {}
    // --------------------- is request process meaning 0 or 1 request status ----------------
    public static function isRequestProcess($user_id = null)
    {
        $check_id = null;
        if ($user_id) {
            $check_id = $user_id;
        } else {
            $check_id = Auth::guard('user_guard')->user()->user_id;
        }
        $main_query = TransfersModel::query();


        $main_query->where(function ($query) use ($check_id) {
            $query->where('employee_id', $check_id)
                ->whereIn('request_status', [0, 1])
                ->whereIn('final_approval', [0, 1]);
        })->orWhere(function ($query) use ($check_id) {
            $query->where('target_employee_id', $check_id)
                ->where('request_status', 1)
                ->whereIn('final_approval', [0, 1]);
        });



        return $main_query;
        // $main_query->where(function($first_query) use($logged_user){
        //     $first_query->where(function ($query) use ($logged_user) {
        //         $query->where('employee_id', $logged_user->user_id)
        //             ->whereIn('request_status', [0, 1]);
        //     })->orWhere(function ($query) use ($logged_user) {
        //         $query->where('target_employee_id', $logged_user->user_id)
        //             ->where('request_status', 1);
        //     });
        // });
        // if($main_query->exists()){

        //     // $main_query->where(function($second_query) use($logged_user){
        //     //     $second_query->where(function ($query) use ($logged_user) {
        //     //         $query->where('employee_id', $logged_user->user_id)
        //     //             ->orWhere('target_employee_id', $logged_user->user_id);
        //     //     })->whereIn('final_approval', [0,1]);
        //     // });

        //     // ---------------- better code i thought -----------------
        //     $main_query->where(function($second_query) use($logged_user){
        //         $second_query->where(function ($query) use ($logged_user) {
        //             $query->where('employee_id', $logged_user->user_id)
        //             ->whereIn('final_approval', [0,1]);
        //         })->orWhere(function($query) use($logged_user){
        //             $query->where('target_employee_id',$logged_user->user_id)
        //             ->whereIn('final_approval', [0,1]);
        //         });
        //     });
        //     return $main_query;
        // }else{
        //     return $main_query;
        // }


        // --------------- old code -----------------
        // $main_query = TransfersModel::where(function ($query) use ($logged_user) {
        //     $query->where('employee_id', $logged_user->user_id)
        //         ->whereIn('request_status', [0, 1]);
        // })->orWhere(function ($query) use ($logged_user) {
        //     $query->where('target_employee_id', $logged_user->user_id)
        //         ->where('request_status', 1);
        // });
        // return $main_query;
    }
    // ------------- is any rejection by employees ---------------
    public static function isRejectionByEmp($user_id, $target_id)
    {
        $main_query = TransfersModel::query();
        $main_query->whereIn('employee_id', [$user_id, $target_id])
            ->whereIn('target_employee_id', [$user_id, $target_id])
            ->where('request_status_by_target_emp', 2)
            ->where('request_status', 2);
        return $main_query;
    }
    // --------------- is transfer request done --------------------
    public static function isTransferDone($user_id = null)
    {
        $check_id = null;
        if ($user_id) {
            $check_id = $user_id;
        } else {
            $check_id = Auth::guard('user_guard')->user()->user_id;
        }
        $main_query = TransfersModel::query();
        $main_query->where(function ($query) use ($check_id) {
            $query->where('employee_id', $check_id)
                ->where('request_status', 1)
                ->where('final_approval', 1);
        })->orWhere(function ($query) use ($check_id) {
            $query->where('target_employee_id', $check_id)
                ->where('request_status', 1)
                ->where('final_approval', 1);
        });
        return $main_query;
    }
    // ------------------ fetch transfer employees details ------------------
    public static function transferEmployeesDetails($conditions = [])
    {
        $related_models = [

            // 'transfer_employee_user' => [],
            // 'transfer_employee_user.noc_generated_by_user' => [],
            // 'transfer_employee_user.noc_generated_by_user.post_names' => [],
            // 'transfer_employee_user.employment_details' => [],
            // 'transfer_employee_target_user' => [],
            // 'transfer_employee_target_user.noc_generated_by_user' => [],
            // 'transfer_employee_target_user.noc_generated_by_user.post_names' => [],
            // 'transfer_employee_target_user.employment_details' => [],
            // 'transfer_employee_user.employment_details.post_names' => [],
            // 'transfer_employee_user.employment_details.offices_finassam' => [],
            // 'transfer_employee_user.employment_details.departments' => [],
            // 'transfer_employee_user.employment_details.districts' => [],
            // 'transfer_employee_target_user.employment_details.post_names' => [],
            // 'transfer_employee_target_user.employment_details.offices_finassam' => [],
            // 'transfer_employee_target_user.employment_details.districts' => [],
            // 'transfer_employee_target_user.employment_details.departments' => [],

            // 'appointing_authorities'=>[]
        ];
        $with_conditions = [
            'transfer_employee_user' => function ($query) {
                $query->select('id', 'full_name', 'noc_generated_by');
            },
            'transfer_employee_target_user' => function ($query) {
                $query->select('id', 'full_name', 'noc_generated_by');
            },
            'transfer_employee_user.noc_generated_by_user' => function ($query) {},
            // 'transfer_employee_user.noc_generated_by_user.post_names' => function ($query) {},
            'transfer_employee_user.noc_generated_by_user.departments' => function ($query) {},
            'transfer_employee_user.noc_generated_by_user.districts' => function ($query) {},
            'transfer_employee_user.employment_details' => function ($query) {
                $query->select('id', 'user_id', 'district_id', 'depertment_id', 'office_id', 'designation_id', 'pay_grade', 'pay_band','directorate_id');
            },
            'transfer_employee_target_user.noc_generated_by_user' => function ($query) {},
            // 'transfer_employee_target_user.noc_generated_by_user.post_names' => function ($query) {},
            'transfer_employee_target_user.noc_generated_by_user.departments' => function ($query) {},
            'transfer_employee_target_user.noc_generated_by_user.districts' => function ($query) {},
            'transfer_employee_target_user.employment_details' => function ($query) {
                $query->select('id', 'user_id', 'district_id', 'depertment_id', 'office_id', 'designation_id', 'pay_grade', 'pay_band','directorate_id');
            },
            'transfer_employee_user.employment_details.post_names' => function ($query) {},
            'transfer_employee_target_user.employment_details.post_names' => function ($query) {},
            'transfer_employee_user.employment_details.offices_finassam' => function ($query) {
                $query->select('id', 'name', 'department_id');
            },
            'transfer_employee_target_user.employment_details.offices_finassam' => function ($query) {
                $query->select('id', 'name', 'department_id');
            },
            'transfer_employee_user.employment_details.districts' => function ($query) {},
            'transfer_employee_target_user.employment_details.districts' => function ($query) {},
            'transfer_employee_user.employment_details.departments' => function ($query) {},
            'transfer_employee_user.employment_details.directorate' => function ($query) {},
            'transfer_employee_target_user.employment_details.departments' => function ($query) {},
            'transfer_employee_target_user.employment_details.directorate' => function ($query) {},
            'transfer_employee_user.documents' => function ($query) {
                $query->where('document_type', 2);
            },
            'transfer_employee_target_user.documents' => function ($query) {
                $query->where('document_type', 2);
            },
            'appointing_authorities' => function ($query) {
                $query->select('id', 'name', 'designation');
            },
        ];
        $main_query = EmployeeModule::dynamicOneModelsQuery(new TransfersModel(), $conditions, $related_models, $with_conditions);
        return $main_query;
    }
}
