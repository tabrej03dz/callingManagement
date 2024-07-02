<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(){
//        Permission::create(['name' => 'assign numbers']);
        $roles = Role::all();
        $users = User::all();
        $permissions = Permission::all();
        return view('dashboard.permission.index', compact('roles', 'users', 'permissions'));
    }


    public function givePermissionToUserOrRole(Request $request){
        $request->validate([
            'user_id' => 'required_without:role_id',
            'role_id' => 'required_without:user_id',
            'permissions.*' => 'required',
        ]);

        if ($request->user_id){
            $user = User::find($request->user_id);
            $user->givePermissionTo($request->permissions);
        }
        if ($request->role_id){
            $role = Role::findById($request->role_id);
            $role->givePermissionTo($request->permissions);
        }
        return back()->with('success','Permissions given successfully');


    }


}
