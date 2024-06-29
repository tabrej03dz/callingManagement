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
}
