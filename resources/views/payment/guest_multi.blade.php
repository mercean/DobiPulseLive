@extends('layouts.master')

@section('content')
<div class="max-w-2xl mx-auto py-12 text-center text-gray-800 dark:text-white">
    <h1 class="text-2xl font-bold mb-4">🧾 Guest Payment</h1>
    <p class="mb-6">You are paying as a guest. Please complete the payment below.</p>

    @foreach ($orders as $order)
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4 text-left">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Machine:</strong> {{ $order->machine_id }}</p>
            <p><strong>Amount:</strong> RM {{ number_format($order->total_amount, 2) }}</p>
        </div>
    @endforeach

    <form id="payment-form" class="mt-6">
        <div id="card-element" class="p-4 border border-gray-300 rounded bg-white dark:bg-gray-900"></div>
        <button id="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded">Pay Now</button>
        <div id="payment-message" class="mt-4 text-sm text-red-500"></div>
    </form>
</div>

<!-- Stripe Scripts -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const stripe = Stripe("{{ config('services.stripe.key') }}");

        // 👇 Get client secret from your initiate endpoint (optional: pass it from controller)
        const response = await fetch("{{ route('payment.guest.initiate') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                order_ids: "{{ request()->order_ids }}",
                guest_email: "{{ session('guest_email') }}"
            }),
        });

        const { clientSecret } = await response.json();

        const elements = stripe.elements();
        const card = elements.create("card");
        card.mount("#card-element");

        const form = document.getElementById("payment-form");
        const message = document.getElementById("payment-message");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card,
                }
            });

            if (error) {
                message.textContent = error.message;
            } else if (paymentIntent.status === "succeeded") {
                window.location.href = "{{ route('payment.guest.success') }}?order_ids={{ request()->order_ids }}";
            }
        });
    });
</script>
@endsection
