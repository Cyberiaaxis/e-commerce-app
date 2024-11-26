@extends('Staff.layouts.staff')

@section('title', 'Create Role')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">Create Role</h3>
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <!-- Role Name -->
            <div class="form-group">
                <label for="name" class="font-weight-bold">Role Name:</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter role name" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Permissions -->
            <div class="form-group mt-4">
                <h5 class="font-weight-bold">Assign Permissions:</h5>
                <div class="permissions-list">
                    @foreach ($permissions as $permission)
                    <div class="form-check custom-checkbox">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}">
                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                            <i class="fa fa-check-circle"></i> {{ $permission->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-4 py-2">Create Role</button>
            </div>
        </form>
    </div>
</div>
@endsection