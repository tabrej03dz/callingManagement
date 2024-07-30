<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use App\Models\DemoRecord;
use App\Models\Image;
use App\Models\Number;
use App\Models\User;
use App\Models\UserInstanceAccess;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(){
        if (auth()->user()->hasRole('super_admin|admin')){
            $demoes = Demo::all();
        }else{
            $adminIds = User::role(['super_admin', 'admin'])->pluck('id');
            $demoes = Demo::whereIn('created_by', $adminIds)->orWhere('created_by', auth()->user()->id)->get();
        }
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

        $demo = Demo::create(['name' => $request->name, 'city' => $request->city, 'created_by' => auth()->user()->id, 'description' => $request->description]);

        if ($request->file('images')){
            foreach ($request->file('images') as $media){
                $file = $media->store('public/images');
                $image = new Image();
                $image->title = $request->image_title;
                $image->demo_id = $demo->id;
                $image->model_type = 'App\Models\Demo';
                $image->path = str_replace('public/', '', $file);
                $image->save();
            }
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

    public function demoSend(Request $request, Number $number) {
        $request->validate([
            'demo_id' => 'required_without:custom_message',
            'custom_message' => 'required_without:demo_id',
        ]);

        $phoneNumber = $number->phone_number;
        $userInstanceAccess = UserInstanceAccess::where('user_id', auth()->user()->id)->first();

        if ($userInstanceAccess) {
            try {
                if ($request->custom_message) {
                    $client = new Client(['verify' => false]);
                    $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91' . $phoneNumber . '&type=text&message=' . $request->custom_message . '&instance_id=' . $userInstanceAccess->instance_id . '&access_token=' . $userInstanceAccess->access_token);
                }
                if ($request->demo_id) {
                    $demo = Demo::find($request->demo_id);
                    $message = $demo->description ?? '';
                    $images = Image::where('demo_id', $demo->id)->get();
                    foreach ($images as $image) {
//                        $imageUrl = asset('storage/' . $image->path);
                        $imageUrl = 'https://realvictorygroups.xyz/assets/logo.png';
                        $fileName = $image->title;
                        $client = new Client(['verify' => false]);
                        $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91' . $phoneNumber . '&type=media&message=' . $message . '&media_url=' . $imageUrl . '&filename=' . $fileName . '&instance_id=' . $userInstanceAccess->instance_id . '&access_token=' . $userInstanceAccess->access_token);
                    }
                }
                DemoRecord::create([
                    'number_id' => $number->id,
                    'user_id' => auth()->user()->id,
                    'demo_id' => $request->demo_id ?? null,
                    'custom_message' => $request->custom_message ?? '',
                ]);
                return response()->json(['success' => 'Demo sent successfully']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while sending the demo: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Instance ID and Access token are not set'], 400);
        }
    }

}

