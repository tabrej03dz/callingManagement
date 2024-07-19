<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\DemoRecord;
use App\Models\Number;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
//        $notAssignedNumbers = Number::where('assigned', '0')->get();
//        foreach ($notAssignedNumbers as $number){
//            $number->delete();
//        }
//        dd('not assigned numbers deleted successfully');

        if ($request->date){
            $date = $request->date;
            $numbers = Number::whereDate('updated_at', $date)->get();
            $callRecords = CallRecord::whereDate('created_at', $date)->get();
        }else{
            $numbers = Number::whereDate('updated_at', Carbon::today())->get();
            $callRecords = CallRecord::whereDate('created_at', Carbon::today())->get();
            $date = null;
        }

        if(auth()->user()->hasRole('calling team')){
//            $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->where('user_id', auth()->user()->id)->get();
            $recentCalls = CallRecord::whereDate('have_to_call', Carbon::today())->where('recalled', null)->where('user_id', auth()->user()->id)->get();
        }else{
//            $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->get();
            $recentCalls = CallRecord::whereDate('have_to_call', Carbon::today())->where('recalled', null)->get();
        }
        $allNumbers = Number::all();

        if (auth()->user()->hasRole('super_admin|admin')){
            $demoRecords = DemoRecord::whereDate('created_at', $request->date ?? Carbon::today())->count();
        }else{
            $demoRecords = DemoRecord::whereDate('created_at', $request->date ?? Carbon::today())->where('user_id', auth()->user()->id)->count();
        }
//        dd(Carbon::now()->addMinutes(50));
        return view('dashboard.dashboard', compact('recentCalls', 'allNumbers', 'date', 'numbers', 'callRecords', 'demoRecords'));
    }
}
