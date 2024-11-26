@extends('Staff.layouts.staff')

@section('title', 'Edit Product')

@section('content')
<div class="container py-5"> <!-- Added padding and spacing -->

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8"> <!-- Full-width on small screens, 8/12 on large screens -->
            <div class="card shadow-lg border-light rounded-3"> <!-- Modern card with rounded corners and shadow -->
                <div class="card-header bg-primary text-white text-center rounded-top">
                    <h4 class="h4-responsive">{{ __('Edit Product') }}</h4> <!-- Responsive text size -->
                </div>
                <div class="card-body">
                    <!-- Display validation errors, if any -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Edit Product Form -->
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Method spoofing for PUT request -->

                        <div class="row">
                            <!-- First Column: Product Info -->
                            <div class="col-12 col-md-6 mb-4">
                                <label for="name" class="form-label h6">Product Name</label>
                                <input type="text" class="form-control form-control-lg rounded-3 shadow-sm" id="name" name="name" value="{{ old('name', $product->name) }}" required placeholder="Enter product name">
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <label for="category_id" class="form-label h6">Category</label>
                                <select class="form-select form-control-lg rounded-3 shadow-sm" id="category_id" name="category_id" required>
                                    <option value="" disabled>Select a category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-4">
                                <label for="description" class="form-label h6">Description</label>
                                <textarea class="form-control form-control-lg rounded-3 shadow-sm" id="description" name="description" rows="5" required placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Second Column: Pricing & Image -->
                            <div class="col-12 col-md-6 mb-4">
                                <label for="price" class="form-label h6">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control form-control-lg rounded-3 shadow-sm" id="price" name="price" value="{{ old('price', $product->price) }}" required placeholder="Enter product price">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <label for="image" class="form-label h6">Product Image</label>
                                <input type="file" class="form-control form-control-lg rounded-3 shadow-sm" id="image" name="image">

                                <!-- Display existing image (if available) -->
                                @if($product->image)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="Product Image" class="img-fluid rounded-3 shadow-sm" width="100%">
                                    <p class="mt-2 text-center">Current Image</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <!-- Checkbox and Submit -->
                            <div class="col-12 col-md-6 mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Product is Active</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-flex justify-content-md-end mb-4">
                                <button type="submit" class="btn btn-success btn-lg shadow-lg w-100 w-md-auto">Update Product</button> <!-- Full-width button on small screens -->
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection