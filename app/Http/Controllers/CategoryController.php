<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    /**
     * Only Authenticated users can use this Page/Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allCat(){
        /**
         * Eloquent ORM
         */
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);

        /**
         * Query Builder
         */
        // $categories = DB::table('categories')->latest()->paginate(5);

        return view('Admin.category.index', compact('categories', 'trashCat'));
    }

    public function addCat(Request $request){ //Request to get the data submitted by the form

        /**
         * as category_name is a field name
         * unique:categories, categories as table name
         * */
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Should be Less than 255 Characters',
        ]);

        /**
         * Eloquent ORM
         */
        // Category::insert([
        //     'user_id' => Auth::user()->id,
        //     'category_name'=> $request->category_name,
        //     'created_at' => Carbon::now()
        // ]);

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        /**
         * Query Builder
         */
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return redirect()->back()->with('success', 'Category Inserted Succesfully!');
    }

    public function edit($id){
        /**
         * Eloquent ORM
         */
        $categories = Category::find($id);

        return view('Admin.category.edit', compact('categories'));
    }

    public function update(Request $request, $id){
        /**
         * Eloquent ORM
         */
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('all.category')->with('success', 'Category Updated Succesfully!');
    }

    public function softDelete($id){
          /**
         * Eloquent ORM
         */
        $delete = Category::find($id)->delete();

        return redirect()->back()->with('success', 'Category Soft Deleted Succesfully!');
    }

    public function restore($id){
        /**
       * Eloquent ORM
       */
        $delete = Category::withTrashed()->find($id)->restore();

        return redirect()->back()->with('success', 'Category Restored Succesfully!');
    }

    public function pDelete($id){
        /**
       * Eloquent ORM
       */
        $delete = Category::withTrashed()->find($id)->forceDelete();

        return redirect()->back()->with('success', 'Category Permanently Deleted!');
    }
}
