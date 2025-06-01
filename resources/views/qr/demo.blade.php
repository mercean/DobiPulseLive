@extends('layouts.master')

@section('content')
<div class="min-h-screen flex justify-center items-start py-12 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-2xl space-y-8">

        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center items-center gap-2 text-3xl font-extrabold text-gray-800 dark:text-white">
                <i data-lucide="qrcode" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
                <h1>DobiPulse QR Code Demo</h1>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                This QR code simulates the scanning flow for both registered and guest users.
            </p>
        </div>

        <!-- Description -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-2">Scan Behavior:</h2>
            <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>Prompts login for registered users.</li>
                <li>Allows guests to proceed directly to machine selection.</li>
            </ul>
        </div>

        <!-- QR Code -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
            {!! QrCode::size(250)->generate(route('qr.entry')) !!}
            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                Scans to: <code class="break-all">{{ route('qr.entry') }}</code>
            </p>
        </div>

        <!-- Regenerate Button -->
        <form method="GET" action="{{ route('qr.demo') }}" class="text-center">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                <i data-lucide="refresh-ccw" class="w-5 h-5"></i>
                Regenerate QR
            </button>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
