<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(){
        $statuses = Status::all();
        return view('dashboard.status.index', compact('statuses'));
    }

    public function delete(Status $status){
        $status->delete();
        return back()->with('success', 'Deleted successfully');
    }

    public function create(){
        return view('dashboard.status.create');
    }

    public function store(Request $request){
        $request->validate(['name' => 'required']);
        Status::create($request->all());
        return redirect('status')->with('success', 'created successfully');
    }
}
