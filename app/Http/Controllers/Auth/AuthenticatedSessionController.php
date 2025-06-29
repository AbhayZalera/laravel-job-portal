<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        // dd('ok');
        $request->authenticate();

        $request->session()->regenerate();
        if ($request->user()->role === 'company') {
            return redirect()->intended(RouteServiceProvider::COMPANY_DASHBOARD); // redirect to company dashboard
        } else if ($request->user()->role === 'candidate') {
            return redirect()->intended(RouteServiceProvider::CANDIDATE_DASHBOARD); // redirect to candidate dashboard
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/');
    }
}
