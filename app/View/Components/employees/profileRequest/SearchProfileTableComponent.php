<?php

namespace App\View\Components\employees\profileRequest;

use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\User\EmploymentDetailsModel;
use App\Models\User_auth\UserCredentialsModel;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SearchProfileTableComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $componentData;
    public $viewData;
    public $searchProfileTableCom;
    public function __construct($viewData = null,$searchProfileTableCom=null)
    {
        $this->viewData = $viewData;
        $this->searchProfileTableCom=$searchProfileTableCom;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // $search_profile_table = [
        //     'is_error' => false
        // ];
        // try {
        //     $search_profile_table['districts'] = ReuseModule::getAllData(new DistrictModel());
        //     $conditions = [
        //         ['user_id', $this->loggedUser->id]
        //     ];
        //     // $logged_employment_details = ReuseModule::getOneData(new EmploymentDetailsModel(), $conditions);
        //     $conditions = [
        //         ['profile_verify_status', 1],
        //         ['noc_generate', 1],
        //         ['id', '!=', $this->loggedUser->id]
        //     ];
        //     $related_models = [
        //         'documents' => [
        //             ['document_type', 1]
        //         ],
        //     ];
        //     $with_conditions = [
        //         'documents' => function ($query) {
        //             $query->where('document_type', 1);
        //         },
        //         'employment_details' => function ($query) {},
        //         'preferences_district' => function ($query) {}
        //     ];
        //     $main_query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, $related_models, $with_conditions);
        //     $logged_users = $this->loggedUser;
        //     $main_query->whereHas('preferences_district', function ($query) use ($logged_users) {
        //         $query->where('district_id', $logged_users->employment_details->district_id);
        //     });
        //     $main_query->whereHas('employment_details', function ($query) use ($logged_users) {
        //         $query->whereIn('district_id', $logged_users->preferences_district->pluck('district_id')->toArray())
        //         ->where('depertment_id',$logged_users->employment_details->depertment_id);

        //     });
        //     $search_profile_table['employees_profiles'] = $main_query
        //         ->get();
        // } catch (Exception $err) {
        //     $search_profile_table['is_error'] = true;
        //     // dd($err->getMessage());
        // }
        // $component_data = [
        //     'is_error' => false,
        //     'offices' => []
        // ];
        // try {
        //     $logged_user = Auth::guard('user_guard')->user()->user_credentials;
        //     $component_data['offices'] = ReuseModule::getAllData(new OfficeFinAsssamModel(), [
        //         ['department_id', $logged_user->employment_details->depertment_id]
        //     ]);
        // } catch (Exception $err) {
        //     dd($err->getMessage());
        //     $component_data['is_error'] = true;
        // }
        // return view('components.employees.profile-request.search-profile-table-component', [
        //     'component_data' => $component_data
        // ]);

        return view('components.employees.profile-request.search-profile-table-component');
    }
}
