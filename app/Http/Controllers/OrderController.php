<?php

namespace App\Http\Controllers;

use App\Models\{Order, Discount, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Calculate delivery date based on pincode.
     * 
     * @param string $pincode
     * @return \Carbon\Carbon
     */
    protected function calculateDeliveryDate($pincode)
    {
        // Define a basic mapping of pincode to delivery days
        $deliveryDays = [
            '110001' => 3,  // Example: Delhi, delivery in 3 days
            '400001' => 5,  // Example: Mumbai, delivery in 5 days
            '600001' => 4,  // Example: Chennai, delivery in 4 days
            // Add more pin codes as required
        ];

        // Set a default delivery time if the pincode is not mapped
        $daysToAdd = $deliveryDays[$pincode] ?? 7; // Default 7 days

        return Carbon::now()->addDays($daysToAdd); // Returns the delivery date
    }

    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        $orders = Order::all();
        return view('Staff.pages.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $products = Product::all();
        return view('Staff.pages.order.create', compact("products"));
    }

    /**
     * Store a newly created order in storage.
     */

    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
            'discount_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
            'final_amount' => 'required|numeric',
            'payment_type' => 'required|in:cod,online',
            'payment_status' => 'required|in:pending,paid,refunded,failed',
            'delivery_status' => 'required|in:pending,shipped,delivered,returned,canceled',
            'tracking_number' => 'nullable|string',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'pincode' => 'required|string', // Validate pincode
        ]);

        // Calculate delivery date based on pincode
        $validated['delivery_date'] = $this->calculateDeliveryDate($validated['pincode']);

        // Generate unique order number
        $validated['order_number'] = 'SO-' . strtoupper(substr(md5(Str::uuid()), 0, 10));

        // If discount code is provided, validate and calculate discount
        if ($validated['discount_code']) {
            $discount = Discount::where('code', $validated['discount_code'])->first();
            if ($discount) {
                $validated['discount_amount'] = $discount->value;
            } else {
                return back()->withErrors(['discount_code' => 'Invalid discount code.']);
            }
        }

        // Calculate final amount after discount
        $validated['final_amount'] = $validated['total_amount'] - ($validated['discount_amount'] ?? 0);

        // Generate unique tracking number
        $trackingNumber = Str::random(10);
        while (Order::where('tracking_number', $trackingNumber)->exists()) {
            $trackingNumber = Str::random(10); // Ensure uniqueness
        }

        $validated['tracking_number'] = $trackingNumber;

        // Create the order with validated data
        Order::create($validated);

        // Redirect back to the order list with a success message
        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }


    /**
     * Show the form for editing an order.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('Staff.pages.order.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,canceled',
            'delivery_status' => 'required|in:pending,shipped,delivered,returned,canceled',
            'payment_status' => 'required|in:pending,paid,refunded,failed',
            'total_amount' => 'required|numeric',
            'discount_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
            'final_amount' => 'required|numeric',
            'tracking_number' => 'nullable|string',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'pincode' => 'required|string', // Validate pincode
        ]);

        // Calculate delivery date based on pincode
        $validated['delivery_date'] = $this->calculateDeliveryDate($validated['pincode']);

        // If discount code is provided, validate and calculate discount
        if ($validated['discount_code']) {
            $discount = Discount::where('code', $validated['discount_code'])->first();
            if ($discount) {
                $validated['discount_amount'] = $discount->value;
            } else {
                return back()->withErrors(['discount_code' => 'Invalid discount code.']);
            }
        }

        // Calculate final amount after discount
        $validated['final_amount'] = $validated['total_amount'] - ($validated['discount_amount'] ?? 0);

        // Find the order and update it
        $order = Order::findOrFail($id);
        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
    public function getProductDiscount($productId)
    {
        $product = Product::with('discounts')->findOrFail($productId);
        $discounts = $product->discounts; // Assuming `discounts` is the relationship with the discount model
        return response()->json($discounts);
    }

    /**
     * Display order statistics (Optional for analytics).
     */
    public function stats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'canceled_orders' => Order::where('status', 'canceled')->count(),
            'delivered_orders' => Order::where('delivery_status', 'delivered')->count(),
        ];

        return view('Staff.pages.order.stats', compact('stats'));
    }
}
