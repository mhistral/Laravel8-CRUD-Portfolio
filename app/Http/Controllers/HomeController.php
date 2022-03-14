<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Image;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function homeSlider(){
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index',compact('sliders'));
    }

    public function addSlider(){
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.create',compact('sliders'));
    }

    public function storeSlider(Request $request){
         // Image Intervention
         $slider_image = $request->file('image');
         $name_gen = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
         $last_img = 'image/slider/'.$name_gen;
         Image::make($slider_image)->resize(1920,1088)->save($last_img);

         Slider::insert([
             'title' => $request->title,
             'description' => $request->description,
             'image' => $last_img,
             'created_at' => Carbon::now()
         ]);


         return redirect()->route('home.slider')->with('success', 'Slider Inserted Succesfully!');
    }
}
