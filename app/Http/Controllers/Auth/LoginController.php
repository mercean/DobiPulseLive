<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login', ['isGuestPage' => true]);
    }

    /**
     * Handle the login process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
    
        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
    
            // ✅ Check if user was redirected from a QR scan or other custom flow
            if (session()->has('redirect_after_login')) {
                $redirect = session()->pull('redirect_after_login');
                return redirect($redirect);
            }
    
            // Fallback: role-based dashboard redirection
            $accountType = Auth::user()->account_type;
    
            return match ($accountType) {
                'regular' => redirect()->route('regular.dashboard'),
                'bulk'    => redirect()->route('bulk.dashboard'),
                'admin'   => redirect()->route('admin.dashboard'),
                default   => redirect()->route('login')->with('error', 'Invalid account type.'),
            };
        }
    
        // Failed login
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    
    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect('/login');
    }
}
