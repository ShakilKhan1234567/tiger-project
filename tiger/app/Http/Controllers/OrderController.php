<?php

namespace App\Http\Controllers;

use App\Models\Cancelorder;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Orderproduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class OrderController extends Controller
{
    function order(){
        $orders = Order::latest()->get();
        return view('admin.order.order', [
            'orders'=> $orders,
        ]);
    }
    function status(Request $request, $id){
       Order::find($id)->update([
           'status'=>$request->status,
       ]);
       return back();
    }
    function cancel_order(Request $request, $id){
        $order_info = Order::find($id);
        return view('frontend.customer.cancel_order', [
            'order_info'=>$order_info,
        ]);
    }
    function cancel_order_req(Request $request, $id){
        if($request->photo == ''){
            Cancelorder::insert([
               'order_id'=>$id,
               'reason'=>$request->reason,
               'created_at'=>Carbon::now(),
            ]);
            return back()->with('cancel_order', 'Cancel Request Sent');
         }
         else{
            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = random_int(10000, 50000).'.'.$extension;
            Image::make($photo)->save(public_path('uploads/cancelorder/'.$file_name));

            Cancelorder::insert([
             'order_id'=>$id,
             'reason'=>$request->reason,
             'photo'=>$file_name,
             'created_at'=>Carbon::now(),
          ]);
          return back()->with('cancel_order', 'Cancel Request Sent');
         }
    }
    function order_cancel_list(){
        $cancel_order_list = Cancelorder::all();
        return view('admin.order.order_cancel_list', [
            'cancel_order_list'=>$cancel_order_list,
        ]);
    }
    function order_cancel_details($id){
        $cancel_details = Cancelorder::find($id);
        return view('admin.order.order_cancel_details',[
            'cancel_details'=>$cancel_details,
        ]);
    }
    function cancel_accept($id){
        $cancel_details = Cancelorder::find($id);
        Order::find($cancel_details->order_id)->update([
             'status'=>5,
        ]);
        $order_id = Order::find($cancel_details->order_id);
        foreach(Orderproduct::where('order_id',$order_id->order_id)->get() as $orderproduct){
            Inventory::where('product_id',$orderproduct->product_id)->where('color_id',$orderproduct->color_id)->where('size_id',$orderproduct->size_id)->increment('quantity',$orderproduct->quantity);
        }
        $cancel_details = Cancelorder::find($id)->delete();
        return back();
    }
}
