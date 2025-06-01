@extends('layouts.master')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <x-heroicon-o-clipboard-document class="w-6 h-6 text-blue-600 dark:text-blue-400" />
        Bulk Order #{{ $order->id }}
    </h1>

    <ul class="space-y-4 text-sm text-gray-700 dark:text-gray-200">
        <li class="flex items-center gap-2">
            <x-heroicon-o-tag class="w-5 h-5 text-indigo-500" />
            <span><strong>Cloth Type:</strong> {{ $order->cloth_type }}</span>
        </li>
        <li class="flex items-center gap-2">
            <x-heroicon-o-scale class="w-5 h-5 text-pink-500" />
            <span><strong>Weight:</strong> {{ $order->load_kg }} kg</span>
        </li>
        <li class="flex items-center gap-2">
            <x-heroicon-o-information-circle class="w-5 h-5 text-yellow-500" />
            <span><strong>Status:</strong> {{ ucfirst($order->status) }}</span>
        </li>
        <li class="flex items-center gap-2">
            <x-heroicon-o-calendar-days class="w-5 h-5 text-green-500" />
            <span><strong>Arrival:</strong> {{ $order->load_arrival_date }} @ {{ $order->load_arrival_time }}</span>
        </li>
        <li class="flex items-center gap-2">
            <x-heroicon-o-truck class="w-5 h-5 text-purple-500" />
            <span><strong>Pickup:</strong> {{ $order->pickup_date }} @ {{ $order->pickup_time }}</span>
        </li>
        <li class="flex items-center gap-2">
            <x-heroicon-o-currency-dollar class="w-5 h-5 text-emerald-500" />
            <span><strong>Price:</strong> RM{{ number_format($order->price, 2) }}</span>
        </li>
    </ul>

    <a href="{{ route('bulk.orders.index') }}" class="inline-flex items-center gap-1 mt-6 text-blue-500 hover:underline hover:text-blue-700 transition">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Orders
    </a>
</div>
@endsection
