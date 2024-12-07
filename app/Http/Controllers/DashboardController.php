<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the sales data for the past 6 months using Eloquent
        $salesData = Order::where('status', 'completed') // Only completed orders
            ->where('order_date', '>=', Carbon::now()->subMonths(6)) // Last 6 months
            ->selectRaw('MONTH(order_date) as month, SUM(final_amount) as total_sales')
            ->groupBy('month') // Group by month
            ->orderBy('month', 'asc') // Order by month ascending
            ->get();

        // Get total number of completed orders
        $totalOrders = Order::where('status', 'completed')->count();

        // Get total sales for today (completed orders)
        $dailySales = Order::where('status', 'completed')
            ->whereDate('order_date', Carbon::today()) // Filter by today's date
            ->sum('final_amount'); // Sum of the final_amount field

        // Assume a static stock level for simplicity
        // Get category-wise stock sum

        $stockLevels = Category::withCount("products")->get();

        // dd($stockLevels);
        // Pass data to the view
        return view('Staff.pages.dashboard.index', compact('salesData', 'totalOrders', 'dailySales', 'stockLevels'));
    }
}
