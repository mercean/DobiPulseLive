@props(['points', 'max' => 100])

@php
    $percentage = min(100, ($points / $max) * 100);
@endphp

<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center transition duration-300">
    <h3 class="text-lg font-semibold mb-2">Loyalty Points</h3>
    <p class="text-3xl font-bold mb-2">{{ $points }}</p>
    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
        <div class="bg-blue-600 h-4 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
    </div>

