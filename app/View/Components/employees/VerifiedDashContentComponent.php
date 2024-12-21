<?php

namespace App\View\Components\employees;

use App\Models\Transfer\TransfersModel;
use App\our_modules\employees_modules\EmployeeModule;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VerifiedDashContentComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $viewData;
    public $transferData;
    public function __construct($viewData = null,$transferData=null)
    {
        $this->viewData = $viewData;
        $this->transferData=$transferData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // $is_error = false;
        // try {
        //     $conditions = [
        //         // ['employee_id',$this->viewData->id],
        //     ];
        //     $related_models = [
        //         'transfer_employee_user' => [],
        //         'transfer_employee_target_user' => [],
        //         'transfer_employee_user.employment_details.districts' => [],
        //         'transfer_employee_target_user.employment_details.districts' => [],
        //         'transfer_employee_target_user.employment_details.departments' => []
        //     ];
        //     $query = EmployeeModule::dynamicOneModelsQuery(new TransfersModel(), $conditions, $related_models);
        //     $query->where(function ($sub_query) {
        //         $sub_query->where('target_employee_id', $this->viewData->id)
        //             ->where('request_status', 1);
        //     });
        //     if ($query->exists()) {
        //         $query->orderBy('id', 'desc');
        //         $transfer_data = $query->first();
        //     } else {
        //         $query->orWhere(function ($sub_query) {
        //             $sub_query->where('employee_id', $this->viewData->id);
        //         });
        //         $query->orderBy('id', 'desc');
        //         $transfer_data = $query->first();
        //     }
        // } catch (Exception $err) {
        //     $is_error = true;
        // }
        // return view('components.employees.verified-dash-content-component', [
        //     'transfer_data' => $transfer_data,
        //     'is_error' => $is_error
        // ]);

        return view('components.employees.verified-dash-content-component');
    }
}
