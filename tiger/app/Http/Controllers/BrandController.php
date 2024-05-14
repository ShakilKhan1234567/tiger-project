<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    function brand_store(){
        $brands = Brand::all();
        return view('admin.brand.brand',[
            'brands'=>$brands,
        ]);
    }
    function brand(Request $request){
     $request->validate([
        'brand_name'=>'required',
        'brand_logo'=>'required',
     ]);

     $logo = $request->brand_logo;
     $extension = $logo->extension();
     $file_name = str::lower(str_replace(' ', '-',$request->brand_name)).'.'.$extension;
     Image::make($logo)->save(public_path('uploads/brand/'.$file_name));

     Brand::insert([
       'brand_name'=>$request->brand_name,
       'brand_logo'=>$file_name,
       'created_at'=>Carbon::now(),
     ]);

     return back()->with('success', 'Successfully Added!');
    }
    function brand_delete($id){
        Brand::find($id)->delete();
        return back()->with('success', 'Successfully Deleted!');
    }
}
