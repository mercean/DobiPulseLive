<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GuestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'guest_email' => 'required|email',
        ]);

        // Save email to session for later use
        Session::put('guest_email', $request->guest_email);

        return back()->with('success', 'Email saved! You’ll receive a receipt after payment.');
    }
}
