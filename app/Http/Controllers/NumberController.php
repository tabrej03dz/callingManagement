<?php

namespace App\Http\Controllers;

use App\Models\CallRecord;
use App\Models\Demo;
use App\Models\Number;
use App\Models\User;
use App\Models\UserNumber;
use Carbon\Carbon;
use Grpc\Call;
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

        if ($request->filled('from') && $request->to ) {

            $query->whereBetween('created_at', [$request->from, $request->to]);
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
        $numbers = Number::where('assigned', '0')->paginate(100);

        return view('dashboard.number.index', compact('numbers', 'users'));
    }

    public function numberUploadForm(){
        return view('dashboard.number.uploadForm');
    }

    public function numberUpload(Request $request){
//        dd($request->all());
        $request->validate([
            'file' => 'required|max:2048',
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
            $numberSearch = $request->number;
            $allNumbers = Number::where('phone_number', $request->number)->get();
            $status = null;
        }else{

            $numbers = Number::query();
            if($request->status){
                $status = $request->status;
                if ($status == 'not call'){
                    $numbers = $numbers->doesntHave('callRecords');
                }else{
                    $numbers = $numbers->where('status', $request->status);
                }
            }else{
//                $numbers = $numbers->whereIn('status', ['interested'])
//                    ->orWhereNull('status');
                $status = null;
            }


            if (!auth()->user()->hasRole('super_admin|admin')){
                $userNumbers = UserNumber::where('user_id', auth()->user()->id)->pluck('number_id');
//                dd( $userNumbers->pluck('number_id'));
                if ($request->keyword){
                    $numberIds = CallRecord::where('description', 'like', '%'.$request->keyword.'%')->where('user_id', auth()->user()->id)->pluck('number_id');
                    $numbers = $numbers->whereIn('id', $numberIds);

                }else{
                    $numbers = $numbers->whereIn('id', $userNumbers);
                }
            }else{

                if ($request->keyword){
                    $numberIds = CallRecord::where('description', 'like', '%'.$request->keyword.'%')->pluck('number_id');
                    $numbers = $numbers->whereIn('id', $numberIds);
                }else{
                    $numbers = $numbers->where('assigned', '1');
                }
            }

            if ($request->city){
                $numbers = $numbers->where('city', $request->city);
            }

//            $lastCall = $numbers->orderBy('updated_at', 'desc')->first();
            $allNumbers = $numbers->orderBy('updated_at', 'desc')->get();

//        $withoutCallRecordsNumbers = $numbers->doesntHave('callRecords')->get();

            $numberSearch = null;
        }
        if (auth()->user()->hasRole('super_admin|admin')){
            $demos = Demo::all();
        }else{
            $adminIds = User::role(['super_admin', 'admin'])->pluck('id');
            $demos = Demo::whereIn('created_by', $adminIds)->orWhere('created_by', auth()->user()->id)->get();
        }

        return view('dashboard.number.assigned', compact('allNumbers', 'demos', 'status', 'numberSearch'));
    }

    public function status(Number $number, $status){
        $number->status = $status;
        $number->save();
        return back()->with('success', 'status changed successfully');
    }

    public function statusWise(Request $request, $status = null){
        if (auth()->user()->hasRole(['super_admin', 'admin'])){
            $numbers = Number::query();
        }else{
            $numberIds = auth()->user()->userNumbers()->pluck('number_id');
            $numbers = Number::whereIn('id', $numberIds);
        }
        if ($status != 'all'){
            $numbers = $numbers->where('status', $status);
        }
        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $numbers = $numbers->whereBetween('updated_at', [$from, $to]);
        }else{
            $from = null;
            $to = null;
            $numbers = $numbers->whereDate('updated_at', today());
        }
        $numbers = $numbers->get();
        return view('dashboard.number.statusWise', compact('numbers', 'status', 'from', 'to'));
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

    public function callBack(Request $request) {
        $recentCalls = CallRecord::where('status', 'call back');

        if ($request->from && $request->to) {
            $recentCalls = $recentCalls->whereBetween('created_at', [$request->from, $request->to]);
        }

        if (auth()->user()->hasRole('calling team')) {
            $recentCalls = $recentCalls->where('user_id', auth()->user()->id);
        }

        $recentCalls = $recentCalls->get(); // Make sure to call get() here to execute the query

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

    public function deleteSelectedNumber(Request $request){
        $numbers = Number::whereIn('id', $request->numbers)->get();
        foreach ($numbers as $number){
            $number->delete();
        }
        return back()->with('success', 'Numbers Deleted successfully');
    }

    public function numberLastResponse(Request $request, $status = null){
        if (auth()->user()->hasRole(['super_admin', 'admin'])){
            $numbers = Number::query();
        }else{
            $numberIds = auth()->user()->userNumbers()->pluck('number_id');
            $numbers = Number::whereIn('id', $numberIds);
        }
        if ($status != 'all'){
            $numbers = $numbers->where('last_response', $status);
        }
        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $numbers = $numbers->whereBetween('updated_at', [$from, $to]);
        }else{
            $from = null;
            $to = null;
            $numbers = $numbers->whereDate('updated_at', today());
        }
        $numbers = $numbers->get();
        return view('dashboard.number.statusWise', compact('numbers', 'status', 'from', 'to'));
    }

}
