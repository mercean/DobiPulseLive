@extends('layouts.master')

@section('content')
<div class="container mx-auto max-w-xl px-6 py-10 bg-white dark:bg-gray-900 rounded-xl shadow">
    <div class="flex items-center gap-3 mb-6">
        <x-heroicon-o-shield-check class="w-6 h-6 text-blue-600 dark:text-blue-400" />
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Create New Admin</h2>
    </div>

    <form action="{{ route('admin.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
            <div class="relative">
                <x-heroicon-o-user class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" />
                <input type="text" name="name" id="name" required
                    class="pl-10 pr-4 py-2 w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring focus:border-blue-500" />
            </div>
        </div>

        <div>
            <label for="email" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
            <div class="relative">
                <x-heroicon-o-envelope class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" />
                <input type="email" name="email" id="email" required
                    class="pl-10 pr-4 py-2 w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring focus:border-blue-500" />
            </div>
        </div>

        <div>
            <label for="password" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <div class="relative">
                <x-heroicon-o-lock-closed class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" />
                <input type="password" name="password" id="password" required
                    class="pl-10 pr-4 py-2 w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring focus:border-blue-500" />
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
            <div class="relative">
                <x-heroicon-o-lock-closed class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" />
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="pl-10 pr-4 py-2 w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring focus:border-blue-500" />
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold shadow">
                <x-heroicon-o-plus-circle class="w-5 h-5" />
                Create Admin
            </button>
        </div>
    </form>
</div>
@endsection
