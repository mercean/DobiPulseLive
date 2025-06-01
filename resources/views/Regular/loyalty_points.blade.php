@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition duration-300">
    
    @include('components.regular.sidebar')

    <main class="flex-1 p-8 space-y-10 container mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-3">
            <x-heroicon-o-star class="w-7 h-7 text-yellow-400" />
            <h1 class="text-3xl font-bold">My Loyalty Points</h1>
        </div>

        <!-- Points Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold flex items-center gap-2">
                        <x-heroicon-o-chart-bar class="w-5 h-5 text-blue-500" />
                        Current Points
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Earn points through orders and redeem them for rewards.
                    </p>
                </div>
                <p class="text-5xl font-extrabold text-blue-600 dark:text-blue-400">{{ $points }} pts</p>
            </div>
        </div>

        <!-- Points Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold flex items-center gap-2 mb-4">
                <x-heroicon-o-clock class="w-5 h-5 text-purple-500" />
                Points Activity
            </h2>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @forelse($loyaltyLogs as $entry)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            @if($entry->points > 0)
                                <span class="text-green-600 font-semibold">+{{ $entry->points }} pts</span> earned
                            @else
                                <span class="text-red-500 font-semibold">{{ $entry->points }} pts</span> redeemed
                            @endif
                            on {{ $entry->created_at->format('d M Y') }}
                            @if($entry->points > 0)
                                <em class="text-gray-500"> (expires {{ \Carbon\Carbon::parse($entry->expiry_date)->format('d M Y') }})</em>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="py-2 text-gray-600 dark:text-gray-400">No loyalty point activity yet.</li>
                @endforelse

                @foreach($redemptions as $redeem)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <span class="text-red-500 font-semibold">-{{ $redeem['points'] }} pts</span> redeemed on {{ $redeem['date']->format('d M Y') }}
                            <em class="text-gray-500">({{ $redeem['title'] }})</em>
                        </div>
                        <span class="text-xs text-gray-500">Coupon: <strong>{{ $redeem['code'] }}</strong></span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Coupons -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold flex items-center gap-2 mb-4">
                <x-heroicon-o-ticket class="w-5 h-5 text-indigo-500" />
                My Coupons
            </h2>

            @if ($coupons->isEmpty())
                <p class="text-sm text-gray-600 dark:text-gray-400">You have not redeemed any coupons yet.</p>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($coupons as $coupon)
                        <div class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-4 shadow">
                            <p class="text-xs uppercase text-gray-400 mb-1">Coupon Code</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300 mb-2">{{ $coupon->code }}</p>
                            <p class="text-sm">Type: <span class="capitalize">{{ $coupon->type }}</span></p>
                            <p class="text-sm">
                                Value:
                                @if ($coupon->type === 'percent')
                                    {{ $coupon->value }}%
                                @elseif ($coupon->type === 'fixed')
                                    RM{{ $coupon->value }}
                                @else
                                    {{ $coupon->value }}
                                @endif
                            </p>
                            <p class="mt-2 text-xs font-semibold {{ $coupon->used ? 'text-red-500' : 'text-green-500' }}">
                                {{ $coupon->used ? 'Used' : 'Unused' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- CTA -->
        <div class="text-center">
            <a href="{{ route('redeem_catalog') }}"
               class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow transition">
                <x-heroicon-o-gift class="w-5 h-5" />
                View Redeem Catalog
            </a>
        </div>
    </main>
</div>
@endsection
