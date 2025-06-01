@extends('layouts.master')

@section('title', 'Order Details')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mt-10 border border-gray-300 dark:border-gray-700 print:border-0 print:shadow-none print:p-4">
    
    {{-- Header --}}
    <div class="text-center mb-6">
        <div class="flex items-center justify-center text-blue-600 dark:text-blue-400 mb-2">
            <x-heroicon-o-receipt-refund class="w-8 h-8" />
        </div>
        <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white">DobiPulse Receipt</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Order ID: 
            <span class="font-medium text-gray-700 dark:text-gray-300">
                {{ $order->order_number ?? 'ORD-' . $order->id }}
            </span>
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Date: {{ $order->created_at->format('d M Y, h:i A') }}
        </p>
    </div>

    {{-- Summary --}}
    <div class="mb-4 border-t border-b py-4 space-y-2 text-sm">
        <div class="flex justify-between">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Status:</span>
            <span>{{ ucfirst($order->status) }}</span>
        </div>
        <div class="flex justify-between">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Type:</span>
            <span>{{ $order->type }}</span>
        </div>
        <div class="flex justify-between">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Total Price:</span>
            <span>RM {{ number_format($order->total_amount, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Loyalty Points:</span>
            <span>{{ $userPoints }} pts</span>
        </div>
    </div>

    {{-- Machine Details --}}
    @if ($order->machine)
    <div class="mb-6">
        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
            <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
            Machine Used
        </h3>
        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
            <p class="text-gray-700 dark:text-gray-200">
                <strong>Machine #{{ $order->machine->id }}</strong> – {{ ucfirst($order->machine->type) }} at {{ $order->machine->location }}
            </p>
        </div>
    </div>
    @endif

    {{-- Footer --}}
    <div class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8 border-t pt-4">
        Thank you for using <strong>DobiPulse</strong><br>
        Need help? Contact us on WhatsApp or visit our outlet.
    </div>

{{-- Actions --}}
<div class="mt-6 flex justify-center gap-4 print:hidden">
    <a href="{{ route('regular.orders') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Orders
    </a>
    <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">
        <x-heroicon-o-printer class="w-5 h-5" />
        Print
    </button>
    <a href="{{ route('receipt.download', $order->id) }}" class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        <x-heroicon-o-document-arrow-down class="w-5 h-5" />
        Download PDF
    </a>
</div>

@endsection
