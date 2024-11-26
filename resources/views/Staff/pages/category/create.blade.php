@extends('Staff.layouts.staff')

@section('title', 'Create Category') <!-- Page Title -->

@section('content')
<div class="container">
    <h1 class="mb-4">Create New Category</h1>

    <!-- Display validation errors if there are any -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Category creation form -->
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf <!-- CSRF token for security -->

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="category_name" value="{{ old('name') }}" required>
            <small class="form-text text-muted">Enter the name of the category.</small>
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </form>
</div>
@endsection