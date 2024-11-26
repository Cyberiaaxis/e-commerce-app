@extends('Staff.layouts.staff')

@section('title', 'Edit permission')
@section('content')
<div class="col-md-12">
    <h3>Edit Permission</h3>
    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="permission_name">Permission Name</label>
            <input type="text" id="permission_name" name="name" class="form-control" value="{{ $permission->name }}" required>
        </div>
        <button type="submit" class="btn btn-warning mt-3">Update Permission</button>
    </form>
</div>
@endsection