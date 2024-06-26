<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Number;

class CallRecordController extends Controller
{
    public function show(Number $number){
        $records = $number->callRecords;
        return view('dashboard.callRecord.show', compact('records'));
    }

    public function create(Number $number){
        $statuses = Status::all();
        return view('dashboard.callRecord.form', compact('number', 'statuses'));
    }

    public function store(Request $request, Number $number){
        $request->validate([
            'status_id' => 'required',
            'description' => '',

        ]);
        CallRecord::create($request->all() + ['number_id' => $number->id, 'user_id' => auth()->user()->id]);
        return back()->with('success', 'record created successfully');
    }
}
