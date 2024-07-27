<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNumber;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function userReport(Request $request, User $user){
//        dd($user->usernumbers);
        $userNumbers = UserNumber::query();
        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $userNumbers = $userNumbers->whereBetween('created_at', [$from, $to]);
        }else{
            $from = null;
            $to = null;
        }

            $userNumbers = $userNumbers->where('user_id', $user->id);

        $userNumbers = $userNumbers->get();

        return view('dashboard.report.userReport', compact('user', 'userNumbers', 'from', 'to'));
    }
}
