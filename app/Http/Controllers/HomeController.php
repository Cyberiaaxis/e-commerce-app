<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        // $categories = Category::with(['products' => function ($query) {
        //     $query->where('is_active', 1); // Only active products
        // }])->get();

        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', 1) // Only active products
                ->whereHas('discounts', function ($discountQuery) {
                    $discountQuery->where('is_active', true) // Only active discounts
                        ->where(function ($dateQuery) {
                            $dateQuery->whereNull('start_date')
                                ->orWhere('start_date', '<=', now()); // Check if start date is passed or null
                        })
                        ->where(function ($dateQuery) {
                            $dateQuery->whereNull('end_date')
                                ->orWhere('end_date', '>=', now()); // Check if end date is not expired or null
                        });
                });
        }])->get();

        // dd($categories);
        // dd($categories);
        // Pass data to the view with descriptive variable names
        return view('Customer.layouts.index', [
            'sliders' => $sliders,
            'products' => $products,
            'customers' => $customers,
            'topOrderedProducts' => $topOrderedProducts,
            'chefs' => $chefs,
            'categories' => $categories
        ]);
    }
}
