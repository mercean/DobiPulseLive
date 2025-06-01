@extends('layouts.master')

@section('content')
<div class="bg-gray-100 dark:bg-gray-900 py-20 px-6">
    <div class="max-w-5xl mx-auto text-center">
        <!-- Hero Title -->
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-white mb-6">
            🧺 Our Services
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-12">
            We’re redefining how self-service laundromats work — smarter, faster, and more rewarding.
        </p>

        <!-- Service Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-xl transition duration-300">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="text-green-500 text-3xl">📡</div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Real-Time Laundry Status</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300">Receive instant updates on your laundry cycle — no more waiting or guessing.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-xl transition duration-300">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="text-yellow-400 text-3xl">🎁</div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Automated Rewards Program</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300">Earn points every time you wash. Redeem them for discounts, vouchers, or freebies!</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-xl transition duration-300">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="text-blue-500 text-3xl">📦</div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Bulk Order Management</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300">Have a lot to wash? We support seamless drop-off and tracking for bulk orders.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-xl transition duration-300">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="text-indigo-500 text-3xl">💳</div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Secure Online Payments</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300">Pay quickly with credit card or e-wallet. No cash? No problem.</p>
            </div>
        </div>
    </div>
</div>
@endsection
