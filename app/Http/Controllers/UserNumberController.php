<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Models\UserNumber;
use Illuminate\Http\Request;

class UserNumberController extends Controller
{
    public function assign(Request $request){
        $request->validate([
            'user_id' => 'required',
            'numbers' => 'required|array',
            'numbers.*' => 'required|integer',
        ]);

//        dd($request->all());
        foreach ($request->numbers as $key => $val){
            $number = Number::find($val);
            $number->update(['assigned' => '1']);
            $userNumber = new UserNumber();
            $userNumber->user_id = $request->user_id;
            $userNumber->number_id = $number->id;
            $userNumber->save();
        }

        return back()->with('success', 'Numbers assigned to user successfully');

    }
}
