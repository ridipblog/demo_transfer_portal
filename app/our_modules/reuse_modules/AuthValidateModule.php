<?php

namespace  App\our_modules\reuse_modules;

use App\Models\User_auth\AllLoginModel;
use Illuminate\Support\Facades\Auth;

class AuthValidateModule
{
    public $check_logged_in;
    public $auth_message;
    public $logged_persion;
    public function __construct()
    {
        $this->check_logged_in = true;
    }
    // -------------- check logged in ------------
    public function checkLoggedIn()
    {
        if (Auth::guard('user_guard')->user()) {
            $this->check_logged_in = true;
        } else {
            $this->check_logged_in = false;
            $this->auth_message = "You are not logged in !";
        }
        return $this;
    }
    // ----------- check active user -------------
    public function checkActiveUser()
    {
        if ($this->check_logged_in) {
            if (Auth::guard('user_guard')->user()->status == 1) {
                $this->check_logged_in = true;
            } else {
                $this->check_logged_in = false;
                $this->auth_message = "Your account is deatived !";
            }
        }
        return $this;
    }
    // ----------- check role and permission --------------
    // ------------------ old code for check role or permision name ----------------
    // public function checkAuthorization($type, $role_name)
    // {
    //     if ($this->check_logged_in) {
    //         $check = true;
    //         if ($type == "roles") {
    //             if (count($this->getRolePermissionByUser(new AllLoginModel(), $type, [
    //                 [
    //                     ['role_id', Auth::guard('user_guard')->user()->role_id]
    //                 ],

    //                 $role_name
    //             ])) != 0) {
    //                 $this->check_logged_in = true;
    //             } else {
    //                 $this->check_logged_in = false;
    //                 $this->auth_message = "Your Role is authorized !";
    //             }
    //         }
    //     }
    //     return $this;
    // }
    // ----------------- new code for check role or permision name ------------------
    public function checkAuthorization($type, $role_name)
    {
        // dd($role_name);
        if ($this->check_logged_in) {
            $check = true;
            if ($type == "roles") {
                if (in_array(Auth::guard('user_guard')->user()->roles->role, $role_name)) {
                    $this->check_logged_in = true;
                } else {
                    $this->check_logged_in = false;
                    $this->auth_message = "Your Role is authorized !";
                }
            }
        }
        return $this;
    }
    // -------------- get roles and permission by user ---------------
    public static function getRolePermissionByUser($model, $type, $condition)
    {

        return $model::query()
            ->with([$type])
            ->where($condition[0])
            ->whereHas($type, function ($query) use ($type, $condition) {
                $query->whereIn($type == "roles" ? 'role' : 'permission', $condition[1]);
            })->get();
    }
}