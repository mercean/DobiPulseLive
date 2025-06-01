@props(['orders'])

<section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow transition duration-300 mb-8">
    <h2 class="text-xl font-semibold mb-4">🧾 Transaction History</h2>

    @if($orders->isEmpty())
        <p class="text-gray-600 dark:text-gray-300">No transactions found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-600">
                        <th>Order ID</th>
                        <th>Total Price (RM)</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                    @foreach ($orders as $order)
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td>{{ $order->id }}</td>
                            <td>RM{{ $order->total_amount }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ url('/orders/new') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create New Order</a>
</section>
