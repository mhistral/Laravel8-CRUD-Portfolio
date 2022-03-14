<?php

namespace App\Http\Controllers;

use App\Models\HomeAbout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AboutController extends Controller
{
    public function homeAbout(){
        $homeAbout = HomeAbout::latest()->get();
        return view('admin.home.index', compact('homeAbout'));
    }

    public function addAbout(){
        return view('admin.home.create');
    }

    public function storeAbout(Request $request){
        HomeAbout::insert([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.about')->with('success','About Inserted Succesfully!');
    }

    public function editAbout($id){
        $homeAbout = HomeAbout::find($id);

        return view('admin.home.edit', compact('homeAbout'));
    }

    public function updateAbout(Request $request, $id){
    $update = HomeAbout::find($id)->update([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
        ]);

        return Redirect()->route('home.about')->with('success','About Inserted Succesfully!');
    }

    public function deleteAbout($id){
        $update = HomeAbout::find($id)->delete();

        return Redirect()->route('home.about')->with('success','About Deleted Succesfully!');
    }



}
