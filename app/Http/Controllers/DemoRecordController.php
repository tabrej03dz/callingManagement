<?php

namespace App\Http\Controllers;

use App\Models\DemoRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DemoRecordController extends Controller
{
    public function index(Request $request){
        $demoRecords = DemoRecord::whereDate('created_at', $request->date ??  Carbon::today())->get();
        return view('dashboard.demo.records', compact('demoRecords'));
    }
}
