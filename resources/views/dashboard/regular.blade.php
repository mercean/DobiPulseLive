@extends('layouts.master')

@section('content')
<div x-data="{ showHistory: false }" class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    @include('components.regular.sidebar')

    <main class="flex-1 p-6 lg:p-10 space-y-8 container mx-auto">
        <!-- Welcome Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex items-center gap-4">
                @if(auth()->check())
                    <img src="{{ Auth::user()->avatar 
                                ? asset('storage/' . Auth::user()->avatar) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff&size=80' }}" 
                         class="w-16 h-16 rounded-full border-4 border-blue-500 shadow-md object-cover">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white">
                            Welcome, {{ Auth::user()->name }}
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Here’s your personalized laundry dashboard.
                        </p>
                    </div>
                @else
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white">
                            Welcome, Guest
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            You’re checking out as a guest. Please enter your email to receive a receipt.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- CTA Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-2">
            <p class="text-base font-semibold text-gray-700 dark:text-gray-200 flex items-center gap-2">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500" />
                Need to wash or dry clothes? Let’s get started.
            </p>
            <a href="{{ route('orders.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow transition">
                <x-heroicon-o-plus-circle class="w-5 h-5" />
                Start a New Laundry Session
            </a>
        </div>

        @if (!auth()->check())
            <form action="{{ route('guest.email.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-xl shadow w-full max-w-md">
                @csrf
                <label for="guest_email" class="block mb-2 font-medium">Enter your email to receive receipt</label>
                <input type="email" name="guest_email" id="guest_email" placeholder="e.g. guest@example.com"
                       class="w-full px-4 py-2 rounded border dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                <button type="submit"
                        class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Save Email
                </button>
            </form>
        @endif

        @if($promos->isNotEmpty())
            <div class="bg-yellow-100 dark:bg-yellow-800 border-l-4 border-yellow-500 text-yellow-900 dark:text-yellow-100 p-4 mb-6 rounded shadow">
                <h3 class="text-lg font-bold mb-2">🎉 Current Promotions</h3>
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($promos as $promo)
                        <li class="mb-4 list-none">
                            @if ($promo->promo_image)
                                <img src="{{ asset('storage/' . $promo->promo_image) }}" alt="Promo Image" class="w-full max-h-48 object-cover mb-2 rounded-xl shadow">
                            @endif

                            <strong class="text-lg">{{ $promo->title }}</strong><br>
                            <span class="text-sm">{{ $promo->description }}</span><br>
                            <span class="text-xs text-gray-600 dark:text-gray-300">
                                {{ $promo->start_date->format('M d') }} - {{ $promo->end_date->format('M d, Y') }}
                            </span><br>

                            @if ($promo->type === 'percent')
                                <span class="text-green-700 dark:text-green-300 font-semibold">{{ $promo->value }}% off</span>
                            @else
                                <span class="text-green-700 dark:text-green-300 font-semibold">RM{{ number_format($promo->value, 2) }} off</span>
                            @endif

                            @if($promo->code)
                                <div class="mt-1 text-xs">
                                    Use Code: <span class="bg-white text-black px-2 py-1 rounded font-mono">{{ $promo->code }}</span>
                                </div>
                            @elseif($promo->auto_apply)
                                <div class="mt-1 text-xs text-green-600 dark:text-green-400 font-semibold">Auto Applied at Checkout</div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-dashboard.card title="Orders" :value="$orders->count()" icon="o-clipboard-document-list" />
            <x-dashboard.card title="Total Spent" :value="'RM' . $orders->sum('total_amount')" icon="o-banknotes" />
            @if(auth()->check())
                <x-dashboard.points :points="$points" icon="o-star" />
            @endif
        </div>

        @if(auth()->check())
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4"> Profile Summary</h2>
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-16 h-16 rounded-full border-4 border-blue-500 shadow-md">
                    <div>
                        <p class="text-lg font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('edit.profile') }}" class="text-blue-600 hover:underline text-sm">Update Profile Info</a>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4">Active Orders</h2>
            @php
                $activeOrders = $orders->filter(fn($o) => in_array($o->status, ['pending', 'processing', 'approved', 'PayNow', 'completed']));
            @endphp
            @if ($activeOrders->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">No active orders at the moment.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2">Order ID</th>
                                <th class="px-4 py-2">Machine</th>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @foreach ($activeOrders as $order)
                                <tr>
                                    <td class="px-4 py-2">{{ $order->id }}</td>
                                    <td class="px-4 py-2">#{{ $order->machine_id }}</td>
                                    <td class="px-4 py-2">{{ $order->required_time }} min</td>
                                    <td class="px-4 py-2 capitalize">
                                        {{ $order->status }}
                                        @if (in_array($order->status, ['approved', 'PayNow']) && $order->end_time)
                                            <br>
                                            <span class="countdown text-yellow-500 text-xs block" data-end-time="{{ $order->end_time->format('Y-m-d\TH:i:s') }}">
                                                Loading...
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Transaction History</h2>
                <button @click="showHistory = !showHistory" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 rounded-lg">
                    <span x-text="showHistory ? 'Hide History' : 'Show History'"></span>
                </button>
            </div>
            <div x-show="showHistory" x-transition>
                @if ($orders->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-2">Order ID</th>
                                    <th class="px-4 py-2">Total</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-4 py-2">{{ $order->id }}</td>
                                        <td class="px-4 py-2">RM{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                                        <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-2">
                                            @if ($order->status === 'pending')
                                                <a href="{{ route('payment.regular.page', ['order' => $order->id]) }}"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Pay Now
                                                </a>
                                            @else
                                                <a href="{{ route('receipt.download', $order->id) }}"
                                                class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                    <x-heroicon-o-document-arrow-down class="w-4 h-4" />
                                                    Receipt
                                                </a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.countdown').forEach(span => {
            const endTime = new Date(span.dataset.endTime).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance <= 0) {
                    span.innerText = "Completed";
                    span.classList.remove("text-yellow-500");
                    span.classList.add("text-green-500");
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
