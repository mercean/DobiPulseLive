@extends('layouts.master')

@section('content')
<div class="max-w-2xl mx-auto py-12 text-center text-gray-800 dark:text-white">
    <h1 class="text-2xl font-bold mb-4">✅ Payment Successful</h1>
    <p class="mb-6">Thank you for your payment! Your order has been received.</p>

    @foreach($orders as $order)
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4 text-left">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Machine:</strong> {{ $order->machine_id }}</p>
            <p><strong>Amount Paid:</strong> RM {{ number_format($order->final_price, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>
    @endforeach
</div>
@endsection
