<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Retrieve all categories from the database
        $categories = Category::all();
        // Return the view and pass the categories
        return view('Staff.pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        // Return the view to create a category
        return view('Staff.pages.category.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name', // Ensure the name is unique
        ]);

        // Create the category and save it to the database
        Category::create([
            'category_name' => $validated['category_name'],
        ]);

        // Redirect back to the index page with a success message
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    // public function show(Category $category)
    // {
    //     // Show the details of a specific category
    //     return view('Staff.pages.category.edit', compact('category'));
    // }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        // Find the category by ID, or return a 404 page if it doesn't exist
        $category = Category::find($id);

        // Return the view to edit the category
        return view('Staff.pages.category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the category
        $category = Category::findOrFail($id);
        // dd($request);
        // Validate the incoming request
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id . ',id',

        ]);

        // If validation passes, update the category
        $category->category_name = $request->category_name;
        $category->save();

        // Return back to categories index with success message
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }


    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
