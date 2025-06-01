<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Coupon;

Route::get('/coupon/validate', function (Request $request) {
    $code = $request->query('code');

    $coupon = Coupon::where('code', $code)->where('used', false)->first();

    if (!$coupon) {
        return response()->json(['valid' => false]);
    }

    return response()->json([
        'valid' => true,
        'type' => $coupon->type,
        'value' => $coupon->value,
        'discount' => $coupon->type === 'fixed'
            ? $coupon->value
            : 0, // optional: handle percent in frontend
    ]);
});
