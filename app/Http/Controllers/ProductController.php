<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display a listing of products
    public function index()
    {
        $products = Product::with('category')->get();
        return view('Staff.pages.product.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = Category::all();
        return view('Staff.pages.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // Validate the form input
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Handle file upload (if there is an image)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
        }
        // dd($request->is_active);
        // Save the product with image name (example)
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imageName ?? null;
        $product->category_id = $request->category_id;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('lastInsertedProduct', $product->id)
            ->with('success', 'Product created successfully!');
    }


    // Display the specified product
    public function edit($id)
    {
        // Fetch the product by its ID
        $product = Product::findOrFail($id);

        // Fetch all categories for the category dropdown
        $categories = Category::all();

        // Return the edit view with the product and categories data
        return view('Staff.pages.product.edit', compact('product', 'categories'));
    }


    public function update(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'int'
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update product details
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->is_active = $request->has('is_active');

        // Handle the image upload (if new image is provided)
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image) {
                Storage::delete('public/images/' . $product->image);
            }

            // Store the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $product->image = $imageName;
        }

        // Save the product to the database
        $product->save();

        // Redirect back to the products index with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }


    public function destroy($id)
    {
        // dd($id);
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Redirect back to the product index with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
