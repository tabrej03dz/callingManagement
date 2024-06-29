<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Models\User;
use Illuminate\Http\Request;
use App\Imports\NumberImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Schema\ValidationException;
use Spatie\Permission\Models\Role;

class NumberController extends Controller
{
    public function index(){
        $numbers = Number::all();
        return view('dashboard.number.all', compact('numbers'));
    }

    public function notAssigned(){

//        $user = User::create(['name' => 'calling', 'email' => 'calling@gamil.com', 'password' => Hash::make('password')]);
//        $role = Role::create(['name' => 'caller']);
//        $user->assignRole('caller');


        $role = Role::where('name', 'caller')->first();
        $users = $role->users;
        $numbers = Number::where('assigned', '0')->paginate(10);

        return view('dashboard.number.index', compact('numbers', 'users'));
    }

    public function numberUploadForm(){
        return view('dashboard.number.uploadForm');
    }

    public function numberUpload(Request $request){
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
        if (auth()->user()->hasRole('caller')){
            $userNumebrs = auth()->user()->userNumbers->pluck('number_id');
            $numbers = Number::whereIn('id', $userNumebrs)->get();
        }else{
            $numbers = Number::where('assigned', '1')->get();
        }
        return view('dashboard.number.assigned', compact('numbers'));
    }
}
