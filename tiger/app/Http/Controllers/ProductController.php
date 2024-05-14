<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Gallery;
use App\Models\Subcategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function add_product()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $tags = Tag::all();
        return view('admin.product.product', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
            'tags' => $tags,
        ]);
    }
    function getSubcategory(Request $request)
    {
        $str = '<option value="">Select SubCategory</option>';
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        foreach ($subcategories as $subcategory) {
            $str .= '<option value="' . $subcategory->id . '">' . $subcategory->subcategory_name . '</option>';
        }
        echo   $str;
    }
    function product_store(Request $request)
    {
        $remove = array("@", "#", "*", "(", ")", "/", " ", "' '", '"');
        $slug = str::lower(str_replace($remove, '-', $request->product_name)) . '-' . random_int(5000, 6000);
        $preview_image = $request->preview_image;
        $extension = $preview_image->extension();
        $file_name = str::lower(str_replace($remove, '-', $request->product_name)) . '-' . random_int(5000, 6000) . '.' . $extension;
        Image::make($preview_image)->save(public_path('uploads/product/preview/' . $file_name));

        $product_id = Product::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'discount' => $request->discount,
            'after_discount' => $request->product_price - $request->product_price * $request->discount / 100,
            'tags' => implode(',', $request->tags),
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'additional_info' => $request->additional_info,
            'preview_image' => $file_name,
            'slug'=> $slug,
            'created_at' => Carbon::now(),
        ]);

        $galleries = $request->gallery_image;
        $remove = array("@", "#", "*", "(", ")", "/", " ", '"');
        foreach ($galleries as $gallery) {
            $extension = $gallery->extension();
            $file_name = str::lower(str_replace($remove, '-', $request->product_name)) . '-' . random_int(5000, 6000) . '.' . $extension;
            Image::make($gallery)->save(public_path('uploads/product/gallery/' . $file_name));

            Product_Gallery::insert([
                'product_id' => $product_id,
                'gallery_image' => $file_name,
                'created_at' => Carbon::now(),
            ]);
        }

        return back()->with('product', 'Successfully Added!');
    }

    function product_list()
    {
        $products = Product::simplePaginate(4);
        return view('admin.product.product_list', [
            'products' => $products,
        ]);
    }
    function getstatus(Request $request)
    {
        Product::find($request->product_id)->update([
            'status' => $request->status,
        ]);
    }
    function list_delete($id)
    {
        Product::find($id)->delete();
        return back()->with('success', 'Successfully Deleted');
    }
    function view_list($id)
    {
        $products = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();
        $subcategories = Subcategory::all();
        $galleries = Product_Gallery::where('product_id', $id)->get();
        return view('admin.product.view_list', [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
            'galleries' => $galleries,
        ]);
    }
    function product_update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'product_name' => 'required',
            'product_price' => 'required',
            'short_desp' => 'required',
        ]);
        Product::find($id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'discount' => $request->discount,
            'after_discount' => $request->product_price - $request->product_price * $request->discount / 100,
            'tags' => implode(',', $request->tags),
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'additional_info' => $request->additional_info,
        ]);


        if ($request->preview_image != null) {
            $products = Product::find($id);
            $preview_image = $request->preview_image;
            $remove = array("@", "#", "*", "(", ")", "/", " ", '"');
            $extension = $preview_image->extension();
            $file_name = str::lower(str_replace($remove, '-', $request->product_name)) . '-' . random_int(5000, 6000) . '.' . $extension;

            $old_image = public_path('uploads/product/preview/' . $products->preview_image);
            unlink($old_image);
            Image::make($preview_image)->save(public_path('uploads/product/preview/' . $file_name));

            Product::find($id)->update([
                'preview_image' => $file_name,
            ]);
        }

        return back();
    }
}
