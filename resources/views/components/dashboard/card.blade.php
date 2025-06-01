@props(['title', 'value'])

<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center transition duration-300">
    <h3 class="text-lg font-semibold mb-2">{{ $title }}</h3>
    <p class="text-3xl font-bold">{{ $value }}</p>
</div>
