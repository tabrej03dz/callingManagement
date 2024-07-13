<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNumber;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function userReport(Request $request, User $user){
//        dd($user->usernumbers);
        if ($request->date){
            $date = $request->date;
        }else{
            $date = null;
        }

        $userNumbers = $user->userNumbers;

        return view('dashboard.report.userReport', compact('user', 'userNumbers', 'date'));
    }
}
