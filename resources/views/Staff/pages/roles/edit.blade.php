@extends('Staff.layouts.staff')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Edit Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Role Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                        </div>

                        <!-- Permissions Section -->
                        <div class="mb-3">
                            <h5>Modify Permissions:</h5>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->id }}"
                                            @if (in_array($permission->id, $rolePermissions)) checked @endif>
                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Update and Cancel Buttons with Icons -->
                        <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Role">
                            <i class="fas fa-save"></i>
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel">
                            <i class="fas fa-times"></i>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Initialize Tooltips -->
@section('scripts')
<script>
    // Enable tooltips on page load
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endsection

@endsection