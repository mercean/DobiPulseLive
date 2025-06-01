@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('components.bulk.sidebar')

    <main class="flex-1 p-10">
        <!-- Welcome Section -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <x-lucide-smile class="w-6 h-6 text-blue-500" />
                Welcome, {{ Auth::user()->name }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400">Manage your bulk laundry orders efficiently</p>
        </div>

        <!-- Summary Cards -->
        @php
            $totalBulkOrders = $orders->total();
            $pendingBulkOrders = $orders->filter(fn($order) => $order->status === 'pending')->count();
            $totalBulkWeight = $orders->sum('load_kg');
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex items-center gap-4">
                <x-lucide-layers class="w-6 h-6 text-purple-500" />
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Bulk Orders</div>
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $totalBulkOrders }}</div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex items-center gap-4">
                <x-lucide-loader class="w-6 h-6 text-yellow-500" />
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Pending (This Page)</div>
                    <div class="text-2xl font-bold text-yellow-500 dark:text-yellow-400">{{ $pendingBulkOrders }}</div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex items-center gap-4">
                <x-lucide-weight class="w-6 h-6 text-indigo-500" />
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Weight (This Page)</div>
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($totalBulkWeight, 1) }} kg</div>
                </div>
            </div>
        </div>

        <!-- Create + Filter -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <a href="{{ route('bulk.orders.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                <x-lucide-plus class="w-5 h-5" /> New Bulk Order
            </a>

            <!-- Filter -->
            <form method="GET" action="{{ route('bulk.orders.index') }}" class="flex items-center gap-2">
                <label for="status" class="text-sm text-gray-700 dark:text-gray-300">Filter Status:</label>
                <select name="status" id="status"
                        class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 px-3 py-1"
                        onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="PayNow" {{ request('status') === 'PayNow' ? 'selected' : '' }}>PayNow</option>
                    <option value="Paid" {{ request('status') === 'Paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </form>
        </div>

        <!-- Bulk Orders Table -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <x-lucide-package class="w-5 h-5 text-indigo-500" />
                Your Bulk Orders
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                        <tr>
                            <th class="px-6 py-3">Cloth Type</th>
                            <th class="px-6 py-3">Weight (kg)</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Price</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">{{ $order->cloth_type }}</td>
                            <td class="px-6 py-4">{{ $order->load_kg }}</td>
                            <td class="px-6 py-4">{{ ucfirst($order->status) }}</td>
                            <td class="px-6 py-4">
                                @if($order->price && $order->price > 0)
                                    RM{{ number_format($order->price, 2) }}
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('bulk.orders.edit', $order->id) }}"
                                   class="inline-flex items-center text-indigo-600 hover:underline">
                                    <x-lucide-pencil class="w-4 h-4 mr-1" /> Edit
                                </a>

                                <form action="{{ route('bulk.orders.destroy', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center text-red-600 hover:underline">
                                        <x-lucide-trash-2 class="w-4 h-4 mr-1" /> Delete
                                    </button>
                                </form>

                                @if($order->status === 'PayNow' && $order->price > 0)
                                    <a href="{{ route('payment.bulk.gateway', $order->id) }}"
                                       class="inline-flex items-center text-green-600 hover:underline">
                                        <x-lucide-wallet class="w-4 h-4 mr-1" /> Pay Now
                                    </a>
                                @elseif($order->status === 'Paid')
                                    <span class="ml-2 text-gray-400 italic flex items-center gap-1">
                                        <x-lucide-badge-check class="w-4 h-4 text-green-500" /> Paid
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">
                                No bulk orders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
