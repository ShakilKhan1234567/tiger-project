<?php

namespace App\Http\Controllers;

use App\Models\Baner;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Inventory;
use App\Models\Loginfo;
use App\Models\Offer1;
use App\Models\Offer2;
use App\Models\Orderproduct;
use App\Models\Product;
use App\Models\Product_Gallery;
use App\Models\Size;
use App\Models\Tag;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class frontendController extends Controller
{

    function api_category(){
        $categories = file_get_contents('http://127.0.0.1:8000/api/get/category');
        $categories = json_decode($categories);
        return view('apicategory', [
            'categories'=> $categories,
        ]);
    }

    function welcome(){
        $banners = Baner::all();
        $categories = Category::all();
        $offer1 = Offer1::all();
        $offer2 = Offer2::all();
        $products = Product::take(8)->get();
        return view('frontend.index', [
            'banners'=>$banners,
            'categories'=>$categories,
            'offer1'=>$offer1,
            'offer2'=>$offer2,
            'products'=>$products,
        ]);
    }

    function product_details($slug){
        $product_id = Product::where('slug', $slug)->first()->id;
        $product_info = Product::find($product_id);
        $reviews = Orderproduct::where('product_id', $product_id)->whereNotNull('review')->get();
        $total_reviews = Orderproduct::where('product_id', $product_id)->whereNotNull('review')->count();
        $total_star = Orderproduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');
        $galleries = Product_Gallery::where('product_id', $product_id)->get();
        $available_colors = Inventory::where('product_id',$product_id)
        ->groupBy('color_id')
        ->selectRaw('sum(color_id) as sum, color_id')
        ->get();
        $available_sizes = Inventory::where('product_id',$product_id)
        ->groupBy('size_id')
        ->selectRaw('sum(size_id) as sum, size_id')
        ->get();

        // recent view
        $all = Cookie::get('recent_view');
        if(!$all){
            $all = "[]";
        }
        $all_info = json_decode($all, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_product_id = json_encode($all_info);

        Cookie::queue('recent_view', $recent_product_id, 1000);

        return view('frontend.product_details', [
            'product_info'=>$product_info,
            'galleries'=>$galleries,
            'available_colors'=>$available_colors,
            'available_sizes'=>$available_sizes,
            'reviews'=>$reviews,
            'total_reviews'=>$total_reviews,
            'total_star'=>$total_star,
        ]);
    }


    function getsize(Request $request){
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach($sizes as $size){
            if($size->rel_to_size->size_name == 'NA'){
                $str = '<li class="color"><input class="size_id" checked id="size'.$size->size_id.'" type="radio" name="size_id" value="'.$size->size_id.'">
                <label for="size'.$size->size_id.'">'.$size->rel_to_size->size.'</label>
             </li>';
            }
            else{
                $str .= '<li class="color"><input class="size_id" id="size'.$size->size_id.'" type="radio" name="size_id" value="'.$size->size_id.'">
                <label for="size'.$size->size_id.'">'.$size->rel_to_size->size.'</label>
             </li>';
            }
        }
        echo $str;
    }

    function getquantity(Request $request){
        $str = '';
           $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
           if($quantity == 0){
            $str = '<strong id="quan" class="btn btn-danger">Out Of Stock</strong>';
           }
           else{
            $str = '<strong id="quan" class="btn btn-success">'.$quantity.' In Stock</strong>';
           }
           echo $str;
    }

    function review_store(Request $request, $id){
        Orderproduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $id)->first()->update([
           'review'=>$request->review,
           'star'=>$request->stars,
           'updated_at'=>Carbon::now(),
        ]);
        return back();
    }

    function shop(Request $request){
        $data = $request->all();

         $based = 'created_at';
         $type = 'DESC';

        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
            if($data['sort'] == 1){
                $based = 'product_price';
                $type = 'ASC';
            }
            else if($data['sort'] == 2){
                $based = 'product_price';
                $type = 'DESC';
            }
            else if($data['sort'] == 3){
                $based = 'product_name';
                $type = 'ASC';
            }
            else if($data['sort'] == 4){
                $based = 'product_name';
                $type = 'DESC';
            }
        }

        $products = Product::where(function ($q) use ($data){

            $min = 0;
            $max = 0;

            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined'){
                $min = $data['min'];
            }
           else{
            $min = 1;
           }

            if(!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $max = $data['max'];
            }
           else{
            $max = Product::max('product_price');
           }

            if(!empty($data['search_input']) && $data['search_input'] != '' && $data['search_input'] != 'undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('product_name', 'like', '%'.$data['search_input'].'%');
                    $q->orWhere('long_desp', 'like', '%'.$data['search_input'].'%');
                    $q->orWhere('additional_info', 'like', '%'.$data['search_input'].'%');
                });
            };

            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('category_id', $data['category_id']);
                });
            };

            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $q->whereBetween('product_price', [$min, $max]);
        };

        if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
            $q->whereHas('rel_to_inventory', function ($q) use ($data){
                if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                    $q->whereHas('rel_to_variation', function ($q) use ($data){
                        $q->where('variations.id', $data['color_id']);
                    });
                };
            });
        };

        if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
            $q->whereHas('rel_to_inventory', function ($q) use ($data){
                if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                    $q->whereHas('rel_to_variation', function ($q) use ($data){
                        $q->where('variations.id', $data['color_id']);
                    });
                };

                if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                    $q->whereHas('rel_to_size', function ($q) use ($data){
                        $q->where('sizes.id', $data['size_id']);
                    });
                };
            });
        };

        if(!empty($data['tag']) && $data['tag'] != '' && $data['tag'] != 'undefined'){
            $q->where(function ($q) use ($data){
                $all = '';
                foreach(Product::all() as $product){
                    $explode = explode(',', $product->tags);
                    if(in_array($data['tag'], $explode)){
                        $all .= $product->id.',';
                    }
                }
                $explode2 = explode(',', $all);
                $q->find($explode2);
            });
        };

        })->orderBy($based, $type)->get();

        $categories = Category::all();
        $colors = Variation::all();
        $sizes = Size::all();
        $tags = Tag::all();
        return view('frontend.shop', [
            'products'=>$products,
            'categories'=>$categories,
            'colors'=>$colors,
            'sizes'=>$sizes,
            'tags'=>$tags,
        ]);
    }

    function recent_view(){
        $product_ids = json_decode(Cookie::get('recent_view'));
        if($product_ids == null){
            $product_ids = [];
            $recent_viewed = array_unique($product_ids);
        }
        else{
            $recent_viewed = array_reverse(array_unique($product_ids));
        }
        $recents = Product::find($recent_viewed);
        return view('frontend.recent_view', [
            'recents'=>$recents,
        ]);
    }

    function faqs(){
        $faqs = Faq::all();
        return view('frontend.faqs', [
            'faqs'=>$faqs,
        ]);
    }


    function tag_product($id){
        $all = '';
        foreach(Product::all() as $product){
           $explode = explode(',', $product->tags);
           if(in_array($id, $explode)){
             $all .= $product->id. ',';
           }
        }
        $explode2 = explode(',', $all);
        $tag_products = Product::find($explode2);
        return view('frontend.tag_product',[
            'tag_products'=>$tag_products,
        ]);
    }
}
