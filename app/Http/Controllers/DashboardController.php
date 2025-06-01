<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoyaltyPoint;
use App\Models\Order; 
use Carbon\Carbon;
use App\Models\BulkOrder;
use App\Models\Promotion;




class DashboardController extends Controller
{
    /**
     * Redirects user to the correct dashboard based on their role
     */
    public function redirectDashboard()
    {
        $user = Auth::user();
        
        // Check the user's role and redirect them accordingly
        if ($user->account_type === 'regular') {
            return redirect()->route('regular.dashboard'); // Redirect to regular dashboard
        } elseif ($user->account_type === 'bulk') {
            return redirect()->route('bulk.dashboard'); // Redirect to bulk dashboard
        } elseif ($user->account_type === 'admin') {
            return redirect('/admin/bulk-orders');
        }
        
        // If user doesn't have a role or is not recognized, send them to the home page
        return redirect('/');
    }

    /**
     * Regular User Dashboard
     */
public function regularDashboard()
{
    $user = Auth::user();

    $orders = Order::where('user_id', $user->id)
        ->whereIn('status', ['pending', 'processing', 'approved', 'completed'])
        ->orderBy('created_at', 'desc')
        ->get();

    $points = \App\Models\LoyaltyPoint::where('user_id', $user->id)->sum('points');

    $chartData = [
        'labels' => [],
        'data' => [],
    ];

    foreach ($orders->take(5)->reverse() as $order) {
        $chartData['labels'][] = 'Order #' . $order->id;
        $chartData['data'][] = $order->total_amount;
    }

    // ✅ Get current promotions
    $promos = \App\Models\Promotion::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->get();

    // ✅ Combine everything in a single return
    return view('dashboard.regular', compact('orders', 'points', 'chartData', 'promos'));
}


    public function orders()
    {
        $user = auth()->user();
    
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $points = \App\Models\LoyaltyPoint::where('user_id', $user->id)->sum('points');
    
        // ✅ Add this chart data structure (even dummy values are OK)
        $chartData = [
            'labels' => [],
            'data' => [],
        ];
    
        // Only add real chart data if there are recent orders
        foreach ($orders->take(5)->reverse() as $order) {
            $chartData['labels'][] = 'Order #' . $order->id;
            $chartData['data'][] = $order->total_amount;
        }
    
        return view('regular.orders.index', compact('orders', 'points', 'chartData'));
    }
    

    
    /**
     * Bulk User Dashboard
     */
public function bulkDashboard()
{
    // Get all bulk orders for the logged-in user
    $orders = BulkOrder::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->paginate(10); // paginated to match the blade view's use of ->total()

    return view('dashboard.bulk', compact('orders'));
}

    /**
     * Admin User Dashboard
     */
    public function adminDashboard()
    {
        return view('admin_dashboard'); // Show admin's dashboard
    }
    public function index(Request $request)
{
    $range = $request->input('range', '7');
    $from = $range === 'all' ? now()->subYears(10) : now()->subDays($range);
    
    $orders = Order::where('user_id', auth()->id())
                   ->where('created_at', '>=', $from)
                   ->orderBy('created_at', 'asc')
                   ->get();

    $chartData = [
        'labels' => [],
        'data' => []
    ];

    $grouped = $orders->groupBy(fn($o) => $o->created_at->format('d M'));

    foreach ($grouped as $date => $dayOrders) {
        $chartData['labels'][] = $date;
        $chartData['data'][] = $dayOrders->sum('total_amount');
    }

    return view('dashboard.index', [
        'orders' => $orders,
        'points' => auth()->user()->points ?? 0,
        'chartData' => $chartData,
    ]);
}
    public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->save();

    return back()->with('success', 'Profile updated.');
}

}