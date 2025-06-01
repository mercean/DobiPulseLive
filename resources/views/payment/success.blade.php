@extends('layouts.master')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow text-center">
        <!-- Success Icon (Lucide) -->
        <div class="flex justify-center mb-4">
            <x-lucide-icon name="check-circle" class="w-12 h-12 text-green-500" />
        </div>

        <h1 class="text-3xl font-bold text-green-600 mb-4">
            Payment Successful
        </h1>

        <p class="text-xl text-gray-800 dark:text-gray-200 mb-2">
            Hi {{ $order->user->name }},
        </p>

        <p class="text-gray-700 dark:text-gray-300">
            Your payment for Order <strong>#{{ $order->id }}</strong> has been received.
        </p>

        <div class="mt-4 flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
            <x-heroicon-o-currency-dollar class="w-5 h-5 text-blue-500" />
            <span>Total Paid: <strong>MYR {{ number_format($order->price, 2) }}</strong></span>
        </div>

        <div class="mt-2 flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
            <x-heroicon-o-envelope class="w-5 h-5 text-yellow-500" />
            <span>A receipt has been sent to your email.</span>
        </div>

        <div class="mt-6">
            <a href="{{ route('bulk.orders.index') }}"
               class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                <x-lucide-icon name="arrow-left" class="w-4 h-4" />
                Back to My Bulk Orders
            </a>
        </div>
    </div>
</div>
@endsection
