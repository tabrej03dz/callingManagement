<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Number;
use Illuminate\Support\Facades\Http;


class CallRecordController extends Controller
{
    public function show(Number $number){
        $records = $number->callRecords;
        return view('dashboard.callRecord.show', compact('records'));
    }

    public function create(Number $number){
        return view('dashboard.callRecord.form', compact('number'));
    }

    public function store(Request $request, Number $number){
        $request->validate([
            'number_status' => '',
            'status' => '',
            'description' => '',
            'have_to_call' => '',
        ]);
        if ($request->number_status){
            $number->status = $request->number_status;
            $number->save();
        }
        CallRecord::create($request->all() + ['number_id' => $number->id, 'user_id' => auth()->user()->id]);
        return redirect('number/assigned')->with('success', 'record created successfully');
    }

    public function markAsRecalled($record){
        $callRecord = CallRecord::find($record);
        $callRecord->update(['recalled' => 'true']);
        return back()->with('success', 'Mark As Recalled');
    }
}
