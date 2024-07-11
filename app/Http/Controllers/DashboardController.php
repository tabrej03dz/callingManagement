<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Number;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $notAssignedNumbers = Number::where('assigned', '0')->get();
        foreach ($notAssignedNumbers as $number){
            $number->delete();
        }
        dd('not assigned numbers deleted successfully');



        $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->get();
        $numbers = Number::all();
//        dd(Carbon::now()->addMinutes(50));
        return view('dashboard.dashboard', compact('recentCalls', 'numbers'));
    }
}
