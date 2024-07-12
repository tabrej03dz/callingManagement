<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use App\Models\Image;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(){
        $demoes = Demo::all();
        return view('dashboard.demo.index', compact('demoes'));
    }

    public function create(){
        return view('dashboard.demo.create');
    }

    public function edit(Demo $demo){
        return view('dashboard.demo.edit', compact('demo'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'image_title' => '',
            'images.*' => 'mimes:jpg,jpeg,png',
        ]);

        $demo = Demo::create(['name' => $request->name, 'city' => $request->city]);

        foreach ($request->file('images') as $media){
            $file = $media->store('public/images');
            $image = new Image();
            $image->title = $request->image_title;
            $image->demo_id = $demo->id;
            $image->model_type = 'App\Models\Demo';
            $image->path = str_replace('public/', '', $file);
            $image->save();
        }

        return redirect('demo')->with('success', 'Demo created successfully');
    }

    public function update(Request $request, Demo $demo){
        $request->validate([
            'name' => 'required',
            'city' => 'required',
        ]);
        $demo->update($request->all());
        return redirect('demo')->with('success', 'Updated successfully');
    }


    public function demoImages(Demo $demo){
        return view('dashboard.demo.images', compact('demo'));
    }

    public function imageDelete(Image $image){
        $file = public_path('storage/'. $image->path);
        if(file_exists($file)){
            unlink($file);
        }
        $image->delete();
        return back()->with('success', 'Image Deleted successfully');
    }

    public function addImage(Demo $demo){
        return view('dashboard.demo.addImage', compact('demo'));
    }

    public function storeImage(Request $request, Demo $demo){
        $request->validate([
            'title' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

//        Image::create(['title' => $request->title, 'demo_id' => $demo->id]);
        $image = new Image();
        $image->title = $request->title;
        $image->demo_id = $demo->id;
        $file = $request->file('image')->store('public/images');
        $image->path = str_replace('public/', '', $file);
        $image->save();
        return redirect('demo/images/'.$demo->id)->with('success', 'Image Added successfully');
    }

}
