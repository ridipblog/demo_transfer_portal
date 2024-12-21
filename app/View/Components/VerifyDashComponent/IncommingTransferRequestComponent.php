<?php

namespace App\View\Components\VerifyDashComponent;

use App\Models\Transfer\TransfersModel;
use App\our_modules\employees_modules\EmployeeModule;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class IncommingTransferRequestComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $incommingDataTable;
    public function __construct($incommingDataTable = null)
    {
        $this->incommingDataTable=$incommingDataTable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // $incomming_data_table = [
        //     'is_error' => false
        // ];
        // try {
        //     $logged_user = Auth::guard('user_guard')->user();
        //     $conditions = [
        //         ['target_employee_id', $logged_user->user_id],
        //     ];
        //     $related_models = [
        //         'transfer_employee_user' => [],
        //         'transfer_employee_user.documents' => [
        //             ['document_type', 1]
        //         ],
        //         'transfer_employee_user.employment_details.departments' => [],
        //         'transfer_employee_user.employment_details.districts' => []
        //     ];
        //     $with_conditions = [
        //         'transfer_employee_user' => function ($query) {},
        //         'transfer_employee_user.documents' => function ($query) {
        //             $query->where('document_type', 1);
        //         },
        //         'transfer_employee_user.employment_details.departments' => function ($query) {},
        //         'transfer_employee_user.employment_details.districts' => function ($query) {}
        //     ];
        //     $main_query = EmployeeModule::dynamicOneModelsQuery(new TransfersModel(), $conditions, $related_models, $with_conditions);
        //     // ------------- start latest code add here ---------------
        //     // $main_query->whereIn('request_status',[1,2]);
        //     $main_query->where('request_status',0);
        //     // ------------- end latest code add here ---------------
        //     $main_query->orderBy('id','desc')->take(5);
        //     $incomming_data_table['incomming_requests'] = $main_query->get();
        //     $incomming_data_table['is_request_process'] = EmployeeModule::isRequestProcess()->first();
        // } catch (Exception $err) {
        //     $incomming_data_table['is_error'] = true;
        // }
        // return view('components.verify-dash-component.incomming-transfer-request-component', [
        //     'incommincomming_data_tableing_data_table' => $incomming_data_table
        // ]);


        return view('components.verify-dash-component.incomming-transfer-request-component');
    }
}
