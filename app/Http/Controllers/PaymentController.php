<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Models\BulkOrder;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\LoyaltyPoint;
use App\Models\Machine;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Carbon\Carbon;
use App\Mail\PaymentReceipt;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MarkMachineAvailable;
use App\Models\Promotion;
use App\Notifications\PromotionAvailable;
use App\Notifications\LoyaltyPointsUpdated;
use App\Notifications\OrderStatusUpdated;
use App\Jobs\ExpireUnpaidOrder;


class PaymentController extends Controller
{
    // 🔹 Bulk Order Payment (Stripe USD)
    public function initiatePayment(Request $request)
    {
        $order = BulkOrder::findOrFail($request->order_id);
        Stripe::setApiKey(Config::get('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $order->price * 100,
                'currency' => 'usd',
                'metadata' => ['order_id' => $order->id],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = BulkOrder::with('user')->findOrFail($orderId);

        // ✅ Update status to 'paid' (not 'processing'!)
        $order->status = 'paid';
        $order->save();

        \Log::info("✅ Bulk payment successful for order ID: {$order->id}");

        // ✅ Send receipt email
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new \App\Mail\BulkOrderReceiptMail($order));
        }

        // ✅ Notify all admins
        $admins = \App\Models\User::where('account_type', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\BulkOrderPaidAdmin($order));

        // ✅ Show success page (blade file: resources/views/payment/success.blade.php)
        return view('payment.success', compact('order'));
    }


    public function regularPaymentPage(Order $order)
    {
        $user = auth()->user();
        $coupons = Coupon::where('user_id', $user->id)->where('used', false)->get();

        return view('orders.regular_payment', compact('order', 'coupons'));
    }

public function regularInitiate(Request $request)
{
    \Log::info('💳 INITIATE START', $request->all());

    try {
        $order = Order::findOrFail($request->order_id);
        $discountAmount = 0;
        $promoApplied = null;

        if (auth()->check()) {
            if ($request->coupon) {
                $coupon = Coupon::where('code', $request->coupon)
                    ->where('user_id', $order->user_id)
                    ->where('used', false)
                    ->first();

                if ($coupon) {
                    $discountAmount = $coupon->type === 'fixed'
                        ? floatval($coupon->value)
                        : $order->total_amount * (floatval($coupon->value) / 100);
                    $coupon->used = true;
                    $coupon->save();
                }
            } else {
                $autoPromo = Promotion::where('auto_apply', true)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();

                if ($autoPromo) {
                    $promoApplied = $autoPromo;
                    $discountAmount = $autoPromo->type === 'fixed'
                        ? floatval($autoPromo->value)
                        : $order->total_amount * (floatval($autoPromo->value) / 100);
                }
            }
        }

        $finalAmount = max(0, $order->total_amount - $discountAmount);
        \Log::info("🧾 Final Amount for Stripe: RM$finalAmount");

        Stripe::setApiKey(Config::get('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $finalAmount * 100,
            'currency' => 'myr',
            'metadata' => [
                'order_id' => $order->id,
                'discount_applied' => $discountAmount,
                'coupon_code' => $request->coupon ?? ($promoApplied->code ?? 'auto-applied'),
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);

    } catch (\Throwable $e) {
        \Log::error('💥 Payment Initiate Error: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong.'], 500);
    }
}




public function regularSuccess(Request $request)
{
    $orderIds = $request->query('order_ids');

    if ($orderIds) {
        $ids = explode(',', $orderIds);
        $orders = Order::whereIn('id', $ids)->get();

        foreach ($orders as $order) {
            $requiredTime = $order->required_time ?? 30;
            $order->status = 'approved';
            $order->end_time = Carbon::now()->addMinutes($requiredTime);
            $order->save();

            MarkMachineAvailable::dispatch($order->id)->delay($order->end_time);

            if ($order->machine_id && ($machine = Machine::find($order->machine_id))) {
                $machine->status = 'in_use';
                $machine->save();
            }

            $points = 0;
            if ($order->user_id) {
                $points = ($requiredTime / 30) * 50;
                $loyalty = LoyaltyPoint::firstOrNew(['user_id' => $order->user_id]);
                $loyalty->points = ($loyalty->points ?? 0) + $points;
                $loyalty->expiry_date = now()->addMonths(6);
                $loyalty->save();
            }

            $order->load('user');

            $email = $order->user->email ?? session('guest_email');
            if ($email) {
                $userPoints = LoyaltyPoint::where('user_id', $order->user_id)->value('points') ?? 0;
                Mail::to($email)->send(new PaymentReceipt($order, $userPoints));
            }


            if ($order->user) {
                $order->user->notify(new OrderStatusUpdated($order, 'Approved', 'regular'));
                $order->user->notify(new LoyaltyPointsUpdated($points));

                $promo = Promotion::where('auto_apply', true)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();
                if ($promo) {
                    $order->user->notify(new PromotionAvailable($promo));
                }
            }
        }

        session()->forget('guest_email');
        return view('orders.payment_success', compact('orders'));
    }

    // ✅ Single order flow
    $order = Order::findOrFail($request->order_id);
    $requiredTime = $order->required_time ?? 30;
    $order->status = 'approved';
    $order->end_time = Carbon::now()->addMinutes($requiredTime);
    $order->save();

    MarkMachineAvailable::dispatch($order->id)->delay($order->end_time);

    if ($order->machine_id && ($machine = Machine::find($order->machine_id))) {
        $machine->status = 'in_use';
        $machine->save();
    }

    $points = 0;
    if ($order->user_id) {
        $points = ($requiredTime / 30) * 50;
        $loyalty = LoyaltyPoint::firstOrNew(['user_id' => $order->user_id]);
        $loyalty->points = ($loyalty->points ?? 0) + $points;
        $loyalty->expiry_date = now()->addMonths(6);
        $loyalty->save();
    }

    $order->load('user');
    $email = $order->user->email ?? session('guest_email');
    if ($email) {
        $userPoints = LoyaltyPoint::where('user_id', $order->user_id)->value('points') ?? 0;
        Mail::to($order->guest_email)->send(new PaymentReceipt($order, 0));


    }

    if ($order->user) {
        $order->user->notify(new OrderStatusUpdated($order, 'Approved', 'regular'));
        $order->user->notify(new LoyaltyPointsUpdated($points));

        $promo = Promotion::where('auto_apply', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
        if ($promo) {
            $order->user->notify(new PromotionAvailable($promo));
        }
    }

    \Log::info("✅ Single order approved", $order->toArray());

    return view('orders.payment_success', compact('order'));
}
    public function regularPaymentMultiPage(Request $request)
    {
        $user = auth()->user();
        $ids = explode(',', $request->query('order_ids'));

        // ✅ Replace this entire orders query block:
        $orders = Order::whereIn('id', $ids)
            ->when(auth()->check(), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }, function ($query) {
                $query->whereNull('user_id'); // guests
            })
            ->get();

        // ✅ Only show coupons if user is logged in
        $coupons = $user
            ? Coupon::where('user_id', $user->id)->where('used', false)->get()
            : collect(); // empty collection for guests

        return view('orders.regular_payment', compact('orders', 'coupons'));
    }

public function guestMultiPaymentPage(Request $request)
{
    if (!$request->has('order_ids') || !$request->order_ids) {
        \Log::warning('⚠️ Missing order_ids in guestMultiPaymentPage');
        return redirect('/')->with('error', 'Missing order IDs.');
    }

    $orderIds = explode(',', $request->order_ids);
    $orders = Order::whereIn('id', $orderIds)->get();

    \Log::info('✅ guestMultiPaymentPage triggered', ['ids' => $orderIds]);

    return view('payment.guest_multi', compact('orders'));
}


public function guestInitiatePayment(Request $request)
{
    \Log::info('💳 GUEST INITIATE START', $request->all());

    try {
        $orderIds = explode(',', $request->order_ids);
        $orders = Order::whereIn('id', $orderIds)->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No valid orders found.'], 400);
        }

        // Store guest email to each order if provided
        if ($request->filled('guest_email')) {
            foreach ($orders as $order) {
                $order->guest_email = $request->guest_email;
                $order->save();
            }

            // Also store in session for later receipt use
            session(['guest_email' => $request->guest_email]);
        }

        // Calculate total amount
        $totalAmount = $orders->sum('total_amount');
        $finalAmount = max(0, $totalAmount); // you can add guest discounts if needed later

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $finalAmount * 100,
            'currency' => 'myr',
            'metadata' => [
                'order_ids' => $orders->pluck('id')->join(','),
                'guest_email' => $request->guest_email ?? 'not_provided',
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    } catch (\Throwable $e) {
        \Log::error('💥 Guest Payment Initiate Error: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong while initiating guest payment.'], 500);
    }
}

public function guestSuccess(Request $request)
{
    $orderIds = explode(',', $request->order_ids);
    $orders = Order::whereIn('id', $orderIds)->get();

    foreach ($orders as $order) {
        // ✅ Approve the order
        $requiredTime = $order->required_time ?? 30;
        $order->status = 'approved';
        $order->end_time = now()->addMinutes($requiredTime);
        $order->save();

        // ✅ Dispatch job to free machine later
        MarkMachineAvailable::dispatch($order->id)->delay($order->end_time);

        // ✅ Mark machine as in use
        if ($order->machine_id && ($machine = Machine::find($order->machine_id))) {
            $machine->status = 'in_use';
            $machine->save();
        }

        // ✅ Send receipt to guest
        if ($order->guest_email) {
            Mail::to($order->guest_email)->send(new PaymentReceipt($order, 0));
        }

    }

    return view('payment.guest_success', compact('orders'));
}




}
