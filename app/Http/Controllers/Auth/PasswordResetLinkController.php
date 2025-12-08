<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        // Determine which portal based on route
        $isAdmin = request()->is('admin/forgot-password*') || request()->routeIs('admin.password.*');
        $isFarm = request()->is('farm/forgot-password*') || request()->routeIs('farm.password.*');
        
        return view('auth.forgot-password', [
            'isAdmin' => $isAdmin,
            'isFarm' => $isFarm,
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Determine redirect route based on portal
        $isAdmin = $request->is('admin/forgot-password*') || $request->routeIs('admin.password.*');
        $isFarm = $request->is('farm/forgot-password*') || $request->routeIs('farm.password.*');
        
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }
        
        return back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
    }
}
