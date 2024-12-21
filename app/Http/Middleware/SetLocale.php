<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $locale = $request->route('lang') ?? Session::get('locale', 'en');
        $locale = Session::get('locale', 'en');
        // dd($locale);
        if ($request->route('lang')) {
            Session::put('locale', $locale);
        }
        // Set the application's locale
        if (in_array($locale, ['en', 'as'])) {
            App::setLocale($locale);
        } else {
            App::setLocale('en');
        }
        return $next($request);
    }
}
