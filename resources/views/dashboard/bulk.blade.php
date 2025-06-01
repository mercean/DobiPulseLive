@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    @include('components.bulk.sidebar')

    <main class="flex-1 p-6 lg:p-10 space-y-8 container mx-auto">

        <!-- Welcome Header with Avatar -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff&size=80' }}" 
                     class="w-16 h-16 rounded-full border-4 border-purple-500 shadow-md">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold">Welcome, {{ Auth::user()->name }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your bulk laundry orders efficiently.</p>
                </div>
            </div>
        </div>

        <!-- Profile + Quick Action -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Profile -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4">Profile Summary</h2>
                <div class="flex items-center gap-4">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff&size=80' }}" class="w-16 h-16 rounded-full border-4 border-blue-500 shadow-md">
                    <div>
                        <p class="text-lg font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('edit.profile') }}" class="text-blue-600 hover:underline text-sm">Update Profile Info</a>
                </div>
            </div>

            <!-- Quick Action -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex flex-col justify-between border-l-4 border-purple-500">
                <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400 mb-2">
                    <x-heroicon-o-plus-circle class="w-6 h-6" />
                    <h2 class="text-lg font-semibold">Quick Action</h2>
                </div>
                <p class="mb-4 text-gray-700 dark:text-gray-300">Have a new bulk order? Start right away.</p>
                <a href="{{ route('bulk.orders.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded shadow text-center transition">
                    Request New Bulk Order
                </a>
            </div>
        </div>

        <!-- Order Summary Cards -->
        @php
            $totalBulkOrders = $orders->total();
            $pendingBulkOrders = $orders->filter(fn($o) => $o->status === 'pending')->count();
            $totalBulkWeight = $orders->sum('load_kg');
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow text-center">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Total Bulk Orders</h3>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $totalBulkOrders }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow text-center">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Pending This Page</h3>
                <p class="text-3xl font-bold text-yellow-500 dark:text-yellow-400 mt-2">{{ $pendingBulkOrders }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow text-center">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Total Load (This Page)</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">{{ number_format($totalBulkWeight, 1) }} kg</p>
            </div>
        </div>

        <!-- Optional Tip -->
        <div class="bg-yellow-100 dark:bg-yellow-800 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-200 p-4 rounded-xl shadow-md">
            <div class="flex items-center gap-2 mb-1">
                <x-heroicon-o-light-bulb class="w-5 h-5" />
                <p class="font-bold">Tip:</p>
            </div>
            <p>Submit your bulk laundry requests before 8PM for same-day processing.</p>
        </div>

        <!-- Bulk Orders Table -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex items-center gap-2 mb-4 text-gray-800 dark:text-white">
                <x-heroicon-o-archive-box class="w-6 h-6" />
                <h2 class="text-xl font-semibold">Your Bulk Orders</h2>
            </div>
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
                        @foreach ($orders as $order)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">{{ $order->cloth_type }}</td>
                                <td class="px-6 py-4">{{ $order->load_kg }}</td>
                                <td class="px-6 py-4 capitalize">{{ $order->status }}</td>
                                <td class="px-6 py-4">
                                    @if($order->price && $order->price > 0)
                                        RM{{ number_format($order->price, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex items-center gap-3 flex-wrap">
                                    <a href="{{ route('bulk.orders.edit', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded">
                                        <x-heroicon-o-pencil-square class="w-4 h-4" />
                                        Edit
                                    </a>

                                    <form action="{{ route('bulk.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded">
                                            <x-heroicon-o-trash class="w-4 h-4" />
                                            Delete
                                        </button>
                                    </form>

                                    @if($order->status === 'PayNow' && $order->price > 0)
                                        <a href="{{ route('payment.bulk.gateway', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded">
                                            <x-heroicon-o-credit-card class="w-4 h-4" />
                                            Pay Now
                                        </a>
                                    @elseif($order->status === 'Paid')
                                        <span class="inline-flex items-center gap-1 text-gray-400 text-xs font-semibold">
                                            <x-heroicon-o-check-circle class="w-4 h-4" />
                                            Paid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>

    </main>
</div>
@endsection
