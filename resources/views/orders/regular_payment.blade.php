@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">🏍️ Checkout</h2>
        <p class="text-gray-500 dark:text-gray-300">Complete your payment to confirm your order</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Payment Options -->
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">💳 Payment Method</h3>
            <div class="space-y-4">
                <label class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="payment_method" value="card" class="accent-blue-600">
                    <span>Credit Card</span>
                </label>
                <label class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="payment_method" value="online" class="accent-blue-600">
                    <span>Online Bank Payment</span>
                </label>
                <label class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="payment_method" value="tng" class="accent-blue-600">
                    <img src="{{ asset('images/tng-logo.png') }}" alt="Touch N Go" class="w-24">
                </label>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">📦 Order Summary</h3>
            <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                @php
                    $totalAmount = 0;
                @endphp

                @if(isset($orders))
                    @foreach ($orders as $order)
                        <p><strong>Machine:</strong> {{ $order->machine_id }} — <strong>{{ $order->required_time }} mins</strong> ({{ ($order->required_time / 30) * 50 }} pts)</p>
                        @php $totalAmount += $order->total_amount; @endphp
                    @endforeach
                @else
                    <p><strong>Machine:</strong> {{ $order->machine_id }} — <strong>{{ $order->required_time }} mins</strong> ({{ ($order->required_time / 30) * 50 }} pts)</p>
                    @php $totalAmount = $order->total_amount; @endphp
                @endif

                <!-- Coupon -->
                <div class="mt-4">
                    <label for="coupon_code" class="block text-sm font-medium">🎟️ Have a Coupon?</label>
                    <div class="flex space-x-2 mt-1">
                        <input type="text" id="coupon_code" placeholder="Enter coupon code"
                               class="flex-1 px-3 py-2 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <button type="button" id="apply-coupon-btn"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Apply
                        </button>
                    </div>
                    <p id="coupon-feedback" class="text-sm mt-2 text-gray-600 dark:text-gray-400"></p>
                    <p id="discount-display" class="text-sm font-semibold text-green-500 mt-1 hidden"></p>
                </div>

                @if(isset($coupons) && $coupons->isNotEmpty())
                <details class="mt-6">
                    <summary class="cursor-pointer text-sm font-semibold text-blue-600 dark:text-blue-400">💡 Show Available Coupons</summary>
                    <div class="mt-2 space-y-2">
                        @foreach ($coupons as $coupon)
                            <button type="button"
                                class="w-full text-left px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-blue-800 rounded transition"
                                onclick="document.getElementById('coupon_code').value = '{{ $coupon->code }}'; document.getElementById('apply-coupon-btn').click();">
                                <strong>{{ $coupon->code }}</strong> — 
                                @if ($coupon->type === 'percent')
                                    {{ $coupon->value }}% off
                                @elseif($coupon->type === 'fixed')
                                    RM{{ $coupon->value }} off
                                @else
                                    {{ $coupon->value }}
                                @endif
                            </button>
                        @endforeach
                    </div>
                </details>
                @endif

                <p class="mt-4"><strong>Total:</strong> RM<span id="final-total">{{ number_format($totalAmount, 2) }}</span></p>
            </div>

            <!-- Stripe Card Input -->
            <div id="card-container" class="mt-6 hidden">
                <label for="card-element" class="block text-sm font-medium">Card Info</label>
                <div id="card-element" class="border border-gray-300 p-3 rounded dark:bg-gray-700 dark:border-gray-600"></div>
                <div id="card-errors" class="text-red-500 mt-2 text-sm"></div>
            </div>

            <button id="pay-now-btn" disabled
                    class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded opacity-50 cursor-not-allowed">
                ✅ Confirm & Pay
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create('card');
    const cardContainer = document.getElementById('card-container');
    const payNowBtn = document.getElementById('pay-now-btn');
    const originalTotal = {{ $totalAmount }};
    const finalTotalDisplay = document.getElementById('final-total');
    let selectedPaymentMethod = null;
    let discount = 0;

@php
    $firstOrder = isset($orders) && $orders->isNotEmpty() ? $orders->first() : (isset($order) ? $order : null);
    $firstOrderId = $firstOrder?->id ?? 0;
    $orderIds = isset($orders) && $orders->isNotEmpty() ? $orders->pluck('id')->implode(',') : ($order->id ?? '');
@endphp

    let cardMounted = false;

    function updateTotalDisplay() {
        const discountedTotal = originalTotal - discount;
        finalTotalDisplay.textContent = discountedTotal.toFixed(2);
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', () => {
            selectedPaymentMethod = radio.value;
            if (selectedPaymentMethod === 'card') {
                cardContainer.classList.remove('hidden');
                if (!cardMounted) {
                    card.mount('#card-element');
                    cardMounted = true;
                }
            } else {
                cardContainer.classList.add('hidden');
                if (cardMounted) {
                    card.unmount();
                    cardMounted = false;
                }
            }

            // ✅ Always enable Pay button once a payment method is selected
            payNowBtn.disabled = false;
            payNowBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        });
    });


    document.getElementById('apply-coupon-btn').addEventListener('click', () => {
        const code = document.getElementById('coupon_code').value.trim();
        const feedback = document.getElementById('coupon-feedback');
        const discountLabel = document.getElementById('discount-display');

        feedback.textContent = code ? 'Coupon will be validated during payment.' : 'No coupon entered.';
        discountLabel.textContent = 'Coupon code added. Discount will apply if valid.';
        discountLabel.classList.remove('hidden');
        payNowBtn.disabled = false;
        payNowBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    });

    payNowBtn.addEventListener('click', async function () {
        if (selectedPaymentMethod !== 'card') {
            alert('Only Credit Card is currently supported. Please select it to continue.');
            return;
        }

        const couponCode = document.getElementById('coupon_code').value.trim();

        const res = await fetch('{{ route("payment.regular.initiate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ order_id: "{{ $firstOrderId }}", coupon: couponCode })
        });

        const data = await res.json();
        if (data.clientSecret) {
            const result = await stripe.confirmCardPayment(data.clientSecret, {
                payment_method: { card: card }
            });

            if (result.error) {
                document.getElementById('card-errors').textContent = result.error.message;
            } else if (result.paymentIntent.status === 'succeeded') {
                @if(isset($orders))
                    window.location.href = "/payment/regular/success?order_ids={{ $orders->pluck('id')->implode(',') }}";
                @else
                    window.location.href = "/payment/regular/success?order_id={{ $order->id }}";
                @endif

            }
        }
    });
});
</script>
@endsection
