<?php

namespace App\Http\Middleware;

use App\our_modules\reuse_modules\AuthValidateModule;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserProtectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $assign_type = null, $protect_type = null, ...$assign_name): Response
    {
        try {
            $auth_validate_module = new AuthValidateModule();
            $check_auth = $auth_validate_module->checkLoggedIn()->checkActiveUser()->checkAuthorization($assign_type, $assign_name);
        } catch (Exception $err) {
            return response()->json(['status' => 301, 'message' => "Server error please try later !"]);
        }
        if ($protect_type == "API") {
            if (!$check_auth->check_logged_in) {
                return response()->json(['status' => 301, 'message' => $check_auth->auth_message]);
            }
        } else {
            if (!$check_auth->check_logged_in) {

                return redirect(app()->getLocale() . '/user-login');
            }
        }
        return $next($request);
    }
}