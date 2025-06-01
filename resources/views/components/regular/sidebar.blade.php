<aside :class="showSidebar ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r dark:border-gray-700 transform transition-transform duration-300 flex flex-col">

    <!-- Header: Avatar + Name + Settings Icon -->
    <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
        <div class="flex items-center space-x-3">
            @php $user = Auth::user(); @endphp
            <img src="{{ $user && $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Guest') . '&background=0D8ABC&color=fff&size=80' }}" 
                 class="w-12 h-12 rounded-full border-2 border-blue-500 shadow-sm">
            <div>
                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                    {{ $user->name ?? 'Guest' }}
                </p>
                <div class="flex items-center gap-1">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $user ? 'Regular User' : 'Visitor' }}
                    </p>
                    @if ($user)
                    <a href="{{ route('edit.profile') }}" title="Edit Profile" class="text-gray-400 hover:text-blue-500">
                        <x-heroicon-o-cog class="w-4 h-4" />
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Minimize Icon -->
        <button @click="showSidebar = false" class="text-gray-500 dark:text-gray-300 hover:text-blue-500" title="Minimize">
            <x-heroicon-o-minus class="w-5 h-5" />
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-sm font-medium">
        <a href="/dashboard" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600">
            <x-heroicon-o-home class="w-5 h-5" /> Dashboard
        </a>

        @if ($user)
        <a href="{{ route('regular.orders') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600">
            <x-heroicon-o-clipboard-document-list class="w-5 h-5" /> My Orders
        </a>

        <a href="/loyalty" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600">
            <x-heroicon-o-star class="w-5 h-5" /> Loyalty Points
        </a>

        <a href="/redeem_catalog" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600">
            <x-heroicon-o-gift class="w-5 h-5" /> Loyalty Catalog
        </a>

        <a href="{{ route('edit.profile') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600">
            <x-heroicon-o-pencil-square class="w-5 h-5" /> Edit Profile
        </a>
        @endif
    </nav>
</aside>
