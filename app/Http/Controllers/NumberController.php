<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Models\User;
use App\Models\UserNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Imports\NumberImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Schema\ValidationException;
use Spatie\Permission\Models\Role;

class NumberController extends Controller
{
    public function index(Request $request){

        $query = Number::query();
//        dd($query);

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $numbers = $query->where('assigned' , '0')->paginate(100);
        $role = Role::where('name', 'calling team')->first();
        $users = $role->users;
        return view('dashboard.number.all', compact('numbers', 'users'));
    }

    public function notAssigned(){

//        $user = User::create(['name' => 'calling', 'email' => 'calling@gamil.com', 'password' => Hash::make('password')]);
//        $role = Role::create(['name' => 'caller']);
//        $user->assignRole('caller');


//        $role = Role::where('name', 'caller')->first();


        $role = Role::where('name', 'calling team')->first();

        $users = $role->users;
        $numbers = Number::where('assigned', '0')->get();

        return view('dashboard.number.index', compact('numbers', 'users'));
    }

    public function numberUploadForm(){
        return view('dashboard.number.uploadForm');
    }

    public function numberUpload(Request $request){
//        dd($request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
//        dd($file);
        $excel = app()->make('excel');

        try {
            $result = $excel->import(new NumberImport, $file);
            if ($request){
                return redirect('number')->with('success', 'Numbers Imported successfully');
            }else{
                return redirect('number')->with('error', 'Failed to upload numbers! , try again');
            }
        }catch (ValidationException $e){
            $failures = $e->failures();
            return redirect('number')->with('success', 'Validation failed, Please check your Excel file and try again');
        }
    }

    public function assignedNumbers(){
        if (auth()->user()->hasRole('calling team')){
            $userNumebrs = auth()->user()->userNumbers->pluck('number_id');
            $numbers = Number::whereIn('id', $userNumebrs)->get();
        }else{
            $numbers = Number::where('assigned', '1')->get();
        }
        return view('dashboard.number.assigned', compact('numbers'));
    }

    public function status(Number $number, $status){
        $number->status = $status;
        $number->save();
        return back()->with('success', 'status changed successfully');
    }

    public function statusWise($status = null){
        if ($status == null){
            if (auth()->user()->hasRole('calling team')){
                $numberIds = auth()->user()->userNumbers()->pluck('number_id');
                $numbers = Number::whereIn('id', $numberIds)->get();
            }else{
                $numbers = Number::all();
            }
        }else{
            if (auth()->user()->hasRole('calling team')){
                $numberIds = auth()->user()->userNumbers()->pluck('number_id');
                $numbers = Number::whereIn('id', $numberIds)->where('status', $status)->get();
            }else{
                $numbers = Number::where('status', $status)->get();
            }
        }
        return view('dashboard.number.statusWise', compact('numbers', 'status'));
    }

    public function addForm(){
        return view('dashboard.number.addForm');
    }

    public function saveNumber(Request $request){
        $request->validate([
            'business_name' => 'required',
            'phone_number' => 'required',
            'city' => 'required',
        ]);
        if (Number::where('phone_number', $request->phone_number)->exists()){
            return back()->with('error', 'This'.$request->phone_number.'already exists');
        }
        $number = Number::create($request->all() + ['added_by' => auth()->user()->id]);

        if(auth()->user()->hasRole('calling team')){
            UserNumber::create(['user_id' => auth()->user()->id, 'number_id' => $number->id, 'assigned_at' => Carbon::now(), 'assigned_by' => auth()->user()->id]);
        }

        return back()->with('success', 'Number Added Successfully');
    }

}
