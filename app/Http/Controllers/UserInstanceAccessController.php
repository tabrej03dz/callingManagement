<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInstanceAccess;
use Illuminate\Http\Request;

class UserInstanceAccessController extends Controller
{
    public function setInstanceAndAccess(Request $request, User $user){
        $request->validate([
            'instance_id' => 'required',
            'access_token' => 'required',
        ]);
        $record = UserInstanceAccess::where('user_id', $user->id)->first();
        if ($record){
            $record->update($request->all() + ['user_id' => $user->id]);
        }else{
            UserInstanceAccess::create($request->all() + ['user_id' => $user->id]);
        }

//        session(['instance_id' => $request->instance_id, 'access_token' => $request->access_token]);
        return back()->with('success', 'Instance id and Access token set successfully');
    }

    public function clearInstanceAndAccess(User $user){
//        session()->forget(['instance_id', 'access_token']);
        $record = UserInstanceAccess::where('user_id', $user->id)->first();
        $record->delete();
        return back()->with('success', 'Instance id and Access token cleared successfully');
    }
}
