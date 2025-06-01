<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\BulkOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\BalanceTransaction;
use League\Csv\Writer; // Add this line at the top of your controller
use Illuminate\Http\Response;
use App\Jobs\SendPickupReminder; // ⬅️ Add this at the top
use Carbon\Carbon;
use App\Models\Promotion;




class AdminDashboardController extends Controller
{
public function index(Request $request)
{
    $status = $request->input('status');
    $search = $request->input('search');

    // Unified query with status + search filters
    $bulkOrdersQuery = BulkOrder::with('user');
    if ($status) {
        $bulkOrdersQuery->where('status', $status);
    }
    if ($search) {
        $bulkOrdersQuery->where(function ($query) use ($search) {
            $query->where('id', 'like', "%$search%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
        });
    }

    // Use paginate instead of get for performance
    $bulkOrders = $bulkOrdersQuery->paginate(10);

    $orders = Order::all();
    $totalUsers = User::count();
    $totalOrders = Order::count();
    $totalBulkOrders = BulkOrder::count();

    $statusDistribution = BulkOrder::select('status', \DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    $totalProcessedOrders = BulkOrder::where('status', 'completed')->count();
    $orderCompletionRate = $totalOrders > 0 ? ($totalProcessedOrders / $totalOrders) * 100 : 0;

    $avgTimeToCompleteOrders = BulkOrder::whereIn('status', ['approved', 'completed'])
        ->get()
        ->map(function ($order) {
            return \Carbon\Carbon::parse($order->updated_at)->diffInMinutes($order->created_at);
        })
        ->avg();

    $usersQuery = User::query();
    if ($search) {
        $usersQuery->where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        });
    }
    $users = $usersQuery->get();

    // Weekly usage
    $startOfWeek = Carbon::now()->startOfWeek();
    $dailyLabels = [];
    $dailyCounts = [];
    for ($i = 0; $i < 7; $i++) {
        $day = $startOfWeek->copy()->addDays($i);
        $dailyLabels[] = $day->translatedFormat('D');
        $dailyCounts[] = Order::whereDate('created_at', $day)->count();
    }

    $promotions = Promotion::all();

    return view('admin.dashboard', compact(
        'totalUsers',
        'totalOrders',
        'totalBulkOrders',
        'orders',
        'bulkOrders',
        'users',
        'statusDistribution',
        'orderCompletionRate',
        'avgTimeToCompleteOrders',
        'dailyLabels',
        'dailyCounts',
        'promotions'
    ));
}

public function updateOrderStatus($id, $type, Request $request)
{
    $bulkOrder = BulkOrder::findOrFail($id);

    // Handle price update
    if ($request->has('price')) {
        $price = $request->input('price');
        $bulkOrder->price = $price;
        $bulkOrder->save();

        if ($price > 0) {
            $bulkOrder->status = 'PayNow';
            $bulkOrder->save();
            \Log::info("Order ID: {$bulkOrder->id} status updated to PayNow");
            return redirect()->route('admin.dashboard')->with('status', 'Price updated and status set to PayNow!');
        }
    }

    // Handle status update
    $status = $request->input('status');
    if ($status && $status !== $bulkOrder->status) {
        $bulkOrder->status = $status;
        $bulkOrder->save();
        \Log::info("Order ID: {$bulkOrder->id} status updated to {$status}");

        if ($status === 'paid') {
            $adminUsers = User::where('account_type', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new \App\Notifications\BulkOrderPaidAdmin($bulkOrder));
            }
        }

        if ($status === 'waiting pickup') {
            SendPickupReminder::dispatch($bulkOrder->id)->delay(now()->addMinutes(30));
        }

        return redirect()->route('admin.dashboard')->with('status', 'Order status updated!');
    }

    return redirect()->route('admin.dashboard')->with('status', 'No changes applied.');
}

    
    
    
    
    
    
    
    public function createAdmin($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Make sure the user isn't already an admin
        if ($user->account_type !== 'admin') {
            $user->account_type = 'admin'; // Change the account type to admin
            $user->save(); // Save the changes

            // Redirect back with a success message
            return redirect()->route('admin.dashboard')->with('status', 'User is now an admin!');
        }

        // If the user is already an admin, show a message
        return redirect()->route('admin.dashboard')->with('status', 'User is already an admin.');
    }

    public function storeAdmin(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Create the admin user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'account_type' => 'admin', // Ensure the user is an admin
        ]);
    
        return redirect()->route('admin.dashboard')->with('status', 'New admin user created successfully!');
    }
    

    // Show the form to create an admin user
    public function showCreateAdminForm()
    {
        return view('admin.createAdmin'); // The form to create an admin user
    }

    public function viewBulkOrderDetails($id)
    {
        // Fetch the bulk order along with the associated user
        $bulkOrder = BulkOrder::with('user')->findOrFail($id);
        
        // Return the view with the bulkOrder data
        return view('admin.bulkOrderDetails', compact('bulkOrder'));
    }

    // Method to fetch Stripe transaction history for paid orders
    public function transactionHistory()
    {
        // Set the Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Fetch the transactions from Stripe (from a specific date range or all)
            $transactions = BalanceTransaction::all([
                'limit' => 10, // Limit number of transactions to fetch
                'created' => ['gte' => strtotime('last month')], // Example: filter by last month
            ]);

            // Fetch all paid Bulk Orders (just for clarity)
            $paidBulkOrders = BulkOrder::where('status', 'processing')->get();

            return view('admin.transactionHistory', compact('transactions', 'paidBulkOrders'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching transaction history: ' . $e->getMessage());
        }
    }

    public function makeAdmin($id)
{
    // Fetch the user by ID
    $user = User::findOrFail($id);

    // Make sure the user isn't already an admin
    if ($user->account_type !== 'admin') {
        $user->account_type = 'admin'; // Change the account type to admin
        $user->save(); // Save the changes

        // Redirect back with a success message
        return redirect()->route('admin.dashboard')->with('status', 'User is now an admin!');
    }

    // If the user is already an admin, show a message
    return redirect()->route('admin.dashboard')->with('status', 'User is already an admin.');
}

public function exportBulkOrders()
{
    // Fetch all bulk orders (adjust query as needed)
    $bulkOrders = BulkOrder::all();

    // Create CSV writer instance
    $csv = Writer::createFromString('');

    // Set the header row
    $csv->insertOne(['Order ID', 'User Name', 'Status', 'Price', 'Created At']);

    // Insert each bulk order's data
    foreach ($bulkOrders as $bulkOrder) {
        $csv->insertOne([
            $bulkOrder->id,
            $bulkOrder->user->name,
            $bulkOrder->status,
            $bulkOrder->price,
            $bulkOrder->created_at
        ]);
    }

    // Create a response to return the CSV file as a download
    $response = new Response($csv->getContent());
    $response->header('Content-Type', 'text/csv');
    $response->header('Content-Disposition', 'attachment; filename="bulk_orders.csv"');

    return $response;
}

public function exportTransactionHistory()
{
    // Ensure Stripe API key is set
    Stripe::setApiKey(env('STRIPE_SECRET'));

    // Fetch the transactions (modify this query to suit your needs)
    try {
        $transactions = BalanceTransaction::all([
            'limit' => 10,  // Customize the number of transactions
            'created' => ['gte' => strtotime('last month')],  // Example filter for the last month
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Error fetching transactions: ' . $e->getMessage());
    }

    // Create CSV writer instance
    $csv = Writer::createFromString('');

    // Set the header row
    $csv->insertOne(['Transaction ID', 'Amount', 'Status', 'Payment Method', 'Order ID', 'Created At']);

    // Insert each transaction's data
    foreach ($transactions as $transaction) {
        $csv->insertOne([
            $transaction->id,
            number_format($transaction->amount / 100, 2),  // Convert amount to dollars
            ucfirst($transaction->status),
            isset($transaction->payment_method_details->card) ? $transaction->payment_method_details->card->brand : 'N/A',
            $transaction->metadata['order_id'] ?? 'N/A',
            \Carbon\Carbon::createFromTimestamp($transaction->created)->toDateString(),
        ]);
    }

    // Create a response to return the CSV file as a download
    $response = new Response($csv->getContent());
    $response->header('Content-Type', 'text/csv');
    $response->header('Content-Disposition', 'attachment; filename="transaction_history.csv"');

    return $response;
}

public function bulkOrders(Request $request)
{
    // Fetch filtered or all bulk orders based on the request
    $status = $request->input('status');
    $bulkOrdersQuery = BulkOrder::with('user');
    
    // Apply status filter if provided
    if ($status) {
        $bulkOrdersQuery->where('status', $status);
    }
    
    // Fetch the bulk orders with the applied filter (if any)
    $bulkOrders = $bulkOrdersQuery->get();
    
    // Return the view with the bulkOrders data
    return view('admin.bulkOrders', compact('bulkOrders'));
}
}

