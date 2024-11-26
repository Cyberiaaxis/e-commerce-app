<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
        // You can apply middleware here if needed
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all roles
        $roles = Role::all();
        return view('Staff.pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch all permissions to assign to the new role
        $permissions = Permission::all();
        return view('Staff.pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array', // Ensure permissions are an array
        ]);

        // Create the new role
        $role = Role::create(['name' => $request->name]);

        // Attach permissions to the role
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // Fetch all permissions and the current permissions attached to the role
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('Staff.pages.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array|nullable',  // Ensure permissions is an array if provided
            'permissions.*' => 'exists:permissions,id',  // Ensure all permission IDs exist in the permissions table
        ]);

        // Update the role
        $role->update(['name' => $request->name]);

        // Sync the permissions to the role
        if ($request->has('permissions')) {
            // Ensure that the provided permissions are valid
            $validPermissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();

            // Sync valid permissions only
            $role->syncPermissions($validPermissions);
        } else {
            // Remove all permissions if none are selected
            $role->syncPermissions();
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }


    /**
     * Remove the specified role from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // Delete the role
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    /**
     * Assign a role to a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function assignRole(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'role' => 'required|exists:roles,name', // Ensure the role exists
        ]);

        // Assign the role to the user
        $role = $request->input('role');
        $user->assignRole($role);

        return redirect()->route('admin.roles.index')->with('success', 'Role assigned successfully.');
    }

    /**
     * Attach a permission to a role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function attachPermission(Request $request, Role $role)
    {
        // Validate the request
        $request->validate([
            'permission' => 'required|exists:permissions,name', // Ensure the permission exists
        ]);

        // Attach the permission to the role
        $permission = $request->input('permission');
        $role->givePermissionTo($permission);

        return redirect()->route('admin.roles.index')->with('success', 'Permission attached successfully.');
    }

    public function assignPermission(Request $request, Role $role)
    {
        // Validate that a permission is selected
        $request->validate([
            'permission' => 'required|string|exists:permissions,name',
        ]);

        // Assign the permission to the role
        $role->givePermissionTo($request->input('permission'));

        return redirect()->route('admin.roles.index')->with('success', 'Permission assigned successfully.');
    }
}
