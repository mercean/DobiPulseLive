<div class="max-w-xl mx-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-md p-6 print:p-0 print:shadow-none print:border-0 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
    <div class="text-center mb-4">
        @stack('receipt-icon')
        <h2 class="text-2xl font-bold mb-1">DobiPulse Receipt</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Order ID: <strong>{{ $order->order_number ?? 'ORD-' . ($order->id ?? 'Unknown') }}</strong><br>
            Date: {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
        </p>
    </div>

    <div class="border-t border-b py-4 text-sm space-y-2">
        <div class="flex justify-between">
            <span>Status:</span>
            <span>{{ ucfirst($order->status ?? 'Unknown') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Type:</span>
            <span>{{ $order->type ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between">
            <span>Total Price:</span>
            <span>RM {{ number_format($order->total_amount ?? 0, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Loyalty Points:</span>
            <span>{{ $userPoints ?? 0 }} pts</span>
        </div>
    </div>

    @if (!empty($order->machine))
        <div class="mt-4 text-sm">
            <div class="font-semibold mb-1">Machine Used</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">
                Machine #{{ $order->machine->id ?? '-' }} – {{ ucfirst($order->machine->type ?? '-') }} @ {{ $order->machine->location ?? '-' }}
            </div>
        </div>
    @endif

    <div class="text-center text-xs text-gray-500 dark:text-gray-400 mt-6 border-t pt-3">
        Thank you for choosing DobiPulse. Contact us anytime.
    </div>
</div>
