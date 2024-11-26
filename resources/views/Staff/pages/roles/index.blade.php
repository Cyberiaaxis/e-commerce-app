@extends('Staff.layouts.staff')

@section('title', 'Roles Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Roles Management</h4>
                </div>
                <div class="card-body">

                    <!-- Display Success and Error Messages -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Button to Create New Role -->
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-success mb-3">
                        <i class="fas fa-plus-circle"></i> Create Role
                    </a>

                    <!-- Roles Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <!-- Display Permissions Vertically -->
                                        @if($role->permissions->count() > 0)
                                        @foreach($role->permissions as $permission)
                                        <p class="badge bg-info mb-1">{{ $permission->name }}</p>
                                        @endforeach
                                        @else
                                        <p class="badge bg-secondary">No Permissions</p>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Edit Role Button -->
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning btn-sm rounded-pill shadow-sm" title="Edit Role">
                                            <i class="fas fa-pencil-alt fs-5"></i>
                                        </a>

                                        <!-- Delete Role Button -->
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}" title="Delete Role">
                                            <i class="fas fa-trash fs-5"></i>
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $role->id }}">Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this role? This action cannot be undone.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancel">
                                                            <i class="fas fa-times"></i>
                                                        </button>

                                                        <!-- Delete Form -->
                                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection