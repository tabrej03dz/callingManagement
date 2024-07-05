<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Models\UserNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserNumberController extends Controller
{
    public function assign(Request $request){
        $request->validate([
            'user_id' => 'required',
            'numbers' => 'required_without:from,to|array',
            'numbers.*' => 'required_without:from,to|integer',
            'from' => 'required_without:numbers',
            'to' => 'required_without:numbers',
        ]);
        $alreadyAssigned = [];
        if($request->from && $request->to){
            $numbers = Number::skip($request->from - 1)->take($request->to - ($request->from - 1))->get();
            foreach ($numbers as $number){
                if(UserNumber::where('number_id', $number->id)->exists()){
                    $userNumber = UserNumber::create(['user_id' => $request->user_id, 'number_id' => $number->id, 'assigned_at' => Carbon::now()]);
                    array_push($alreadyAssigned, $userNumber);
                }else{
                    UserNumber::create(['user_id' => $request->user_id, 'number_id' => $number->id, 'assigned_at' => Carbon::now()]);
                    $number->update(['assigned' => '1']);
                }
            }
        }
        if ($request->numbers != null){
            foreach ($request->numbers as $key => $val){
                $number = Number::find($val);
                if (UserNumber::where('number_id', $val)->exists()){
                    $number->update(['assigned' => '1']);
                    $userNumber = new UserNumber();
                    $userNumber->user_id = $request->user_id;
                    $userNumber->number_id = $number->id;
                    $userNumber->assigned_at = Carbon::now();
                    $userNumber->save();
                    array_push($alreadyAssigned, $userNumber);
                }else{
                    $number->update(['assigned' => '1']);
                    $userNumber = new UserNumber();
                    $userNumber->user_id = $request->user_id;
                    $userNumber->number_id = $number->id;
                    $userNumber->assigned_at = Carbon::now();
                    $userNumber->save();
                }
            }
        }
        return back()->with('success', 'Numbers assigned to user successfully')->with('alreadyAssigned', $alreadyAssigned);
    }

    public function unAssignTheNumber(Request $request){
        $userNumbers = UserNumber::whereIn('id', $request->alreadyAssignedNumbers)->get();
        foreach ($userNumbers as $userNumber) {
            $userNumber->delete();
        }
        return back()->with('success', 'Canceled successfully');
    }
}
