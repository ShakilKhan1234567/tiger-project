<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryApiController extends Controller
{
    function get_category(){
        $categories = Category::all();
        return response()->json($categories);
    }

    function category_store(Request $request){
        $validator = Validator::make($request->all(),[
            'category_name' => 'required|unique:categories',
            'icon' => 'required',
            'icon' => 'Image',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }

        $icon = $request->icon;
        $extension = $icon->extension();
        $file_name = str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
        Image::make($icon)->save(public_path('uploads/category/' . $file_name));

        $category = Category::create([
            'category_name' => $request->category_name,
            'icon' => $file_name,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
           'category'=>$category,
           'icon'=>$file_name,
           'mesage'=>"Successfuly Inserted",
        ]);
    }

    function category_show($id){
        $category = Category::find($id);
        if(!$category){
            return response(['exist'=>'category does not exist']);
        }
        return response()->json([
            'category'=>$category,
            'mesage'=>"Successfuly Showed",
         ]);
    }

    function category_update(Request $request, $id){

        if($request->icon == ''){
          Category::find($id)->update([
             'category_name'=>$request->category_name,
          ]);

          return response()->json([
            'update'=>"Successfuly Updated",
         ]);
        }

        else{
            $validator = Validator::make($request->all(),[
                'icon' => 'required',
                'icon' => 'Image',
            ]);

            if($validator->fails()){
                return $validator->errors()->all();
            }

           $category = Category::find($id);
           $delete_from = public_path('uploads/category/'.$category->icon);
           unlink($delete_from);

           $icon = $request->icon;
           $extension = $icon->extension();
           $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
           Image::make($icon)->save(public_path('uploads/category/' . $file_name));

           $cat_update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'icon' => $file_name,
            'created_at' => Carbon::now(),
            ]);

           return response()->json([
              'category'=>$cat_update,
              'mesage'=>"Successfuly Updated",
           ]);

        }
    }

    function category_delete($id){
        Category::find($id)->delete();

        return response()->json([
            'mesage'=>"Successfuly Deleted",
         ]);
    }

    function category_permanent_delete($id){

        Category::onlyTrashed()->find($id)->forceDelete();

        return response()->json([
            'mesage'=>"Permanetly Deleted",
         ]);
    }
}
