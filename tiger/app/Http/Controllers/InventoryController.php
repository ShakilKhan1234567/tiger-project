<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function add_inventory($id){
        $products = Product::find($id);
        $colors = Variation::all();
        $inventories = Inventory::where('product_id',$id)->get();
        return view('admin.inventory.inventory',[
            'colors'=>$colors,
            'products'=>$products,
            'inventories'=>$inventories,
        ]);
    }
    function inventory_store(Request $request,$id){
        $request->validate([
           'color_id'=>'required',
           'size_id'=>'required',
           'quantity'=>'required',
        ]);

       if(Inventory::where('product_id',$id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){
        Inventory::where('product_id',$id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);
       }
        Inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('insert', 'Successfully Added!');
    }
    function delete_inventory($id){
        Inventory::find($id)->delete();

        return back()->with('inventory', 'Successfully Deleted!');
    }
}
