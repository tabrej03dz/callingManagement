<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use App\Models\DemoRecord;
use App\Models\Image;
use App\Models\Number;
use App\Models\UserInstanceAccess;
use GuzzleHttp\Client;
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

    public function demoSend(Request $request, Number $number){
        $request->validate([
            'demo_id' => 'required_without:custom_message',
            'custom_message' => 'required_without:demo_id',
        ]);

        $phoneNumber = $number->phone_number;
        $userInstanceAccess = UserInstanceAccess::where('user_id', auth()->user()->id)->first();

        if ($userInstanceAccess) {
            if ($request->custom_message){
                $client = new Client(['verify' => false]);
                $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91'.$phoneNumber.'&type=text&message='.$request->custom_message.'&instance_id='.$userInstanceAccess->instance_id.'&access_token='.$userInstanceAccess->access_token);
            }

            if ($request->demo_id){
                $demo = Demo::find($request->demo_id);
                $message = $demo->description ?? '';
                $images = Image::where('demo_id', $demo->id)->get();
                foreach ($images as $image){
                    $imageUrl = asset('storage/'. $image->path);
//                  $imageUrl = 'https://realvictorygroups.xyz/assets/logo.png';
//                  $message = $image->title;
                    $fileName = $image->title;
                    $client = new Client(['verify' => false]);
                    $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91'.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.$userInstanceAccess->instance_id.'&access_token='.$userInstanceAccess->access_token);
                }
            }
            DemoRecord::create(['number_id' =>$number->id, 'user_id' => auth()->user()->id, 'demo_id' => $request->demo_id ?? null, 'custom_message' => $request->custom_message ?? '']);

            return back()->with('success', 'Demo sent successfully');
        }else{
            return back()->with('error', 'Instance id and Access token is not set');
        }
    }
}

