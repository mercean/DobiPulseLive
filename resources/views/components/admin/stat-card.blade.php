@props([
    'title',
    'value',
    'color' => 'text-blue-600 dark:text-blue-400',
])

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $title }}</h2>
    <p class="text-3xl font-bold {{ $color }} mt-2">{{ $value }}</p>
</div>
