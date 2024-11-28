@extends('Staff.layouts.staff')

@section('title', 'Order create')

@section('content')
<div class="container">
    <h1>Create New Order</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="order_number">Order Number</label>
            <input type="text" name="order_number" id="order_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="canceled">Canceled</option>
            </select>
        </div>
        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="customer_email">Customer Email</label>
            <input type="email" name="customer_email" id="customer_email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="shipping_address">Shipping Address</label>
            <textarea name="shipping_address" id="shipping_address" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="shipping_status">Shipping Status</label>
            <select name="shipping_status" id="shipping_status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="in_transit">In Transit</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
</div>
@endsection