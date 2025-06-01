<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle the registration process
    public function register(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'account_type' => 'required|in:regular,bulk',
        ]);

        // Create the user record
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'account_type' => $validated['account_type'],
        ]);

        // Log the user in
        auth()->login($user);

        // Redirect to the appropriate dashboard based on account type
        if ($user->account_type === 'regular') {
            return redirect()->route('regular.dashboard');
        } elseif ($user->account_type === 'bulk') {
            return redirect()->route('bulk.dashboard');
        }

        // Default route if no valid account type
        return redirect()->route('login')->with('error', 'Invalid account type.');
    }

    /**
     * Show the profile edit form.
     *
     * @return \Illuminate\View\View
     */
    public function showEditProfileForm()
    {
        return view('auth.edit-profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ✅ Add this
        ]);

        $user = Auth::user();

        // ✅ Handle avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }

}
