<?php

// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{
    // Show all orders for a user
    public function index()
    {
        $orders = Auth::user()->orders;  // Get orders for the logged-in user
        return view('order.index', compact('orders'));
    }

    // Show order details
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // Create a new order (for simplicity, assume it's a manual process)
    public function create()
    {
        return view('orders.create');
    }

    // Store the new order in the database
    public function store(Request $request)
    {
        $request->validate([
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = new Order();
        $order->user_id = Auth::id(); // Associate with the logged-in user
        $order->total_price = $request->total_price;
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully');
    }

    // Update order status
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Order status updated');
    }
}
