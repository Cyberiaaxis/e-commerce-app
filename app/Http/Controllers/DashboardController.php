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

        $salesData = Order::where('status', 'completed') // Only completed orders
            ->where('order_date', '>=', Carbon::now()->subMonths(6)) // Last 6 months
            ->selectRaw('MONTH(order_date) as month, SUM(final_amount) as total_sales')
            ->groupBy('month') // Group by month
            ->orderBy('month', 'asc') // Order by month ascending
            ->get(); // Keep it as a Collection



        $totalOrders = Order::where('status', 'completed')->count();


        $dailySales = Order::where('status', 'completed')
            ->whereDate('order_date', Carbon::today()) // Filter by today's date
            ->sum('final_amount'); // Sum of the final_amount field


        $stockLevels = Category::with(
            'products:id,name,description,price,image,is_active,qty,category_id'
        )->withCount('products')->get();


        return view('Staff.pages.dashboard.index', compact('salesData', 'totalOrders', 'dailySales', 'stockLevels'));
    }
}
