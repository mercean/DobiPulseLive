@extends('layouts.master')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">🔔 All Notifications</h1>

    <form action="{{ route('notifications.readall') }}" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ✅ Mark All as Read
        </button>
    </form>

    @forelse ($notifications as $notification)
        <div class="bg-white dark:bg-gray-800 shadow mb-4 rounded p-4 border-l-4 
                    {{ $notification->read_at ? 'border-gray-400' : 'border-blue-600' }}">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ $notification->data['title'] ?? 'Notification' }}
            </h2>
            <p class="text-gray-600 dark:text-gray-300">{{ $notification->data['body'] ?? '-' }}</p>
            <p class="text-sm text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
            @if(isset($notification->data['url']))
                <a href="{{ $notification->data['url'] }}" class="text-blue-600 text-sm hover:underline">
                    ➡ View
                </a>
            @endif
        </div>
    @empty
        <p class="text-center text-gray-500 dark:text-gray-400">You have no notifications.</p>
    @endforelse

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
