<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        // Determine which login portal based on route
        if (request()->is('admin/login*')) {
            return view('admin.login');
        } elseif (request()->is('farm/login*')) {
            return view('farm.login');
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        // Redirect based on user role and login portal
        if ($request->is('admin/login')) {
            if (!$user->isAdmin()) {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'Access denied. Only administrators can access this area.');
            }
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } elseif ($request->is('farm/login')) {
            if (!$user->isManager()) {
                Auth::logout();
                return redirect()->route('farm.login')->with('error', 'Access denied. Only farm managers can access this area.');
            }
            return redirect()->intended(route('farm.dashboard', absolute: false));
        }

        // Default redirect
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } else {
            return redirect()->intended(route('farm.dashboard', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect to appropriate login based on previous route
        if (request()->is('admin/*')) {
            return redirect()->route('admin.login');
        } elseif (request()->is('farm/*')) {
            return redirect()->route('farm.login');
        }
        
        return redirect('/');
    }
}
