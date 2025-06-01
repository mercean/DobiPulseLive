@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">🧺 Bulk Checkout</h2>
        <p class="text-gray-500 dark:text-gray-300">Pay for your bulk order to proceed</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">📦 Order Summary</h3>
            <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Cloth Type:</strong> {{ $order->cloth_type }}</p>
                <p><strong>Weight:</strong> {{ $order->load_kg }} kg</p>
                <p><strong>Drop-off:</strong> {{ $order->load_arrival_date }} at {{ $order->load_arrival_time }}</p>
                <p><strong>Pickup:</strong> {{ $order->pickup_date }} at {{ $order->pickup_time }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <hr class="my-2 border-gray-400">
                <p class="text-lg"><strong>Total:</strong> MYR{{ number_format($order->price, 2) }}</p>
            </div>
        </div>

        <!-- Payment Section -->
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">💳 Payment Method</h3>

            <label class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 mb-4">
                <input type="radio" name="payment_method" checked disabled class="accent-blue-600">
                <span>Credit Card (Stripe)</span>
            </label>

            <!-- Stripe Card Input -->
            <div id="card-container">
                <label for="card-element" class="block text-sm font-medium mb-1">Card Info</label>
                <div id="card-element" class="border border-gray-300 p-3 rounded dark:bg-gray-700 dark:border-gray-600"></div>
                <div id="card-errors" class="text-red-500 mt-2 text-sm"></div>
            </div>

            <!-- Pay Button -->
            <button id="pay-now-btn"
                    class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">
                ✅ Confirm & Pay
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const stripe = Stripe('pk_test_51QgC8rHYRwWWkzfTLPk4evMfgT1qOSq39ecoJMf75h4eG4pjuyJab6Yi8V6QdPRMtPAYb8N5R890WWzaoUEaNNdj009DAkAKoD');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const payBtn = document.getElementById('pay-now-btn');
        payBtn.addEventListener('click', async function (e) {
            e.preventDefault();

            const orderId = "{{ $order->id }}";

            const response = await fetch('{{ route('payment.bulk.initiate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ order_id: orderId })
            });

            const data = await response.json();
            console.log('Stripe Bulk Response:', data);

            if (data.clientSecret) {
                const result = await stripe.confirmCardPayment(data.clientSecret, {
                    payment_method: { card: cardElement }
                });

                if (result.error) {
                    document.getElementById('card-errors').textContent = result.error.message;
                } else if (result.paymentIntent.status === 'succeeded') {
                    window.location.href = "{{ route('payment.success') }}?order_id=" + orderId;
                }
            } else {
                alert('Error fetching client secret: ' + (data.error ?? 'Unknown error.'));
            }
        });
    });
</script>
@endpush
