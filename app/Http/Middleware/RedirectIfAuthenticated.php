<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
        // dd($guards);
        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                //This guard is admin
                if ($guard === 'admin') {
                    // dd($guard);
                    return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
                }
                //This guard is web
                else if ($request->user()->role === 'company') {
                    // dd($request->user()->role);
                    return redirect(RouteServiceProvider::COMPANY_DASHBOARD);
                } else if ($request->user()->role === 'candidate') {
                    // dd($request->user()->role);
                    return redirect(RouteServiceProvider::CANDIDATE_DASHBOARD);
                }
            }
            // else {
            //     dd('Jay Mataji');
            // }
        }
        // dd($next($request));
        return $next($request);
    }
}
