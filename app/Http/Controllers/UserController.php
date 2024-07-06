<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        $users = User::all()->skip(1);
        return view('dashboard.user.index', compact('users'));
    }

    public function create(){
        $roles = Role::all();
        return view('dashboard.user.create', compact('roles'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role_name' => 'required',
        ]);
        $user = User::create($request->all() + ['password' => Hash::make('password')]);
        $user->assignRole($request->role_name);
        return redirect('user')->with('success', 'created successfully');
    }

    public  function edit(User $user){
        $roles = Role::all();
        return view('dashboard.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role_name' => '',
            'password' => 'min:8',
            'confirm_password' => 'same:password',
        ]);

        $user->update($request->all());
        if ($request->role_name){
            $user->assignRole($request->role_name);
        }
        if ($request->password){
            $user->update(['password' => Hash::make($request->password)]);
        }
        return redirect('user')->with('success', 'Updated successfully');
    }

    public function delete(User $user){
        $user->delete();
        return back()->with('success', 'Deleted successfully');
    }

    public function userAssignedNumbers(User $user){
        return view('dashboard.user.assignedNumbers', compact('user'));
    }

    public function userPermission(User $user){
        $permissions = $user->permissions;
        return view('dashboard.user.permissions', compact('permissions', 'user'));
    }

    public function permissionRemove(Permission $permission, User $user){
        $user->revokePermissionTo($permission);
        return back()->with('success', 'Removed successfully');
    }
}
