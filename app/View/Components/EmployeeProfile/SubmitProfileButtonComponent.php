<?php

namespace App\View\Components\EmployeeProfile;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SubmitProfileButtonComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $submitButton;
    public function __construct($submitButton=null)
    {
        $this->submitButton=$submitButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // $submit_button_component=[
        //     'is_error'=>false,
        //     'error_message'=>null,
        //     'is_update'=>false,
        //     'is_final'=>false
        // ];
        // try{
        //     $logged_user=Auth::guard('user_guard')->user();
        //     if($logged_user->user_credentials->profile_verify_status==2){
        //         $submit_button_component['is_update']=true;
        //     }
        //     if($logged_user->user_credentials->profile_verify_status==0){
        //         $submit_button_component['is_final']=true;
        //     }
        // }catch(Exception $err){
        //     $submit_button_component['is_error']=true;
        //     $submit_button_component['error_message']="Issue in Submit button component  !";
        // }
        // return view('components.employee-profile.submit-profile-button-component',[
        //     'submit_button_component'=>$submit_button_component
        // ]);

        return view('components.employee-profile.submit-profile-button-component');
    }
}
