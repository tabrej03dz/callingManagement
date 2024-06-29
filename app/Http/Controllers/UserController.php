<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all()->skip(1);
        return view('dashboard.user.index', compact('users'));
    }
}
