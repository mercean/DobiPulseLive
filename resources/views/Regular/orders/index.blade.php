@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">

    <!-- Sidebar -->
    @include('components.regular.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8 space-y-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">My Orders</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow flex items-center gap-4">
                <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-blue-500" />
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Total Orders</p>
                    <p class="text-xl font-semibold">{{ $orders->count() }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow flex items-center gap-4">
                <x-heroicon-o-check-badge class="w-6 h-6 text-green-500" />
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Approved</p>
                    <p class="text-xl font-semibold">{{ $orders->where('status', 'approved')->count() }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow flex items-center gap-4">
                <x-heroicon-o-clock class="w-6 h-6 text-yellow-500" />
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Pending</p>
                    <p class="text-xl font-semibold">{{ $orders->where('status', 'pending')->count() }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow flex items-center gap-4">
                <x-heroicon-o-banknotes class="w-6 h-6 text-indigo-500" />
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Total Spent</p>
                    <p class="text-xl font-semibold">RM{{ number_format($orders->sum('total_amount'), 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @if ($orders->isEmpty())
                <p class="text-gray-600 dark:text-gray-300">You have not placed any orders yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2">Order ID</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 py-2">{{ $order->order_number }}</td>
                                    <td class="px-4 py-2">RM{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2 flex flex-wrap gap-2">
                                        @if ($order->status === 'pending')
                                            <form method="POST" action="{{ route('orders.destroy', $order->id) }}" onsubmit="return confirm('Cancel this order?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                    <x-heroicon-o-trash class="w-4 h-4" /> Cancel
                                                </button>
                                            </form>
                                            <a href="{{ route('payment.regular.page', $order->id) }}" class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                                <x-heroicon-o-credit-card class="w-4 h-4" /> Pay Now
                                            </a>
                                        @elseif ($order->status === 'approved')
                                            <span class="text-green-600 dark:text-green-400 inline-flex items-center gap-1">
                                                <x-heroicon-o-check-circle class="w-4 h-4" /> Paid
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400 italic">No action</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>
</div>
@endsection
