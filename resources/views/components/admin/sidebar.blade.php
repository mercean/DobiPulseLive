<aside
    class="fixed top-0 left-0 h-full w-64 bg-[#0f172a] text-white shadow-xl transform transition-transform duration-300 z-50"
    :class="{
        'translate-x-0': showSidebar || sidebarHovered,
        '-translate-x-full': !showSidebar && !sidebarHovered
    }"
    @mouseenter="sidebarHovered = true"
    @mouseleave="sidebarHovered = false"
    x-cloak
>
    <!-- Sidebar Header -->
    <div class="flex justify-between items-center px-6 py-4 border-b border-white/20">
        <h2 class="text-lg font-bold tracking-wide">Admin Panel</h2>
        <button @click="showSidebar = false" class="md:hidden text-white hover:text-gray-300">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="p-6 space-y-3 text-sm font-medium">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-home class="w-5 h-5" /> Dashboard
        </a>

        <a href="{{ route('admin.bulkOrders') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <i data-lucide="box" class="w-5 h-5"></i> Bulk Orders
        </a>

        <a href="{{ route('admin.transactionHistory') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-credit-card class="w-5 h-5" /> Transactions
        </a>

        <a href="{{ route('promotions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <i data-lucide="sparkles" class="w-5 h-5"></i> Promotions
        </a>

        <a href="{{ route('admin.createForm') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-user-plus class="w-5 h-5" /> Create Admin
        </a>

        <a href="{{ route('notifications.all') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-bell class="w-5 h-5" /> Notifications
        </a>

        <a href="{{ route('qr.demo') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <i data-lucide="qr-code" class="w-5 h-5"></i> QR Management
        </a>


        <form action="{{ route('logout') }}" method="POST" class="block">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full text-left px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
                <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5" /> Logout
            </button>
        </form>
    </nav>
</aside>
