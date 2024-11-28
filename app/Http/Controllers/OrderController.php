<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display a listing of all orders
    public function index()
    {
        $orders = Order::all();
        return view('Staff.pages.order.index', compact('orders'));
    }

    // Show the form for creating a new order
    public function create()
    {
        return view('Staff.pages.order.create');
    }

    // Store a newly created order in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|unique:orders',
            'status' => 'required|in:pending,completed,canceled',
            'total_amount' => 'required|numeric',
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'shipping_address' => 'required',
            'shipping_status' => 'required|in:pending,in_transit,delivered',
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    // Show the form for editing an order
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('Staff.pages.order.edit', compact('order'));
    }

    // Update the specified order in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,canceled',
            'shipping_status' => 'required|in:pending,in_transit,delivered',
            'total_amount' => 'required|numeric',
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'shipping_address' => 'required',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    // Remove the specified order from storage
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    // Display order statistics (Optional for analytics)
    public function stats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'canceled_orders' => Order::where('status', 'canceled')->count(),
            'delivered_orders' => Order::where('shipping_status', 'delivered')->count(),
        ];

        return view('Staff.pages.order.stats', compact('stats'));
    }
}
