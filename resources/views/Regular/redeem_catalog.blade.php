@extends('layouts.master')

@section('content')
<div class="flex flex-col lg:flex-row min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('components.regular.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-8 space-y-10">
        <!-- Loyalty Points Summary -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold flex items-center gap-2">
                    <x-heroicon-o-star class="w-5 h-5 text-yellow-400" />
                    Your Loyalty Points
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Points expire 6 months after earning.</p>
            </div>
            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $points }} pts</p>
        </div>

        <!-- Page Heading -->
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
            <x-heroicon-o-gift class="w-7 h-7 text-indigo-500" />
            Redemption Catalog
        </h1>

        <!-- Rewards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rewards as $item)
                <div class="flex flex-col items-center text-center bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-xl transition duration-300 min-w-[220px]">
                    <div class="text-4xl mb-3">{{ $item->icon }}</div>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $item->title }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Requires <strong>{{ $item->points_required }} pts</strong>
                    </p>

                    <form method="POST" action="{{ route('redeem.generate', $item->id) }}" class="w-full mt-auto">
                        @csrf
                        <button 
                            class="mt-4 w-full px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition {{ $points < $item->points_required ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $points < $item->points_required ? 'disabled' : '' }}>
                            Redeem
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Footer CTA -->
        <div class="mt-10 text-center text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center gap-2">
            <x-heroicon-o-camera class="w-5 h-5" />
            Scan the QR code on any laundry machine to earn more points for redemption.
        </div>
    </div>
</div>
@endsection
