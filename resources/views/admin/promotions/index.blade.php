@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <x-heroicon-o-megaphone class="w-6 h-6 text-blue-600 dark:text-blue-400" />
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Manage Promotions</h2>
    </div>

    <!-- Active Promotion Stat -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="rounded-xl bg-yellow-50 dark:bg-gray-800 p-6 shadow flex items-center gap-4">
            <x-heroicon-o-gift class="w-10 h-10 text-yellow-500 dark:text-yellow-400" />
            <div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Active Promotions</div>
                <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                    {{ $promotions->filter(fn($p) => now()->between($p->start_date, $p->end_date))->count() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Promotion Button -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('promotions.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-3 rounded-xl shadow transition">
            <x-heroicon-o-plus-circle class="w-5 h-5" />
            Add Promotion
        </a>
    </div>

    <!-- Promotion Table -->
    <div class="w-full overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
        <table class="min-w-full table-auto text-base text-left text-gray-900 dark:text-gray-100">
            <thead class="bg-gray-100 dark:bg-gray-700 text-base">
                <tr>
                    <th class="px-6 py-4">
                        <x-heroicon-o-photo class="w-5 h-5 inline text-gray-500" />
                    </th>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Value</th>
                    <th class="px-6 py-4">Start</th>
                    <th class="px-6 py-4">End</th>
                    <th class="px-6 py-4">Auto</th>
                    <th class="px-6 py-4">Code</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">
                        <x-heroicon-o-cog-6-tooth class="w-5 h-5 inline text-gray-500" />
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                @forelse ($promotions as $promo)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4">
                            @if($promo->promo_image)
                                <img src="{{ asset('storage/' . $promo->promo_image) }}" alt="Promo" class="w-20 h-12 object-cover rounded shadow">
                            @else
                                <span class="text-sm text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold">{{ $promo->title }}</td>
                        <td class="px-6 py-4 capitalize">{{ $promo->type }}</td>
                        <td class="px-6 py-4">
                            @if($promo->type === 'percent')
                                {{ $promo->value }}%
                            @else
                                RM{{ number_format($promo->value, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $promo->start_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">{{ $promo->end_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 text-sm rounded {{ $promo->auto_apply ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ $promo->auto_apply ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono text-sm">{{ $promo->code ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if(now()->between($promo->start_date, $promo->end_date))
                                <span class="inline-block px-3 py-1 bg-green-600 text-white text-sm rounded-lg">Active</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-400 text-white text-sm rounded-lg">Expired</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('promotions.edit', $promo) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('promotions.destroy', $promo) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this promotion?')" class="text-red-600 hover:underline font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                            No promotions added yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $promotions->links('pagination::tailwind') }}
    </div>
</div>
@endsection
