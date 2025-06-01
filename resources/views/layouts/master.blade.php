@php
    $isGuestPage = $isGuestPage ?? in_array(Route::currentRouteName(), ['login', 'register', 'password.request', 'password.email', 'password.reset']);
@endphp


<!-- MASTER BLADE TEMPLATE (layouts/master.blade.php) -->
<!DOCTYPE html>
<html lang="en"
            x-data="{
          darkMode: localStorage.getItem('darkMode') === 'true',
          showSidebar: window.innerWidth >= 768,
          sidebarHovered: false
      }"
      x-init="
        $watch('darkMode', val => localStorage.setItem('darkMode', val));
        window.addEventListener('resize', () => showSidebar = window.innerWidth >= 768);
      "
      :class="{ 'dark': darkMode }"
      x-cloak>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DobiPulse</title>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-all duration-300 flex">

@if (!$isGuestPage)
    {{-- Sidebar --}}
    @auth
        @if (Auth::user()->account_type === 'regular')
            @include('components.regular.sidebar')
        @elseif (Auth::user()->account_type === 'bulk')
            @include('components.bulk.sidebar')
        @elseif (Auth::user()->account_type === 'admin')
            @include('components.admin.sidebar')
        @endif
    @endauth
@endif




  <!-- Main Content Wrapper -->
<div :class="(showSidebar || sidebarHovered) && !{{ $isGuestPage ? 'true' : 'false' }} ? 'md:ml-64' : ''" class="flex-1 flex flex-col transition-all duration-300 min-h-screen">

    <!-- Navbar -->
    <header class="bg-white dark:bg-gray-800 shadow px-4 py-4 flex items-center justify-between md:px-8 sticky top-0 z-30">
      @auth
        <!-- Burger Toggle -->
        <button @click="showSidebar = !showSidebar" class="text-gray-700 dark:text-gray-200">
          <template x-if="!showSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </template>
          <template x-if="showSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </template>
        </button>
      @endauth

<!-- Top Navigation -->
<nav class="flex-1 flex items-center justify-between">
    <!-- Left: Brand -->
    <div class="flex items-center space-x-2 text-xl font-bold text-blue-600 dark:text-blue-400">
        <x-heroicon-o-sparkles class="w-6 h-6" />
        <span>DobiPulse</span>
    </div>

    <!-- Right: Links -->
  <div class="flex items-center gap-6 text-sm pr-4">
        @guest
            <a href="{{ url('/') }}" class="flex items-center gap-1 text-gray-700 dark:text-gray-200 hover:underline font-semibold">
                <x-heroicon-o-home class="w-5 h-5" />
                HomePage
            </a>
            <a href="{{ route('register') }}" class="flex items-center gap-1 hover:underline">
                <x-heroicon-o-user-plus class="w-5 h-5" />
                Register
            </a>
            <a href="{{ route('login') }}" class="flex items-center gap-1 hover:underline">
                <x-heroicon-o-lock-closed class="w-5 h-5" />
                Login
            </a>
        @endguest

        @auth
            <a href="{{ url('/') }}" class="flex items-center gap-1 hover:underline">
                <x-heroicon-o-home class="w-5 h-5" />
                Home
            </a>
            <a href="{{ route('services') }}" class="flex items-center gap-1 hover:underline">
                <x-heroicon-o-cog class="w-5 h-5" />
                Services
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-1 hover:underline">
                <x-heroicon-o-information-circle class="w-5 h-5" />
                About
            </a>
            <a href="{{ route('edit.profile') }}" class="flex items-center gap-1 hover:underline">
                <img src="{{ Auth::user()->avatar 
                            ? asset('storage/' . Auth::user()->avatar) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff&size=32' }}" 
                     alt="Profile" class="w-6 h-6 rounded-full border">
                {{ Auth::user()->name }}
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-1 hover:underline">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5" />
                    Logout
                </button>
            </form>
        @endauth
    </div>
</nav>


        <!-- 🔔 Notification Bell -->
        @auth
        <div class="relative ml-4" x-data="{ open: false }">
          <button @click="open = !open" class="relative focus:outline-none">
            <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 
                      6.002 0 00-4-5.659V4a2 2 0 00-4 0v1.341C7.67 
                      6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 
                      1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
              </path>
            </svg>
            @if(Auth::user()->unreadNotifications->count())
              <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center animate-pulse">
                  {{ Auth::user()->unreadNotifications->count() }}
              </span>
            @endif
          </button>


          <!-- Dropdown -->
          <div x-show="open" @click.away="open = false"
               class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-lg z-50 overflow-hidden"
               x-cloak>
            <div class="px-4 py-2 font-semibold text-gray-800 dark:text-gray-100 border-b dark:border-gray-600">
              Notifications
            </div>
            <ul class="max-h-80 overflow-y-auto divide-y dark:divide-gray-700 text-sm">
              @forelse(Auth::user()->unreadNotifications->take(5) as $notif)
                <li class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <a href="{{ $notif->data['url'] ?? '#' }}" class="block">
                    <div class="font-bold text-gray-800 dark:text-white">
                      {{ $notif->data['title'] ?? 'Notification' }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400">
                      {{ $notif->data['body'] ?? '' }}
                    </div>
                    <div class="text-xs text-right text-gray-400 mt-1">
                      {{ $notif->created_at->diffForHumans() }}
                    </div>
                  </a>
                </li>
              @empty
                <li class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">No new notifications.</li>
              @endforelse
            </ul>
            <div class="text-center px-4 py-2 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600">
              <a href="{{ route('notifications.all') }}" class="text-xs text-blue-600 hover:underline">
                View All
              </a>
            </div>
          </div>
        </div>
        @endauth

        <!-- Dark mode toggle -->
        <button @click="darkMode = !darkMode"
                class="ml-2 px-2 py-1 rounded bg-gray-200 dark:bg-gray-700 text-sm">
          <span x-text="darkMode ? '☀ Light' : '🌙 Dark'"></span>
        </button>
      </nav>
    </header>

 <!-- Page Content -->
@if ($isGuestPage)
  @yield('content')
@else
  <main class="flex-1 p-4 md:p-6">
      @yield('content')
  </main>
@endif

    <!-- Footer -->
    <footer class="text-center text-sm py-6 text-gray-600 dark:text-gray-400">
      &copy; 2025 DobiPulse. All rights reserved.
    </footer>
  </div>
  
<!-- before vite -->
@auth
<script>
    window.Laravel = {
        userId: {{ Auth::id() }}
    };
</script>
@endauth

<!-- In layouts/master.blade.php head section -->
@vite(['resources/css/app.css', 'resources/js/app.js'])



<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

@yield('scripts')
@stack('scripts')
</body>
</html>