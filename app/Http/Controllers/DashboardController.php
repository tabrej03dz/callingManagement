<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->get();
//        dd(Carbon::now()->addMinutes(50));
        return view('dashboard.dashboard', compact('recentCalls'));
    }
}
