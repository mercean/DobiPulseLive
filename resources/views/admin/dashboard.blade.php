@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6" 
x-data="{ activeTab: 'normal', normalCollapsed: true, bulkCollapsed: true, userCollapsed: true }">
<!-- Welcome Section -->
<div class="flex items-center justify-center gap-4 mb-10">
    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff&size=80' }}" class="w-16 h-16 rounded-full border-4 border-blue-500 shadow-md">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2">Here's your admin control panel overview.</p>
    </div>
</div>


<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    <div class="rounded-xl bg-blue-50 dark:bg-gray-800 p-6 shadow flex items-center gap-4">
        <x-heroicon-o-users class="w-10 h-10 text-blue-500 dark:text-blue-400" />
        <div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Total Users</div>
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalUsers }}</div>
        </div>
    </div>

    <div class="rounded-xl bg-green-50 dark:bg-gray-800 p-6 shadow flex items-center gap-4">
        <x-heroicon-o-archive-box class="w-10 h-10 text-green-500 dark:text-green-400" />
        <div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Bulk Orders</div>
            <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalBulkOrders }}</div>
        </div>
    </div>

    <div class="rounded-xl bg-purple-50 dark:bg-gray-800 p-6 shadow flex items-center gap-4">
        <x-heroicon-o-document-text class="w-10 h-10 text-purple-500 dark:text-purple-400" />
        <div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Normal Orders</div>
            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalOrders }}</div>
        </div>
    </div>
</div>

<!-- Fix dark mode text inside input and select fields -->
<style>
    input,
    select,
    textarea {
        color: black;
    }

    .dark input,
    .dark select,
    .dark textarea {
        background-color: #374151 !important;
        color: white !important;
        border-color: #4b5563 !important;
    }

    .dark input::placeholder,
    .dark textarea::placeholder {
        color: #9CA3AF !important;
    }
</style>




    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">📈 Machines Usage</h2>
            <canvas id="lineChart" height="200"></canvas>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">📊 Order Types</h2>
            <canvas id="horizontalBarChart" height="200"></canvas>
        </div>
    </div>

<!-- Order Analysis -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-10">
    <div class="flex items-center gap-2 mb-4">
        <x-heroicon-o-chart-pie class="w-6 h-6 text-blue-600 dark:text-blue-400" />
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Order Analysis</h2>
    </div>

    <ul class="pl-5 mb-4 space-y-1 text-gray-700 dark:text-gray-300 list-disc">
        @foreach ($statusDistribution as $status)
            <li><strong>{{ ucfirst($status->status) }}</strong>: {{ $status->count }} orders</li>
        @endforeach
    </ul>

    <div class="flex flex-col sm:flex-row gap-4 text-sm text-gray-700 dark:text-gray-300">
        <div class="flex items-center gap-2">
            <x-heroicon-o-check-badge class="w-5 h-5 text-green-500" />
            Completion Rate: <strong>{{ round($orderCompletionRate, 2) }}%</strong>
        </div>
        <div class="flex items-center gap-2">
            <x-heroicon-o-clock class="w-5 h-5 text-yellow-500" />
            Avg Completion Time: <strong>{{ round($avgTimeToCompleteOrders, 2) }} mins</strong>
        </div>
    </div>
</div>


<!-- Tabs -->
<div class="flex space-x-3 mb-6">
    <button @click="activeTab = 'normal'" :class="activeTab === 'normal' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white'" class="px-4 py-2 rounded">
        <x-heroicon-o-document-text class="inline w-5 h-5 mr-1" /> Normal Orders
    </button>
    <button @click="activeTab = 'bulk'" :class="activeTab === 'bulk' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white'" class="px-4 py-2 rounded">
        <x-heroicon-o-archive-box class="inline w-5 h-5 mr-1" /> Bulk Orders
    </button>
    <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white'" class="px-4 py-2 rounded">
        <x-heroicon-o-users class="inline w-5 h-5 mr-1" /> User Management
    </button>
        <button @click="activeTab = 'promotions'" :class="activeTab === 'promotions' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white'" class="px-4 py-2 rounded">
        <x-heroicon-o-megaphone class="inline w-5 h-5 mr-1" /> Promotions
    </button>
</div>



<!-- Normal Orders Table -->
<div x-show="activeTab === 'normal'" x-cloak class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-10">
    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Normal Orders Table</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    @foreach ($orders as $order)
                    <tr>
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name ?? 'Unknown User' }}</td>
                        <td class="px-4 py-2">RM{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Orders Table -->
    <div x-show="activeTab === 'bulk'" x-cloak class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white">📦 Bulk Orders</h2>
            <button @click="bulkCollapsed = !bulkCollapsed">
                <x-heroicon-o-chevron-down x-show="bulkCollapsed" class="w-6 h-6" />
                <x-heroicon-o-chevron-up x-show="!bulkCollapsed" class="w-6 h-6" />
            </button>
        </div>
        <div x-show="!bulkCollapsed" x-cloak>
            <form action="{{ route('admin.bulkOrders') }}" method="GET" class="mb-4">
                <select name="status" class="rounded px-3 py-2 border bg-white dark:bg-gray-700 text-sm">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="finished">Finished</option>
                </select>
                <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </form>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">Order ID</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Action</th>
                            <th class="px-4 py-2">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700">
                        @foreach ($bulkOrders as $bulkOrder)
                        <tr>
                            <td class="px-4 py-2">{{ $bulkOrder->id }}</td>
                    <td class="px-4 py-2">{{ $bulkOrder->user->name ?? 'Unknown User' }}</td>
                            <td class="px-4 py-2">{{ $bulkOrder->status }}</td>
                            <td class="px-4 py-2">
                                @if ($bulkOrder->status === 'approved' && $bulkOrder->price <= 0)
                                    <form action="{{ route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder']) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="number" step="0.01" name="price" class="rounded px-2 py-1 text-sm" required>
                                        <button class="ml-2 bg-indigo-600 text-white px-2 py-1 rounded">Update</button>
                                    </form>
                                @elseif($bulkOrder->price > 0)
                                    RM{{ number_format($bulkOrder->price, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder']) }}" method="POST">
                                    @csrf @method('PUT')
                                    <select name="status" class="rounded px-2 py-1">
                                        @foreach(['pending','approved','PayNow','paid','processing','waiting pickup','finished'] as $status)
                                            <option value="{{ $status }}" {{ $bulkOrder->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                            
                                        @endforeach
                                    </select>
                                    <button class="ml-2 bg-blue-600 text-white px-2 py-1 rounded">Update</button>
                                </form>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.viewBulkOrderDetails', $bulkOrder->id) }}" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Promotions Tab Section -->
    <div x-show="activeTab === 'promotions'" x-cloak class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">🎉 Active Promotions</h2>
            <a href="{{ route('promotions.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Manage Promotions</a>
        </div>
        <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
            @forelse ($promotions->filter(fn($p) => now()->between($p->start_date, $p->end_date)) as $promo)
                <li><strong>{{ $promo->title }}</strong> - {{ $promo->type === 'percent' ? $promo->value . '%' : 'RM' . number_format($promo->value, 2) }} off until {{ $promo->end_date->format('d M Y') }}</li>
            @empty
                <li>No active promotions currently.</li>
            @endforelse
        </ul>
    </div>
    <!-- User Management -->
    <div x-show="activeTab === 'users'" x-cloak class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white">👤 User Management</h2>
            <button @click="userCollapsed = !userCollapsed">
                <x-heroicon-o-chevron-down x-show="userCollapsed" class="w-6 h-6" />
                <x-heroicon-o-chevron-up x-show="!userCollapsed" class="w-6 h-6" />
            </button>
        </div>
        <div x-show="!userCollapsed" x-cloak>
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">User ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ ucfirst($user->account_type) }}</td>
                        <td class="px-4 py-2">
                            @if ($user->account_type !== 'admin')
                                <form action="{{ route('admin.createForm') }}" method="GET">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded">Make Admin</button>
                                </form>
                            @else
                                <span class="text-gray-500">Admin</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.createForm') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">Create New Admin</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels) !!},
            datasets: [{
                label: 'Machines Used per Day',
                data: {!! json_encode($dailyCounts) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('horizontalBarChart'), {
        type: 'bar',
        data: {
            labels: ['Bulk Orders', 'Normal Orders'],
            datasets: [{
                label: 'Orders',
                data: [{{ $totalBulkOrders }}, {{ $totalOrders }}],
                backgroundColor: ['#10B981', '#8B5CF6']
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true } }
        }
    });
</script>
@endpush
