<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Size;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    function variation(){
        $categories = Category::all();
        $variations = Variation::all();
        return view('admin.variation.variation', [
            'categories'=>$categories,
            'variations'=>$variations,
        ]);
    }
    function variation_store(Request $request){
        $request->validate([
            'color_name'=>'required',
        ]);

       Variation::insert([
        'color_name'=>$request->color_name,
        'color_code'=>$request->color_code,
        'created_at'=>Carbon::now(),
       ]);
       return back();
    }
    function size(Request $request){
        $request->validate([
            'size'=>'required',
        ]);

       Size::insert([
        'category_id'=>$request->category_id,
        'size'=>$request->size,
        'created_at'=>Carbon::now(),
       ]);
       return back();
    }
    function delete_variation($id){
        Variation::find($id)->delete();

        return back()->with('delete', 'Successfully Deleted!');
    }
    function delete_size($id){
        Size::find($id)->delete();

        return back()->with('delete_size', 'Successfully Deleted!');
    }

}
