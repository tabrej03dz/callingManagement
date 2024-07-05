<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNumber;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function userReport(User $user){
//        dd($user->usernumbers);
        return view('dashboard.report.userReport', compact('user'));
    }
}
