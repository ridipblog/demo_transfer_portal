<?php

namespace  App\our_modules\employees_modules;
class EmployeeSearchModule{
    public $profile_conditions = [
        ['profile_verify_status', 1],
        ['noc_generate', 1],
    ];
    public $loggedUser;
    public function __construct($loggedUser=null)
    {
        $this->loggedUser=$loggedUser;
        $this->profile_conditions[]=['id', '!=', $this->loggedUser->id];

        // $conditions = [
        //     ['user_id', $logged_user->id]
        // ];
        // $logged_employment_details = ReuseModule::getOneData(new EmploymentDetailsModel(), $conditions);
        // $taget_employee_employment_details=ReuseModule::getOneData(new EmploymentDetailsModel(), [
        //     ['user_id',$target_employee_id]
        // ]);
        // if ($logged_employment_details && $taget_employee_employment_details) {
        //     $conditions = [
        //         ['employee_id', $logged_user->id],
        //         ['request_status','!=',0],
        //         ['request_status','!=',1]
        //     ];
        //     $related_models = [
        //         'transfer_employee_user' => [
        //             ['profile_verify_status', 1],
        //             ['noc_generate', 1],
        //         ],
        //         'transfer_employee_target_user'=>[
        //             ['profile_verify_status', 1],
        //             ['noc_generate', 1],
        //             ['id',$target_employee_id]
        //         ],
        //         'transfer_employee_target_user.employment_details'=>[
        //             ['depertment_id',$logged_employment_details->depertment_id]
        //         ],
        //         'transfer_employee_user.preferences_district'=>[
        //             ['district_id',$taget_employee_employment_details->district_id]
        //         ]
        //     ];
        //     $with_conditions = [
        //         'transfer_employee_user'=>function($query){},
        //         'transfer_employee_target_user'=>function($query){},
        //         'transfer_employee_target_user.employment_details' => function ($query) {},
        //         'transfer_employee_target_user.preferences_district' => function ($query) {}
        //     ];
        //     $main_query = EmployeeModule::dynamicOneModelsQuery(new TransfersModel(), $conditions,$related_models,$with_conditions);
        //     $check_request_condition = $main_query->first();
    }
}
