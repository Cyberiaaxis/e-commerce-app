<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // Display a listing of the permissions
    public function index()
    {
        $permissions = Permission::all();
        return view('Staff.pages.permissions.index', compact('permissions'));
    }

    // Show the form for creating a new permission
    public function create()
    {
        return view('Staff.pages.permissions.create');
    }

    // Store a newly created permission in storage
    public function store(Request $request)
    {
        $this->validatePermission($request);

        // Create the new permission
        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully!');
    }

    // Show the form for editing the specified permission
    public function edit(Permission $permission)
    {
        return view('Staff.pages.permissions.edit', compact('permission'));
    }

    // Update the specified permission in storage
    public function update(Request $request, Permission $permission)
    {
        $this->validatePermission($request, $permission);

        // Update the permission
        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully!');
    }

    // Remove the specified permission from storage
    public function destroy(Permission $permission)
    {
        // Optional: Check if the permission is in use by any roles before deleting
        // You may want to check if the permission is assigned to any role and prevent deletion if so

        // Delete the permission
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully!');
    }

    // Private method to validate permission input
    private function validatePermission(Request $request, Permission $permission = null)
    {
        $uniqueRule = $permission ? 'unique:permissions,name,' . $permission->id : 'unique:permissions,name';

        $request->validate([
            'name' => 'required|string|max:255|' . $uniqueRule,
        ]);
    }
}
