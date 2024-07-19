<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Demo;
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

    public function assignedNumbers(Request $request){
        if ($request->number){
            $numbers = Number::where('phone_number', $request->number);
        }else{

            if (auth()->user()->hasRole('calling team')){
                $userNumebrs = auth()->user()->userNumbers->pluck('number_id');
                if ($request->keyword){
                    $numberIds = CallRecord::where('description', 'like', '%'.$request->keyword.'%')->where('user_id', auth()->user()->id)->pluck('number_id');
                    $numbers = Number::whereIn('id', $numberIds);
                }else{
                    $numbers = Number::whereIn('id', $userNumebrs);
                }
            }else{
                if ($request->keyword){
                    $numberIds = CallRecord::where('description', 'like', '%'.$request->keyword.'%')->pluck('number_id');
                    $numbers = Number::whereIn('id', $numberIds);
                }else{
                    $numbers = Number::where('assigned', '1');
                }
            }
        }
        if($request->status){
            $numbers = $numbers->where('status', $request->status);
        }
        if ($request->city){
            $numbers = $numbers->where('city', $request->city);
        }
        $numbers = $numbers->get();
        $demos = Demo::all();
        return view('dashboard.number.assigned', compact('numbers', 'demos'));
    }

    public function status(Number $number, $status){
        $number->status = $status;
        $number->save();
        return back()->with('success', 'status changed successfully');
    }

    public function statusWise(Request $request, $status = null){
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

            $numbers = Number::where('status', $status)->get();
//            dd($numbers);
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
            $number->update(['assigned' => '1']);
        }
        if ($request->user_id){
            UserNumber::create(['user_id' => $request->user_id, 'number_id' => $number->id, 'assigned_at' => Carbon::now(), 'assigned_by' => auth()->user()->id]);
            $number->update(['assigned' => '1']);
        }
        return back()->with('success', 'Number Added Successfully');
    }

    public function callBack(){
        if(auth()->user()->hasRole('calling team')){
            $recentCalls = CallRecord::whereDate('have_to_call', Carbon::today())->where('recalled', null)->where('user_id', auth()->user()->id)->get();
        }else{
            //            $recentCalls = CallRecord::whereBetween('have_to_call', [Carbon::now(), Carbon::now()->addMinutes(50)])->where('recalled', null)->get();
            $recentCalls = CallRecord::whereDate('have_to_call', Carbon::today())->where('recalled', null)->get();
        }
        return view('dashboard.number.callBack', compact('recentCalls'));
    }

    public function allNumberDelete(){
        $numbers = Number::all();
        foreach ($numbers as $number){
            $number->delete();
        }
        return back()->with('success', 'All Numbers deleted successfully');
    }

    public function unassignedNumberDelete(){
        $numbers = Number::where('assigned', '0')->get();
        foreach ($numbers as $number){
            $number->delete();
        }
        return back()->with('success', 'All Numbers deleted successfully');
    }


}
