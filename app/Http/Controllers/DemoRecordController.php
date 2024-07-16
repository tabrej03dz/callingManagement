<?php

namespace App\Http\Controllers;

use App\Models\DemoRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DemoRecordController extends Controller
{
    public function index(){
        $demoRecords = DemoRecord::whereDate('created_at', Carbon::today())->get();
        return view('dashboard.demo.records', compact('demoRecords'));
    }
}
