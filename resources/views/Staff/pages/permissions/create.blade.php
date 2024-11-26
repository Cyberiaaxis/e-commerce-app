@extends('Staff.layouts.staff')

@section('title', 'Create permission')
@section('content')
<div class="col-md-12">
    <h3>Create Permission</h3>
    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="permission_name">Permission Name</label>
            <input type="text" id="permission_name" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Create Permission</button>
    </form>
</div>
@endsection