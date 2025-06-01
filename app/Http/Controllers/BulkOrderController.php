<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BulkOrder;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\User;
use App\Mail\BulkOrderReceiptMail;
use App\Notifications\BulkOrderPaidAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class BulkOrderController extends Controller
{
    // Display all bulk orders with pagination and optional filtering by status
    public function index(Request $request)
    {
        // Get all orders of the authenticated user with optional filtering by order status
        $ordersQuery = BulkOrder::with('user')->where('user_id', Auth::id());

        // Optional filter by order status (pending, approved, completed)
        if ($request->has('status')) {
            $ordersQuery->where('status', $request->status);
        }

        // Pagination (default 10 items per page)
        $orders = $ordersQuery->paginate(10);

        // Get the total count of orders for the user
        $orderCount = $orders->count();

        // Pass orders, count, and status filter to the view
        return view('bulk_orders.index', compact('orders', 'orderCount'));
    }

    // Show the form for creating a new bulk order
    public function create()
    {
        return view('bulk_orders.create'); // Return to the create order view
    }

    // Store a new bulk order in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'cloth_type' => 'required|string|max:255',
            'load_kg' => 'required|numeric|min:1',  // Ensure load is positive
            'load_arrival_date' => 'required|date|after:today',  // Ensure the date is in the future
            'load_arrival_time' => 'required|date_format:H:i',
            'pickup_date' => 'required|date|after:load_arrival_date',  // Pickup after load arrival
            'pickup_time' => 'required|date_format:H:i',
        ]);

        // Create a new bulk order in the database
        BulkOrder::create([
            'cloth_type' => $request->cloth_type,
            'load_kg' => $request->load_kg,
            'load_arrival_date' => $request->load_arrival_date,
            'load_arrival_time' => $request->load_arrival_time,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'status' => 'pending',  // Automatically set as 'pending'
            'price' => 0,           // Default price set to 0 so user can't override
            'user_id' => Auth::id(), // Link the order to the logged-in user
        ]);

        // Redirect to the bulk orders index with a success message
        return redirect()->route('bulk.orders.index')->with('success', 'Bulk order created successfully!');
    }

    // Show the form for editing the bulk order
    public function edit($id)
    {
        $order = BulkOrder::findOrFail($id);
        return view('bulk_orders.edit', compact('order'));
    }

    // Update the bulk order
    public function update(Request $request, $id)
    {
        $order = BulkOrder::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'cloth_type' => 'required|string|max:255',
            'load_kg' => 'required|numeric|min:1',
            'load_arrival_date' => 'required|date|after:today',
            'load_arrival_time' => 'required|date_format:H:i',
            'pickup_date' => 'required|date|after:load_arrival_date',
            'pickup_time' => 'required|date_format:H:i',
        ]);

        // Update the bulk order
        $order->update([
            'cloth_type' => $request->cloth_type,
            'load_kg' => $request->load_kg,
            'load_arrival_date' => $request->load_arrival_date,
            'load_arrival_time' => $request->load_arrival_time,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            // Retain existing status and price
            'status' => $order->status,
            'price'  => $order->price,
        ]);

        return redirect()->route('bulk.orders.index')->with('success', 'Bulk order updated successfully!');
    }

    // Delete a bulk order
    public function destroy($id)
    {
        $order = BulkOrder::findOrFail($id);
        $order->delete();

        return redirect()->route('bulk.orders.index')->with('success', 'Order deleted successfully!');
    }

    // Display the payment gateway for the bulk order
    public function paymentGateway($id)
    {
        // Fetch the bulk order and pass it to the view
        $order = BulkOrder::findOrFail($id);
        return view('bulk_orders.paymentgatewaybulk', compact('order'));
    }

    // Initiate payment process (create PaymentIntent)
    public function initiatePayment(Request $request)
    {
        // Fetch the bulk order
        $order = BulkOrder::findOrFail($request->order_id);

        // Set Stripe secret key (make sure it's in your .env file)
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Create a PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $order->price * 100, // Convert to cents
                'currency' => 'usd',
                'metadata' => ['order_id' => $order->id],
            ]);

            // Return the client secret to the frontend
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

        // ✅ Update status to 'paid'
        $order->status = 'paid';
        $order->save();

        // ✅ Send receipt to bulk user's email
        Mail::to($order->user->email)->send(new BulkOrderReceiptMail($order));

        // ✅ Notify all admins about paid order
        $admins = User::where('account_type', 'admin')->get();
        Notification::send($admins, new BulkOrderPaidAdmin($order));

        // ✅ Redirect to success view
        return view('payment.success', compact('order'));
    }


        public function show($id)
    {
        $order = BulkOrder::with('user')->findOrFail($id);

        // Optional: Ensure only the owner can view it
        if (auth()->id() !== $order->user_id) {
            abort(403); // Forbidden
        }

        return view('bulk_orders.show', compact('order'));
    }

}
