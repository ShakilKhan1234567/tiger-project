<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function sub_category(){
        $categories = Category::all();
        return view('admin.subcategory.subcategory', compact('categories'),);
    }
    function subcategory_store(Request $request){
       $request->validate(([
        'select_category'=>'required',
        'subcategory_name'=>'required',
       ]));

       if(Subcategory::where('category_id', $request->select_category)->where('subcategory_name', $request->subcategory_name)->exists()){
        return back()->with('exist', 'Subcategory name already exist in this category!');
       }
       else{
        Subcategory::insert([
            'category_id'=>$request->select_category,
            'subcategory_name'=>$request->subcategory_name,
            'created_at'=>Carbon::now(),
           ]);
           return back()->with('sub_cat', 'Successfully Added!');
       }
    }
    function edit_subcategory($id){
        $categories = Category::all();
        $subcategories = Subcategory::find($id);
        return view('admin.subcategory.edit',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }
    function update_subcategory(Request $request, $id){
        $request->validate(([
            'select_category'=>'required',
            'subcategory_name'=>'required',
           ]));
           Subcategory::find($id)->update([
            'category_id'=>$request->select_category,
            'subcategory_name'=>$request->subcategory_name,
            'created_at'=>Carbon::now(),
           ]);
           return back()->with('sub_update', 'Successfully Updated!');
    }
    function delete_subcategory($id){
        Subcategory::find($id)->delete();
        return back()->with('success', 'Successfully Deleted!');
    }

}
