@extends('Staff.layouts.staff')

@section('title', 'Categories')

@section('content')
<div class="container">
    <!-- Heading Section -->
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-primary"></i> Categories</h4>

        <!-- Create Category Button -->
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Create New Category
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Categories Table -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->category_name }}</td>
                <td class="text-center">
                    <!-- View Button -->
                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="View Category">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Edit Button -->
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Category">
                        <i class="fas fa-edit"></i>
                    </a>

                    <!-- Delete Form -->
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')" data-toggle="tooltip" data-placement="top" title="Delete Category">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection