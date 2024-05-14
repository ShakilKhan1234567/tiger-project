<?php

namespace App\Http\Controllers;

use App\Models\Baner;
use Intervention\Image\Facades\Image;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    function banner(){
        $categories = Category::all();
        $banners = Baner::all();
        return view('admin.banner.banner', [
            'categories'=>$categories,
            'banners'=>$banners,
        ]);
    }
    function banner_store(Request $request){
        $request->validate([
            'title'=>'required',
            'photo'=>'required',
        ]);

        $photo = $request->photo;
        $extension = $photo->extension();
        $file_name = 'banner'.'-'.random_int(50000, 60000).'.'.$extension;
        Image::make($photo)->save(public_path('uploads/banner/'.$file_name));

        Baner::insert([
            'title'=>$request->title,
            'photo'=>$file_name,
            'category_id'=>$request->category_id,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('banner_success', 'Successfully Added!');
    }

    function banner_delete($id){
        $bnr_id = Baner::find($id);

        $old_image = public_path('uploads/banner/'.$bnr_id->photo);
        unlink($old_image);

        Baner::find($id)->delete();
        return back()->with('banner_success', 'Successfully Deleted!');
    }

    function banner_edit($id){
        $banners = Baner::find($id);
        return view('admin.banner.banner_edit', [
            'banners'=>$banners,
        ]);
    }
    function update_banner(Request $request, $id){

        if($request->photo == ''){
            Baner::find($id)->update([
                'title'=>$request->title,
            ]);
            return back();
        }
        else{
            $banner_id = Baner::find($id);

            $old_image = public_path('uploads/banner/'.$banner_id->photo);
            unlink($old_image);

            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = 'banner'.'-'.random_int(50000, 60000).'.'.$extension;
            Image::make($photo)->save(public_path('uploads/banner/'.$file_name));

            Baner::find($id)->update([
                'title'=>$request->title,
                'photo'=>$file_name,
            ]);
            return back()->with('update', 'Successfully Updated!');
        }
    }
}
