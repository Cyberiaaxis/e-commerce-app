@extends('Staff.layouts.staff')

@section('title', 'Order Management')

@section('content')
<div class="container">
    <h1>Order Management</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Create New Order</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Order Number</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Customer</th>
                <th>Shipping Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->status }}</td>
                <td>${{ $order->total_amount }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->shipping_status }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection