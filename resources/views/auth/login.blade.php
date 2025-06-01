@extends('layouts.master')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Animated Background Gradient Layer -->
    <div class="absolute inset-0 z-0 animate-gradient bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    </div>

    <!-- Login Card -->
    <div class="z-10 w-full max-w-md bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-xl px-8 py-10 backdrop-blur-md animate-fade-in">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6 flex items-center justify-center gap-2">
            <x-heroicon-o-lock-closed class="w-6 h-6 text-blue-600" />
            Welcome Back to DobiPulse
        </h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-500" />
                    Email Address
                </label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                    <x-heroicon-o-key class="w-5 h-5 text-gray-500" />
                    Password
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300 transform hover:scale-[1.02]">
                    Login
                </button>
            </div>

            <!-- Register -->
            <div class="text-center text-sm text-gray-600 dark:text-gray-300">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Register here</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.8s ease-out both;
    }
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient 15s ease infinite;
    }
</style>
@endpush
@endsection
