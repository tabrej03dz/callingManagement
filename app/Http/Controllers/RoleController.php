<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('dashboard.role.index', compact('roles'));
    }

    public function create(){
        return view('dashboard.role.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        Role::create(['name' => $request->name]);
        return redirect('role')->with('success', 'Role Created Successfully');
    }

    public function delete(Role $role){
        $role->delete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function rolePermission(Role $role){
        $permissions = $role->getAllPermissions();
        return view('dashboard.role.permissions', compact('permissions', 'role'));
    }

    public function permissionRemove(Permission $permission, Role $role){
        $role->revokePermissionTo($permission);
        return back()->with('success', 'Removed successfully');
    }
}
