<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        // Determine which portal based on route
        $isAdmin = $request->is('admin/reset-password*') || $request->routeIs('admin.password.*');
        $isFarm = $request->is('farm/reset-password*') || $request->routeIs('farm.password.*');
        
        return view('auth.reset-password', [
            'request' => $request,
            'isAdmin' => $isAdmin,
            'isFarm' => $isFarm,
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Determine redirect route based on portal
        $isAdmin = $request->is('admin/reset-password*') || $request->routeIs('admin.password.*');
        $isFarm = $request->is('farm/reset-password*') || $request->routeIs('farm.password.*');
        
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            if ($isAdmin) {
                return redirect()->route('admin.login')->with('status', __($status));
            } elseif ($isFarm) {
                return redirect()->route('farm.login')->with('status', __($status));
            }
            return redirect()->route('login')->with('status', __($status));
        }
        
        return back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
    }
}
