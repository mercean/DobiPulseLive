<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    // When QR is scanned
    public function entry()
    {
        // If guest, let them proceed to machine selection directly
        if (!Auth::check()) {
            // Guest user — go to machine selection without loyalty
            return redirect()->route('orders.create')->with('guest_notice', 'You are using guest mode. No loyalty points will be earned.');
        }

        // Logged-in users — redirect based on role
        $accountType = Auth::user()->account_type ?? '';

        return match ($accountType) {
            'regular' => redirect()->route('orders.create'),
            'bulk'    => redirect()->route('bulk.orders.create'),
            default   => redirect('/')->with('error', 'Unrecognized account type.')
        };
    }

    // For QR demo and regeneration
    public function demo()
    {
        $qr = QrCode::size(250)->generate(url('/qr'));
        return view('qr.demo', compact('qr'));
    }
}
