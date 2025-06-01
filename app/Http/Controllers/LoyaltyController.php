<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoyaltyPoint;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\RedemptionReward;
use App\Models\Coupon;
use Illuminate\Support\Str;

class LoyaltyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $points = LoyaltyPoint::where('user_id', $user->id)->sum('points');
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    
        // 🟩 Create chartData (simple total amount over date for now)
        $chartData = [
            'labels' => $orders->pluck('created_at')->map(fn($date) => $date->format('d M'))->toArray(),
            'data' => $orders->pluck('total_amount')->toArray()
        ];
    
        return view('dashboard.regular', compact('points', 'orders', 'chartData'));
    }
    
    

    public function earnPoints($orderId)
    {
        $order = Order::find($orderId);
        $user = Auth::user();
        
        if ($order && $order->user_id == $user->id) {
            $pointsEarned = floor($order->total_price / 10); // Example: RM10 = 1 point
            LoyaltyPoint::create([
                'user_id' => $user->id,
                'points' => $pointsEarned,
                'expiry_date' => now()->addMonths(6), // Points expire in 6 months
            ]);
        }
        return redirect()->back()->with('success', 'Points earned successfully!');
    }

    public function showRedeemCatalog()
    {
        $user = Auth::user();
        $points = LoyaltyPoint::where('user_id', $user->id)->sum('points');
        $rewards = RedemptionReward::all();
        return view('Regular.redeem_catalog', compact('points', 'rewards'));
    }

    public function generateCoupon($rewardId)
    {
        $user = Auth::user();
        $reward = RedemptionReward::findOrFail($rewardId);
        $totalPoints = LoyaltyPoint::where('user_id', $user->id)->sum('points');

        if ($totalPoints < $reward->points_required) {
            return back()->with('error', 'Not enough points to redeem this reward.');
        }

        // Deduct points (FIFO)
        $remaining = $reward->points_required;
        $points = LoyaltyPoint::where('user_id', $user->id)->orderBy('created_at')->get();

        foreach ($points as $point) {
            if ($remaining <= 0) break;

            if ($point->points <= $remaining) {
                $remaining -= $point->points;
                $point->delete();
            } else {
                $point->points -= $remaining;
                $point->save();
                $remaining = 0;
            }
        }

        // Generate Coupon
        $coupon = Coupon::create([
            'user_id' => $user->id,
            'code' => strtoupper(Str::random(8)),
            'type' => $reward->type,
            'value' => $reward->reward_value,
            'used' => false,
        ]);

        return view('Regular.receipt', compact('coupon', 'reward'));
    }

    public function transactionHistory()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('dashboard.transactions', compact('orders'));
    }

    public function redeemPoints(Request $request)
    {
        $user = Auth::user();
        $pointsToRedeem = (int) $request->points;
        $totalPoints = LoyaltyPoint::where('user_id', $user->id)->sum('points');
        
        if ($pointsToRedeem > 0 && $pointsToRedeem <= $totalPoints) {
            $remaining = $pointsToRedeem;
            $points = LoyaltyPoint::where('user_id', $user->id)->orderBy('created_at')->get();

            foreach ($points as $point) {
                if ($remaining <= 0) break;

                if ($point->points <= $remaining) {
                    $remaining -= $point->points;
                    $point->delete();
                } else {
                    $point->points -= $remaining;
                    $point->save();
                    $remaining = 0;
                }
            }

            return redirect()->back()->with('success', 'Points redeemed successfully!');
        }

        return redirect()->back()->with('error', 'Not enough points to redeem!');
    }
    public function showLoyaltyPage()
{
// In LoyaltyController@showLoyaltyPage
$user = Auth::user();
$points = LoyaltyPoint::where('user_id', $user->id)->sum('points');
$loyaltyLogs = LoyaltyPoint::where('user_id', $user->id)
                 ->orderBy('created_at', 'desc')->get();
$coupons = Coupon::where('user_id', $user->id)->latest()->get();

// Optional: map coupons to their reward for points required
$redemptions = [];
foreach ($coupons as $c) {
    $reward = RedemptionReward::where('type', $c->type)
               ->where('reward_value', $c->value)->first();
    if ($reward) {
        $redemptions[] = [
            'date'    => $c->created_at,
            'points'  => $reward->points_required,
            'title'   => $reward->title,
            'code'    => $c->code,
        ];
    }
}
return view('Regular.loyalty_points', compact('points','loyaltyLogs','coupons','redemptions'));

}

}
