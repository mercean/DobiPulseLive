@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6">
    @include('components.regular.sidebar')

    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">🧺 Choose Machines for Your Session</h2>
        <p class="text-gray-500 dark:text-gray-300 mt-1">Select one or more machines and set their time</p>
    </div>

    <!-- Type Filter -->
    <div class="mb-6">
        <label for="type_filter" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Filter by Machine Type:</label>
        <select id="type_filter" class="w-full max-w-xs px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="all">All</option>
            <option value="washer">Washer</option>
            <option value="dryer">Dryer</option>
        </select>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Machine Table -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">🛠️ Machine Selection</h3>
                <table class="w-full table-auto text-sm text-left rounded overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-600 text-gray-700 dark:text-gray-300" id="machine_table_body">
                        @foreach ($machines as $machine)
         {{-- DEBUG --}}



                            @php
                                $active = $machine->active_order;
                                $isPendingBuyer = $machine->status === 'available' && $active && $active->status === 'PayNow';
                                $isCountdown = $active && $active->status === 'approved' && $active->end_time;
                            @endphp
                            <tr class="machine-row" data-type="{{ strtolower($machine->type) }}">
                                <td class="px-4 py-2">{{ $machine->id }}</td>
                                <td>{{ ucfirst($machine->type) }} <span class="text-xs text-gray-400">({{ $machine->type === 'dryer' ? 'RM4/30min' : 'RM5/30min' }})</span></td>
                                <td>{{ $machine->location ?? '-' }}</td>
                                <td>
                                    @if ($isCountdown)
                                        <span class="countdown text-yellow-500" data-end-time="{{ $active->end_time->toIso8601String() }}">Calculating...</span>
                                    @elseif ($isPendingBuyer)
                                        <span class="text-purple-500 font-medium">Pending Buyer</span>
                                    @elseif ($machine->status === 'maintenance')
                                        <span class="text-red-500 font-medium">Maintenance</span>
                                    @else
                                        <span class="text-green-600 font-medium">Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if (
                                        in_array(strtolower($machine->status), ['available', 'ready']) &&
                                        !$isPendingBuyer
                                    )
                                        <input type="checkbox" name="machine_ids[]" value="{{ $machine->id }}" class="machine-checkbox" data-type="{{ strtolower($machine->type) }}">
                                    @else
                                        <input type="checkbox" disabled class="opacity-50">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cart Summary -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">🧾 Session Summary</h3>
                <div id="cart_summary" class="space-y-4"></div>
               
                @guest
                <div class="mt-6">
                    <label for="guest_email" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Email for Receipt (Guests only)</label>
                    <input type="email" name="guest_email" id="guest_email" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
                @endguest

                <input type="hidden" name="total_price" id="total_price_input">
                <button type="submit" class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded disabled:opacity-50" id="checkout_btn" disabled>
                    ✅ Confirm and Proceed
                </button>
            </div>
        </div>
    </form>

    <div class="mt-10 text-center text-sm text-gray-600 dark:text-gray-400">
        📲 Earn 50 pts per 30 min. Scan machine QR after use.
    </div>
</div>
@endsection

@push('scripts')
<script>
    const typeFilter = document.getElementById('type_filter');
    const cartSummary = document.getElementById('cart_summary');
    const checkoutBtn = document.getElementById('checkout_btn');
    const totalPriceInput = document.getElementById('total_price_input');

    function getRate(type) {
        return type === 'dryer' ? 4 : 5;
    }

    function getPoints(time) {
        return (time / 30) * 50;
    }

    function updateCart() {
        cartSummary.innerHTML = '';
        let total = 0;
        let selected = false;

        document.querySelectorAll('.machine-checkbox:checked').forEach((checkbox, index) => {
            const id = checkbox.value;
            const type = checkbox.dataset.type;
            const rate = getRate(type);

            const container = document.createElement('div');
            container.className = 'p-4 bg-gray-100 dark:bg-gray-700 rounded';

            container.innerHTML = `
                <p class="font-medium text-sm text-gray-700 dark:text-gray-300">Machine #${id} (${type})</p>
                <select name="required_times[${id}]" class="w-full mt-2 px-3 py-2 border rounded dark:bg-gray-600 dark:text-white required-time-select" data-type="${type}">
                    <option value="30">30 min</option>
                    <option value="60">60 min</option>
                    <option value="90">90 min</option>
                    <option value="120">120 min</option>
                </select>
                <p class="text-xs mt-2 text-gray-500 dark:text-gray-300">💰 Est. Price: <span class="est-price">RM${rate.toFixed(2)}</span> | 🎁 Points: <span class="est-points">50</span></p>
            `;

            cartSummary.appendChild(container);
            total += rate;
            selected = true;
        });

        totalPriceInput.value = total.toFixed(2);
        checkoutBtn.disabled = !selected;
        attachTimeChangeListeners();
    }

    function attachTimeChangeListeners() {
        document.querySelectorAll('.required-time-select').forEach(select => {
            select.addEventListener('change', function () {
                const time = parseInt(this.value);
                const rate = getRate(this.dataset.type);
                const price = (time / 30) * rate;
                const points = getPoints(time);
                const parent = this.closest('div');
                parent.querySelector('.est-price').innerText = 'RM' + price.toFixed(2);
                parent.querySelector('.est-points').innerText = points;
                recalculateTotal();
            });
        });
    }

    function recalculateTotal() {
        let total = 0;
        document.querySelectorAll('.required-time-select').forEach(select => {
            const time = parseInt(select.value);
            const rate = getRate(select.dataset.type);
            total += (time / 30) * rate;
        });
        totalPriceInput.value = total.toFixed(2);
    }

    document.querySelectorAll('.machine-checkbox').forEach(cb => {
        cb.addEventListener('change', updateCart);
    });

    typeFilter.addEventListener('change', function () {
        const selected = this.value;
        document.querySelectorAll('.machine-row').forEach(row => {
            row.style.display = (selected === 'all' || row.dataset.type === selected) ? '' : 'none';
        });
    });

document.addEventListener('DOMContentLoaded', function () {
    console.log('⏳ Countdown script loaded');

    document.querySelectorAll('.countdown').forEach(span => {
        const endTime = new Date(span.dataset.endTime).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                span.innerText = 'Available';
                span.classList.remove('text-yellow-500');
                span.classList.add('text-green-500');
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            span.innerText = `${minutes}m ${seconds}s left`;

            setTimeout(updateCountdown, 1000);
        }

        updateCountdown();
    });
});

</script>
@endpush
