<?php

namespace App\View\Components\EmployeeProfile;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SearchPanNumberComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $viewData;
    public $panComponent;
    public function __construct($viewData = null,$panComponent=null)
    {
        $this->panComponent=$panComponent;
        $this->viewData = $viewData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        // $pan_component=[
        //     'is_error'=>false,
        //     'error_message'=>null,
        //     'is_update'=>false,
        //     'is_final'=>false
        // ];
        // try{
        //     $logged_user=Auth::guard('user_guard')->user();
        //     if($logged_user->user_credentials->profile_verify_status==2){
        //         $pan_component['is_update']=true;
        //     }
        //     if($logged_user->user_credentials->profile_verify_status==0){
        //         $pan_component['is_final']=true;
        //     }
        // }
        // catch(Exception $err){
        //     $pan_component['error_message']="Found error in Search Pan Form";
        //     $pan_component['is_error']=true;
        // }
        // return view('components.employee-profile.search-pan-number-component',[
        //     'pan_component'=>$pan_component
        // ]);

        return view('components.employee-profile.search-pan-number-component');
    }
}
