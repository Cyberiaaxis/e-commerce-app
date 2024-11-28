@extends('Staff.layouts.staff')

@section('title', 'Order Management')

@section('content')
<div class="container mt-4">
    <h1>Order Management</h1>
    <p>View and manage customer orders. Track order status and process refunds or cancellations.</p>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <span class="badge 
                                @if($order->status == 'Pending') badge-warning 
                                @elseif($order->status == 'Shipped') badge-primary 
                                @elseif($order->status == 'Delivered') badge-success 
                                @elseif($order->status == 'Cancelled') badge-danger 
                                @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>
                        <!-- Update Status Button -->
                        @if($order->status == 'Pending')
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary btn-sm">Mark as Shipped</button>
                        </form>
                        @elseif($order->status == 'Shipped')
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Mark as Delivered</button>
                        </form>
                        @endif

                        <!-- Process Refund / Cancel -->
                        <form action="{{ route('orders.refundCancel', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            @if($order->status != 'Cancelled')
                            <button type="submit" class="btn btn-danger btn-sm">Refund / Cancel</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination (optional) -->
    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection