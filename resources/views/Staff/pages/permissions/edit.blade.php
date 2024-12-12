@extends('Staff.layouts.staff')

@section('title', 'Edit Permission')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <!-- Card for editing permission -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-warning text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-key"></i> Edit Permission</h4>
                </div>
                <div class="card-body">
                    <!-- Back Button -->
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary mb-4">
                        <i class="fas fa-arrow-left"></i> Back to Permissions List
                    </a>

                    <!-- Permission Editing Form -->
                    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-4">
                            <label for="permission_name" class="fw-bold">Permission Name</label>
                            <input type="text" id="permission_name" name="name" class="form-control form-control-lg rounded-3" value="{{ old('name', $permission->name) }}" placeholder="Enter permission name" required>
                        </div>

                        <button type="submit" class="btn btn-warning btn-lg btn-block shadow-sm">
                            <i class="fas fa-save"></i> Update Permission
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Initialize Bootstrap tooltips (if you want to add tooltips in the future)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endsection

@endsection