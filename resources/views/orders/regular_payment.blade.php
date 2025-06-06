@extends('layouts.master')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center mb-2">
            <x-heroicon-o-credit-card class="w-8 h-8 text-blue-600 dark:text-blue-400" />
        </div>
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Secure Checkout</h2>
        <p class="text-gray-500 dark:text-gray-300">Complete your payment to confirm your order and enjoy premium service.</p>
    </div>

    <!-- Payment Section -->
<div class="min-h-screen flex items-start md:items-center justify-center px-4 sm:px-6 lg:px-8 py-10">
  <div class="max-w-3xl w-full bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
<div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-12">
</div>
        <!-- Left: Payment Method -->
        <div class="space-y-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <x-heroicon-o-currency-dollar class="w-6 h-6 text-green-500" />
                    Payment Method
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">We currently support only card payments via Stripe.</p>
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



@php
    $firstOrder = isset($orders) && $orders->isNotEmpty() ? $orders->first() : (isset($order) ? $order : null);
    $firstOrderId = $firstOrder?->id ?? 0;
    $orderIds = isset($orders) && $orders->isNotEmpty() ? $orders->pluck('id')->implode(',') : ($order->id ?? '');
@endphp



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
    let selectedPaymentMethod = 'card';
    let discount = 0;

        let cardMounted = false;

    function updateTotalDisplay() {
        const discountedTotal = originalTotal - discount;
        finalTotalDisplay.textContent = discountedTotal.toFixed(2);
    }

    cardContainer.classList.remove('hidden');
    card.mount('#card-element');

    card.on('change', function(event) {
        const payNowBtn = document.getElementById('pay-now-btn');
        const cardErrors = document.getElementById('card-errors');

        if (event.error) {
            cardErrors.textContent = event.error.message;
            payNowBtn.disabled = true;
            payNowBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            cardErrors.textContent = '';
            if (event.complete) {
                payNowBtn.disabled = false;
                payNowBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                payNowBtn.disabled = true;
                payNowBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    });


    document.getElementById('apply-coupon-btn').addEventListener('click', () => {
        const code = document.getElementById('coupon_code').value.trim();
        const feedback = document.getElementById('coupon-feedback');
        const discountLabel = document.getElementById('discount-display');

        feedback.textContent = code ? 'Coupon will be validated during payment.' : 'No coupon entered.';
        discountLabel.textContent = 'Coupon code added. Discount will apply if valid.';
        discountLabel.classList.remove('hidden');
    });

    payNowBtn.addEventListener('click', async function () {
        const couponCode = document.getElementById('coupon_code').value.trim();

        @php
            $isMulti = isset($orders);
        @endphp

        const res = await fetch('{{ $isMulti ? route("payment.regular.multi.initiate") : route("payment.regular.initiate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                @if($isMulti)
                    order_ids: "{{ $orders->pluck('id')->implode(',') }}",
                @else
                    order_id: "{{ $order->id }}",
                @endif
                coupon: couponCode
            })
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
                const redirectUrl = new URL("/payment/regular/success", window.location.origin);
                redirectUrl.searchParams.append("order_ids", "{{ $orders->pluck('id')->implode(',') }}");
                if (couponCode) {
                    redirectUrl.searchParams.append("coupon", couponCode);
                }
                window.location.href = redirectUrl.toString();
                @else
                const redirectUrl = new URL("/payment/regular/success", window.location.origin);
                redirectUrl.searchParams.append("order_id", "{{ $order->id }}");
                if (couponCode) {
                    redirectUrl.searchParams.append("coupon", couponCode);
                }
                window.location.href = redirectUrl.toString();
                @endif
            }
        }
    });
});
</script>
@endsection

