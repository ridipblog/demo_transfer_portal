<?php

namespace App\View\Components\VerifyDashComponent;

use App\Models\Transfer\TransfersModel;
use App\Models\User\PreferenceDistrictModel;
use App\Models\User_auth\UserCredentialsModel;
use App\our_modules\employees_modules\EmployeeModule;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class RecomendedbyReferenceComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $viewData;
    public $preferenceDistricts;
    public $countByPrefernceDistrict;
    public function __construct($preferenceDistricts=null,$countByPrefernceDistrict=null) {
        $this->preferenceDistricts=$preferenceDistricts;
        $this->countByPrefernceDistrict=$countByPrefernceDistrict;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // $is_error = false;
        // $userCountsByEmploymentDistrict = [];
        // try {
        //     $logged_user = Auth::guard('user_guard')->user()->user_credentials;
        //     $preferenceDistricts = $logged_user->preferences_district;
        //     $related_users = UserCredentialsModel::where([
        //         ['profile_verify_status', 1],
        //         ['noc_generate', 1],
        //         ['id', '!=', $logged_user->id]
        //     ])
        //         ->whereHas('employment_details', function ($query) use ($preferenceDistricts,$logged_user) {
        //             $query->whereIn('district_id', $preferenceDistricts->pluck('district_id')->toArray())
        //             ->where('depertment_id', $logged_user->employment_details->depertment_id);
        //         })->whereHas('preferences_district', function ($query) use ($logged_user) {
        //             $query->where('district_id', $logged_user->employment_details->district_id);
        //         })
        //         ->with(['employment_details', 'preferences_district'])
        //         ->get();

        //     // Group users by their employment district and count them
        //     $groupedUsers = $related_users->groupBy(function ($user) {
        //         return $user->employment_details->district_id; // Group by employment district
        //     });
        //     // Fill the counts for each preference district
        //     foreach ($preferenceDistricts as $district) {
        //         $districtId = $district->district_id;
        //         $userCountsByEmploymentDistrict[$districtId] = $groupedUsers->has($districtId) ? $groupedUsers[$districtId]->count() : 0;
        //     }
        // } catch (Exception $err) {
        //     $is_error = true;
        // }
        // return view('components.verify-dash-component.recomendedby-reference-component',[
        //     'is_error'=>$is_error,
        //     'count_by_prefernce_district'=>$userCountsByEmploymentDistrict,
        //     'preference_districts'=>$preferenceDistricts
        // ]);

        return view('components.verify-dash-component.recomendedby-reference-component');
    }
}
