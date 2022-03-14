<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MultiPicture;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
class BrandController extends Controller
{

    /**
     * Only Authenticated users can use this Page/Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * as category_name is a field name
         * unique:categories, categories as table name
         * */
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',
        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_image.min' => 'Brand longer than 4 Characters',
        ]
    );

        // image name generator
        // $brand_image = $request->file('brand_image');
        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $name_gen.'.'.$img_ext;

        // //upload image
        // $up_location = 'image/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location,$img_name);

        // Image Intervention
        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        $last_img = 'image/brand/'.$name_gen;
        Image::make($brand_image)->resize(300,200)->save($last_img);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);


        return redirect()->back()->with('success', 'Category Inserted Succesfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = Brand::find($id);

        return view('admin.brand.edit',compact('brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**
         * as category_name is a field name
         * unique:categories, categories as table name
         * */
        $validated = $request->validate([
                'brand_name' => 'required|min:4',
            ],
            [
                'brand_name.required' => 'Please Input Brand Name',
                'brand_image.min' => 'Brand longer than 4 Characters',
            ]
        );

        // for replacing the image
        $old_image = $request->old_image;

        // image name generator
        $brand_image = $request->file('brand_image');
        if($brand_image){
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;

            //upload image
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);

            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()
            ]);

        }else{
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now()
            ]);
        }

        return redirect()->back()->with('success', 'Category Inserted Succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        Brand::find($id)->delete();
        return redirect()->back()->with('success', 'Category Deleted Succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }

    /**
     * Multi Image Methods
     */
    public function multiPic()
    {
        $images = MultiPicture::all();
        return view('admin.multipic.index', compact('images'));
    }

    /**
     * Multi Image Methods
     */
    public function storeImages(Request $request)
    {
        /**
         * as category_name is a field name
         * unique:categories, categories as table name
         * */
        // $validated = $request->validate([
        //         'image' => 'required|mimes:jpg,jpeg,png',
        //     ],
        //     [
        //         'image.min' => 'Brand longer than 4 Characters',
        //     ]
        // );


        // Image Intervention
        $image = $request->file('image');

        foreach ($image as $multi_image) {
            $name_gen = hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension();
            $last_img = 'image/multi/'.$name_gen;
            Image::make($multi_image)->resize(300,300)->save($last_img);

            MultiPicture::insert([
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
        }


        return redirect()->back()->with('success', 'Category Inserted Succesfully!');
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('login')->with('success','User Logout');
    }
}
