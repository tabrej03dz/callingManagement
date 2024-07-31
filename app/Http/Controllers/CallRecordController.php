<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Demo;
use App\Models\DemoRecord;
use App\Models\Status;
use App\Models\StatusWiseMessage;
use App\Models\User;
use App\Models\UserInstanceAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Number;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;


class CallRecordController extends Controller
{
    public function show(Number $number){
        $records = $number->callRecords;
        return view('dashboard.callRecord.show', compact('records'));
    }

    public function create(Number $number){
        return view('dashboard.callRecord.form', compact('number'));
    }

    public function store(Request $request, Number $number)
    {
        $request->validate([
            'number_status' => Rule::requiredIf($request->status === 'call pick'),
            'status' => '',
            'description' => '',
            'date_and_time' => Rule::requiredIf($request->status === 'call back'),
            'send_message' => '',
            'converted_price' => Rule::requiredIf($request->status === 'converted'),
        ]);

        if ($request->number_status) {
            $number->update(['status' => $request->status == 'wrong number' ? $request->status : $request->number_status, 'updated_by' => auth()->user()->id, 'converted_price' => $request->converted_price ?? 0.0]);
        }

        $callRecord = CallRecord::create($request->all() + [
            'number_id' => $number->id,
            'user_id' => auth()->user()->id,
            'number_status' => $request->number_status,
            'have_to_call' => $request->date_and_time
        ]);

        if ($request->send_message == 'true'){
            $message = StatusWiseMessage::where('status', $request->number_status)->first()?->message;
            if ($message){
                $userInstanceAccess = UserInstanceAccess::where('user_id', auth()->user()->id)->first();
                $client = new Client(['verify' => false]);
                $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91'.$number->phone_number.'&type=text&message='.$message.'&instance_id='.$userInstanceAccess->instance_id.'&access_token='.$userInstanceAccess->access_token);
                DemoRecord::create(['user_id' => auth()->user()->id, 'number_id' => $number->id, 'custom_message' => $message]);
                $flash = 'Message sent successfully';
            }else{
                $flash = 'Message is not available for this status';
            }
        }else{
            $flash = '';
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Record created successfully' . ($flash ?? ''),
                'record' => $callRecord,
                'callBack' => $callRecord->have_to_call?->format('d-M h:i'),
                'created_at' => $callRecord->created_at->format('d-M h:i'),
            ]);
        } else {
            return redirect()->route('number.assigned', ['saved_number_id' => $number->id])->with('success', 'Record created successfully' . ($flash ?? ''));
        }
    }

//    public function store(Request $request, Number $number){
//        $request->validate([
//            'number_status' => '',
//            'status' => '',
//            'description' => '',
//            'date_and_time' => Rule::requiredIf($request->status === 'call back'),
//        ]);
//        if ($request->number_status){
//            $number->status = $request->number_status;
//            $number->save();
//        }
//        CallRecord::create($request->all() + ['number_id' => $number->id, 'user_id' => auth()->user()->id, 'number_status' => $request->number_status, 'have_to_call' => $request->date_and_time]);
//        return redirect('number/assigned')->with('success', 'record created successfully');
//    }


    public function markAsRecalled($record){
        $callRecord = CallRecord::find($record);
        $callRecord->update(['recalled' => 'true']);
        return back()->with('success', 'Mark As Recalled');
    }

    public function dayWise(Request $request){
        if($request->date){
            $callRecords = auth()->user()->hasRole('calling team') ? CallRecord::whereDate('created_at', $request->date)->where('user_id', auth()->user()->id)->get() : CallRecord::whereDate('created_at', $request->date)->get();
        }else{
            $callRecords = auth()->user()->hasRole('calling team') ? CallRecord::whereDate('created_at', Carbon::today())->where('user_id', auth()->user()->id)->get() : CallRecord::whereDate('created_at', Carbon::today())->get();
        }
        return view('dashboard.callRecord.dayWise', compact('callRecords'));
    }

    public function callRecordStatusWise(Request $request, $status = null) {
        $callRecords = CallRecord::query();
        $authUser = auth()->user();
        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $callRecords = $callRecords->whereBetween('created_at', [$from, $to]);
        }else{
            $from = null;
            $to = null;
            $callRecords = $callRecords->whereDate('created_at', today());
        }

        if ($status != 'all'){
            $callRecords = $callRecords->where('status', $status);
        }

        if (!auth()->user()->hasRole(['super_admin', 'admin'])){
            $callRecords = $callRecords->where('user_id', $authUser->id);
        }


        $callRecords = $callRecords->get();
//        dd($callRecords);

        return view('dashboard.callRecord.dayWise', compact('callRecords', 'status', 'from', 'to'));
    }

}
