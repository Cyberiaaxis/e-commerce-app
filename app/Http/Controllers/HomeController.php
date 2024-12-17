<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        // Fetch active sliders, featured products, and recent customers for optimized performance
        $sliders = Slider::orderBy('order', 'asc') // Assuming an 'order' column for sorting sliders
            ->get();

        $products = Product::where('is_active', 1)->limit(8) // Limit to 8 featured products for homepage
            ->get();

        $customers = Customer::limit(10) // Fetch the 10 most recent customers
            ->get();

        $chefs = Chef::limit(3) // Limit to 8 featured products for homepage
            ->get();

        $topOrderedProducts =  Product::select('products.*', DB::raw('COUNT(order_items.id) as total_orders'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id') // Adjust 'product_id' to your schema
            ->groupBy('products.id')
            ->orderBy('total_orders', 'desc')
            ->limit(3)
            ->get();

        // Pass data to the view with descriptive variable names
        return view('Customer.layouts.index', [
            'sliders' => $sliders,
            'products' => $products,
            'customers' => $customers,
            'topOrderedProducts' => $topOrderedProducts,
            'chefs' => $chefs
        ]);
    }
}
