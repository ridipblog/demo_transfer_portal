<?php

namespace App\View\Components\employees;

use App\Models\User_auth\UserCredentialsModel;
use App\our_modules\employees_modules\EmployeeModule;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileStatusComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $viewData;
    public $profileData;
    public $isRequestDone;
    public $transferData;
    public function __construct($viewData = null,$profileData=null,$isRequestDone=null,$transferData=null)
    {
        $this->viewData=$viewData;
        $this->profileData=$profileData;
        $this->isRequestDone=$isRequestDone;
        $this->transferData=$transferData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // $conditions = [
        //     ['id', $this->viewData->id]
        // ];
        // $related_models = [
        //     'documents' => [
        //         ['document_type', 1]
        //     ]
        // ];
        // $with_conditions = [
        //     'documents' => function ($query) {
        //         $query->where('document_type', 1);
        //     }
        // ];
        // $query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, $related_models, $with_conditions);
        // $profile_data = $query->first();
        // return view('components.employees.profile-status-component', [
        //     'profile_details' => $profile_data
        // ]);

        return view('components.employees.profile-status-component');
    }
}
