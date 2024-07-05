<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Number;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->get();
        $numbers = Number::all();
//        dd(Carbon::now()->addMinutes(50));

        return view('dashboard.dashboard', compact('recentCalls', 'numbers'));
    }
}
