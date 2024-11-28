<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Get orders with pagination
        $orders = Order::paginate(10); // Adjust as needed

        return view('order-management', compact('orders'));
    }

    public function updateStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->status == 'Pending') {
            $order->status = 'Shipped';
        } elseif ($order->status == 'Shipped') {
            $order->status = 'Delivered';
        }

        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order status updated!');
    }

    public function refundCancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->status != 'Cancelled') {
            $order->status = 'Cancelled';
            // Process the refund logic if needed
        }

        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order refunded and cancelled!');
    }
}
