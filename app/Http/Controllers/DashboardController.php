<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\DemoRecord;
use App\Models\Number;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __construct(){
        $dateThreeMonthsAgo = Carbon::now()->subMonths(3);

        $records = Number::where('status', 'not interested')->where('updated_at', '<=', $dateThreeMonthsAgo)->get();
        foreach ($records as $record){
            $record->update(['assigned' => '0']);
        }
    }

    public function dashboard(Request $request){

//        $notAssignedNumbers = Number::where('assigned', '0')->get();
//        foreach ($notAssignedNumbers as $number){
//            $number->delete();
//        }

        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $numbers = Number::whereBetween('updated_at', [$from, $to])->get();
            $callRecords = CallRecord::whereBetween('created_at', [$from, $to])->get();
        }else{
            $numbers = Number::whereDate('updated_at', Carbon::today())->get();
            $callRecords = CallRecord::whereDate('created_at', Carbon::today())->get();
            $from = null;
            $to = null;
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
        return view('dashboard.dashboard', compact('recentCalls', 'allNumbers', 'from', 'to', 'numbers', 'callRecords', 'demoRecords'));
    }

    public function addCustomer(Number $number){

        // Make an API call
        $response = Http::withOptions([
            'verify' => false,
        ])->post('http://realvictorygroups.xyz/api/addCustomer', [
            'name' => $number->name,
            'email' => $number->phone_number.'@gmail.com',
            'phone' => $number->phone_number,

            // Additional data if needed
        ]);
        return redirect()->back()->with('success', 'Customer added successfully');
    }
}
