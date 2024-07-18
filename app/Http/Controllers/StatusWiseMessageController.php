<?php

namespace App\Http\Controllers;

use App\Models\StatusWiseMessage;
use Illuminate\Http\Request;

class StatusWiseMessageController extends Controller
{
    public function index(){
        $messages = StatusWiseMessage::all();
        return view('dashboard.message.index', compact('messages'));
    }

    public function create(){
        return view('dashboard.message.create');
    }

    public function store(Request $request){
        $request->validate([
            'status' => 'required',
            'message' => 'required',
        ]);
        $record = StatusWiseMessage::where('status', $request->status)->first();
        if ($record){
            $record->update($request->all());
            $message = 'Updated successfully';
        }else{
            StatusWiseMessage::create($request->all());
            $message = 'Created successfully';
        }
        return redirect('message')->with('success', $message);
    }

    public function edit(StatusWiseMessage $message){
        return view('dashboard.message.edit', compact('message'));
    }

    public function delete(StatusWiseMessage $message){
        $message->delete();
        return back()->with('success','deleted successfully');
    }
}
