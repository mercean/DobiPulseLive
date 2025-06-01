@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Transaction History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price (RM)</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>RM{{ $order->total_amount }}</td>

                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
