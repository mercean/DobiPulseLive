@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Bulk Order Details</h2>

        <!-- Display User Name on Top -->
        <h3 class="text-xl font-medium mb-4">User: {{ $bulkOrder->user->name }}</h3>

        <div class="admin-dashboard-card mb-6">
            <h3 class="mb-4">Order ID: {{ $bulkOrder->id }}</h3>

            <div class="mb-4">
                <strong>Load Arrival Date:</strong> {{ $bulkOrder->load_arrival_date }}
            </div>

            <div class="mb-4">
                <strong>Load Arrival Time:</strong> {{ $bulkOrder->load_arrival_time }}
            </div>

            <div class="mb-4">
                <strong>Pickup Date:</strong> {{ $bulkOrder->pickup_date }}
            </div>

            <div class="mb-4">
                <strong>Pickup Time:</strong> {{ $bulkOrder->pickup_time }}
            </div>

            <div class="mb-4">
                <strong>Cloth Type:</strong> {{ $bulkOrder->cloth_type }} <!-- Added Cloth Type -->
            </div>

            <div class="mb-4">
                <strong>Load (Kg):</strong> {{ $bulkOrder->load_kg }} <!-- Added Load in Kg -->
            </div>

            <div class="mb-4">
                <strong>Created At:</strong> {{ $bulkOrder->created_at }}
            </div>

            <div class="mb-4">
                <strong>Updated At:</strong> {{ $bulkOrder->updated_at }}
            </div>

            <!-- Optionally, you can add more details here -->
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
@endsection
