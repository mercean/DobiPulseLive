@extends('layouts.master')

@section('content')
<div class="relative overflow-hidden">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-20 px-4 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-5xl font-extrabold mb-4">About Us</h1>
            <p class="text-lg font-medium leading-relaxed">Revolutionizing the self-service laundromat experience with DobiPulse</p>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="bg-gray-100 dark:bg-gray-900 py-16 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <p class="text-lg text-gray-700 dark:text-gray-300 leading-loose">
                <strong>DobiPulse</strong> is a customer engagement platform crafted exclusively for
                <strong>Dobi Soho Self-Service Laundromat</strong>. We're here to reshape how customers interact with laundromats
                — offering a smarter, faster, and more personalized laundry journey.
            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 px-4 bg-white dark:bg-gray-800">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-gray-800 dark:text-white mb-12">✨ Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="flex items-start space-x-4">
                    <div class="text-green-500 text-3xl">📲</div>
                    <div>
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-white">Real-time Laundry Status</h3>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">Stay updated on your laundry with push notifications. No more waiting around!</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-yellow-500 text-3xl">🎁</div>
                    <div>
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-white">Automated Reward Programs</h3>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">Earn points, discounts, and freebies automatically every time you wash.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-blue-500 text-3xl">📦</div>
                    <div>
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-white">Bulk Order Management</h3>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">Streamlined system to manage bulk laundry drop-offs and pickups with ease.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-purple-500 text-3xl">📊</div>
                    <div>
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-white">Centralized Admin Dashboard</h3>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">Manage users, track performance, and run promotions — all from one place.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Statement -->
    <section class="bg-gradient-to-br from-blue-800 to-cyan-700 text-white py-20 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold mb-4">🌟 Our Vision</h2>
            <p class="text-lg leading-relaxed">
                At <strong>DobiPulse</strong>, we believe in building a smarter laundromat experience focused on
                <strong>convenience</strong>, <strong>automation</strong>, and <strong>customer delight</strong>.
                We aim to lead the digital transformation of self-service laundromats in Malaysia — and beyond.
            </p>
        </div>
    </section>
</div>
@endsection
