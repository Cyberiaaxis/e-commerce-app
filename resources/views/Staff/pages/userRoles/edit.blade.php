@extends('Staff.layouts.staff')

@section('title', 'Reassign roles')

@section('content')
<div class="container">
    <h1>Edit Roles for {{ $user->name }}</h1>

    <form action="{{ route('admin.assignRole.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="roles" class="form-label">Assign Roles</label>
            <select name="roles[]" id="roles" class="form-select" multiple>
                @foreach ($roles as $role)
                <option value="{{ $role->name }}"
                    {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Roles</button>
        <a href="{{ route('admin.assignRole.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection