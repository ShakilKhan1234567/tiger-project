<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Loginfo;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class CategoryController extends Controller
{
    function category()
    {
        $categories = Category::all();
        return view('admin.category.category', compact('categories'));
    }

    function category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'icon' => 'required',
            'icon' => 'Image',
        ]);

        $icon = $request->icon;
        $extension = $icon->extension();
        $file_name = str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
        Image::make($icon)->save(public_path('uploads/category/' . $file_name));

        Category::insert([
            'category_name' => $request->category_name,
            'icon' => $file_name,
            'created_at' => Carbon::now(),
        ]);

        Loginfo::insert([
            'user_id'=>Auth::id(),
            'model'=>'Category',
            'data'=>$request->category_name,
            'action'=>'inserted',
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('category_add', 'Successfully Added!');
    }
    function delete_category($category_id)
    {
        $category = Category::find($category_id);
        Category::find($category_id)->delete();
        Loginfo::insert([
            'user_id'=>Auth::id(),
            'model'=>'Category',
            'data'=>$category->category_name,
            'action'=>'Soft Deleted',
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('category_delete', 'Category move to trash!');
    }
    function trash_category()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.trash', compact('categories'));
    }
    function restore_category($restore)
    {
        $cat = Category::onlyTrashed()->find($restore);
        Category::onlyTrashed()->find($restore)->Restore();
        Loginfo::insert([
            'user_id'=>Auth::id(),
            'model'=>'Category',
            'data'=>$cat->category_name,
            'action'=>'Restore Category',
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('category_restore', 'Category restored successfully!');
    }
    function permanent_delete_category($permanent_delete)
    {
        $cat_id = Category::onlyTrashed()->find($permanent_delete);
        $category_img = public_path('uploads/category/' . $cat_id->icon);
        unlink($category_img);

        Category::onlyTrashed()->find($permanent_delete)->forceDelete();
        Subcategory::where('category_id', $permanent_delete)->update([
            'category_id' => 1,
        ]);
        Loginfo::insert([
            'user_id'=>Auth::id(),
            'model'=>'Category',
            'data'=>$cat_id->category_name,
            'action'=>'Permanent Delete',
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('permanent_delete', 'Category permanently deleted!');
    }
    function edit_category($id)
    {
        $cat_id = Category::find($id);
        return view('admin.category.edit', compact('cat_id'));
    }
    function update_category(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        if ($request->icon == '') {
            Category::find($id)->update([
                'category_name' => $request->category_name,
            ]);
            return back();
        } else {
            $cat_id = Category::find($id);
            $category_img = public_path('uploads/category/' . $cat_id->icon);
            unlink($category_img);

            $icon = $request->icon;
            $extension = $icon->extension();
            $file_name = str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
            Image::make($icon)->save(public_path('uploads/category/' . $file_name));

            Category::find($id)->update([
                'category_name' => $request->category_name,
                'icon' => $file_name,
            ]);
            return back()->with('update', 'Successfully Updated!');
        }
    }
    function checked_delete(Request $request)
    {
        foreach ($request->check as $category) {
            Category::find($category)->delete();
        }
        return back()->with('category_delete', 'Category move to trash!');
    }
    function restore_all(Request $request)
    {
        if ($request->checked == 1) {
            foreach ($request->check as $category) {
                Category::onlyTrashed()->find($category)->restore();
            }
            return back()->with('restore_all', 'Category Restored!');
        }
        if ($request->checked == 2) {
            foreach ($request->check as $category) {
                Category::onlyTrashed()->find($category)->forceDelete();
            }
            return back()->with('restore_all', 'Category Restored!');
        }
    }
}
