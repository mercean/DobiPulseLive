@extends('layouts.master')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4 py-10">
    <div class="w-full max-w-4xl">
        @if(isset($orders))
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center mb-6">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">Payment Successful!</h2>
                        <p class="text-gray-700 dark:text-gray-300">Thank you for your payment. Order ID: <span class="text-blue-600 dark:text-blue-400 font-semibold">{{ $order->order_number ?? $order->id }}</span></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 text-left mt-6">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2">Payment Summary</h4>
                            <p><strong>Total Paid:</strong> RM {{ number_format($order->total_amount, 2) }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                            <p><strong>Loyalty Points:</strong> {{ ($order->required_time / 30) * 50 }} pts</p>
                        </div>

                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Machine Info</h4>
                        <p><strong>Machine ID:</strong> {{ $order->machine->id ?? '-' }}</p>
                        <p><strong>Type:</strong> {{ ucfirst($order->machine->type ?? '-') }}</p>
                        <p><strong>Location:</strong> {{ $order->machine->location ?? '-' }}</p> {{-- ✅ Location Added --}}
                        <p><strong>Time Selected:</strong> {{ $order->required_time }} mins</p>
                    </div>

                    </div>
                </div>
            @endforeach
        @elseif(isset($order))
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">Payment Successful!</h2>
                    <p class="text-gray-700 dark:text-gray-300">Thank you for your payment. Order ID: <span class="text-blue-600 dark:text-blue-400 font-semibold">{{ $order->order_number ?? $order->id }}</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 text-left mt-6">
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Payment Summary</h4>
                        <p><strong>Total Paid:</strong> RM {{ number_format($order->total_amount, 2) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Loyalty Points:</strong> {{ ($order->required_time / 30) * 50 }} pts</p>
                    </div>

                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Machine Info</h4>
                        <p><strong>Machine ID:</strong> {{ $order->machine->id ?? '-' }}</p>
                        <p><strong>Type:</strong> {{ ucfirst($order->machine->type ?? '-') }}</p>
                        <p><strong>Time Selected:</strong> {{ $order->required_time }} mins</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex justify-center space-x-4 mt-8">
            <a href="{{ route('regular.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h2l1-2h13l1 2h2m-6 4v5a1 1 0 01-1 1h-4a1 1 0 01-1-1v-5" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Order
            </a>
        </div>
    </div>
</div>
@endsection
