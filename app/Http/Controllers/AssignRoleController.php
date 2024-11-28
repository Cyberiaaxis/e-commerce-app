<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AssignRoleController extends Controller
{
    /**
     * Display a listing of the users with their roles.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('Staff.pages.userRoles.index', compact('users'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $users = User::all();
        $roles = Role::all();
        return view('Staff.pages.userRoles.create', compact(['users', 'roles'])); // Create a form to add new roles
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'required|array', // Ensure roles is an array
            'roles.*' => 'exists:roles,name', // Ensure each role exists in the roles table
        ]);
        // Fetch the user by user_id
        $user = User::findOrFail($request->user_id);
        $user->syncRoles($request->roles);
        return redirect()->route('admin.assignRole.index')->with('success', 'Roles assigned successfully.');
    }

    /**
     * Show the form for editing roles for a specific user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Get all roles
        return view('Staff.pages.userRoles.edit', compact('user', 'roles'));
    }

    /**
     * Update the roles of a specific user.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'roles' => 'array|exists:roles,name', // Validate role names
        ]);

        $user = User::findOrFail($id);
        // Assign roles to the user
        $user->syncRoles($request->roles);

        return redirect()->route('admin.assignRole.index')->with('success', 'Roles updated successfully!');
    }

    /**
     * Remove a user and detach their roles.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Remove all roles from the user
        $user->syncRoles([]);
        $user->delete();

        return redirect()->route('admin.assignRole.index')->with('success', 'User deleted successfully!');
    }

    // /**
    //  * Assign a role to a user.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function userAssignRole(Request $request,)
    // {
    //     // dd($request);
    //     // Validate the request
    // }
}
