<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Number;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
//        $notAssignedNumbers = Number::where('assigned', '0')->get();
//        foreach ($notAssignedNumbers as $number){
//            $number->delete();
//        }
//        dd('not assigned numbers deleted successfully');



        if(auth()->user()->hasRole('calling team')){
            $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->where('user_id', auth()->user()->id)->get();
        }else{
//            $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->get();
            $recentCalls = CallRecord::whereDate('have_to_call', Carbon::today())->where('recalled', null)->get();
        }
        $numbers = Number::all();
//        dd(Carbon::now()->addMinutes(50));
        return view('dashboard.dashboard', compact('recentCalls', 'numbers'));
    }
}
