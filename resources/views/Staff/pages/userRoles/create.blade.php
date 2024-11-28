@extends('Staff.layouts.staff')

@section('title', 'Assign Role to User')

@section('content')
<div class="container py-4">
    <h1>Assign Roles to User</h1>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.assignRole.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="user_id">Select User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="" disabled selected>Select a user</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="roles">Select Roles</label>
            <select name="roles[]" id="roles" class="form-select" multiple required>
                @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold down Ctrl (Windows) or Command (Mac) to select multiple roles.</small>
        </div>

        <button type="submit" class="btn btn-primary">Assign Roles</button>
    </form>
</div>
@endsection