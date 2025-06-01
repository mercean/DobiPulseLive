@extends('layouts.master')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
            <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-blue-600" />
            Transaction History
        </h1>

        <a href="{{ route('admin.exportTransactionHistory') }}"
           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow transition">
            <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
            Export CSV
        </a>
    </div>

    <!-- Transaction History Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Method</th>
                    <th class="px-4 py-3">Order ID</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-200">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3 font-medium">{{ $transaction->id }}</td>
                        <td class="px-4 py-3">RM{{ number_format($transaction->amount / 100, 2) }}</td>
                        <td class="px-4 py-3 capitalize">{{ $transaction->status }}</td>
                        <td class="px-4 py-3">
                            @if (isset($transaction->payment_method_details->card))
                                {{ ucfirst($transaction->payment_method_details->card->brand) }}
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $transaction->metadata['order_id'] ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::createFromTimestamp($transaction->created)->toDateString() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                            No transactions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
