<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(){
        $demoes = Demo::all();
        return view('dashboard.demo.index', compact('demoes'));
    }
}
