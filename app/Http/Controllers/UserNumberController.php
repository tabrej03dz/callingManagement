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
            'numbers' => 'required_without:items|array',
            'numbers.*' => 'required_without:items|integer',
            'items' => 'required_without:numbers',
        ]);

        if($request->items){
            $numbers = Number::where('assigned', '0')->take($request->items)->get();
            foreach ($numbers as $number){
                UserNumber::create(['user_id' => $request->user_id, 'number_id' => $number->id]);
                $number->update(['assigned' => '1']);
            }
        }
        if ($request->numbers != null){
            foreach ($request->numbers as $key => $val){
                $number = Number::find($val);
                $number->update(['assigned' => '1']);
                $userNumber = new UserNumber();
                $userNumber->user_id = $request->user_id;
                $userNumber->number_id = $number->id;
                $userNumber->save();
            }
        }

        return back()->with('success', 'Numbers assigned to user successfully');

    }
}
