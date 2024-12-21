<?php

namespace App\Http\Middleware;

use App\our_modules\reuse_modules\AuthValidateModule;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PublicProtectedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $protect_type = null): Response
    {
        // Auth::guard('user_guard')->logout();
        try {
            $auth_validate_module = new AuthValidateModule();
            $check_auth = $auth_validate_module->checkLoggedIn()->checkActiveUser();
        } catch (Exception $err) {
            return response()->json(['status' => 301, 'message' => "Server error please try later !"]);
        }
        if ($protect_type == "API") {
            if ($check_auth->check_logged_in) {
                return response()->json(['status' => 301, 'message' => "You are already logged in !"]);
            }
        } else {
            if ($check_auth->check_logged_in) {
                $logged_user = Auth::guard('user_guard')->user();
                $redirect_links = [
                    '4' => app()->getLocale() . '/employees/dashboard',
                    '6' => app()->getLocale() . '/verifier/verifier-dashboard',
                    '3' => app()->getLocale() . '/verifier/verifier-dashboard',
                    '2' => app()->getLocale() . '/verifier/verifier-dashboard',
                    '5' => app()->getLocale() . '/verifier/verifier-dashboard',
                    '7' => app()->getLocale() . '/department/department-dashboard',
                    '1' => '/admin/admin-dashboard'
                ];
                return redirect($redirect_links[$logged_user->role_id]);
            }
        }
        return $next($request);
    }
}