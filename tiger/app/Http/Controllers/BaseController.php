<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Subscribe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class BaseController extends Controller
{
    function dashboard(){
        $orders = Order::where('order_date', '>', Carbon::now()->subDays('7'))
        ->groupBy('order_date')
        ->selectRaw('count(*) as total, order_date')
        ->get();

        $total_order = '';
        $order_date = '';
        foreach($orders as $order){
            $total_order .= $order->total.',';
            $order_date .= Carbon::parse($order->order_date)->format('M-d').',';
        }
        $total_order_info = explode(',', $total_order);
        $total_date_info = explode(',', $order_date);

        array_pop($total_order_info);
        array_pop($total_date_info);


        // sales
        $sales = Order::where('order_date', '>', Carbon::now()->subDays('7'))
        ->groupBy('order_date')
        ->selectRaw('sum(total) as sum, order_date')
        ->get();

        $total_sale = '';
        $sale_date = '';
        foreach($sales as $sale){
            $total_sale .= $sale->sum.',';
            $sale_date .= Carbon::parse($sale->order_date)->format('M-d').',';
        }
        $total_sale_info = explode(',', $total_sale);
        $sale_date_info = explode(',', $sale_date);

        array_pop($total_sale_info);
        array_pop($sale_date_info);

        return view('dashboard', compact('total_order_info', 'total_date_info', 'total_sale_info', 'sale_date_info'));
    }

    function user_list(){
        $users = User::where('id','!=',Auth::id())->get();
        return view('admin.user.user_list', compact('users'));
    }
    function delete_user($user_id){
        User::find($user_id)->delete();

        return back()->with('delete','successfully delete!');
    }
    function user_add(Request $request){
      $request->validate([
      'name'=>'required',
      'email'=>'required',
      'password'=>'required',
      'password'=>Password::min(8)
      ->letters()
      ->mixedCase()
      ->numbers()
      ->symbols(),
      'confirm_password'=>'required',
      ]);
      if($request->password != $request->confirm_password){
        return back()->with('match', 'confirm password does not match!');
      }

      User::insert([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
      ]);
      return back()->with('add','Successfully Added!');
    }

    function subscribe_store(Request $request){
       Subscribe::insert([
        'customer_id'=>1,
        'email'=>$request->email,
        'created_at'=>Carbon::now(),
       ]);

       return back();
    }

    function subscribe_list(){
        $subscribes = Subscribe::all();
        return view('admin.subscribe.subscribe', [
            'subscribes'=>$subscribes,
        ]);
    }

    function delete_subscribe($id){
        Subscribe::find($id)->delete();

        return back()->with('success_delete', 'Successfully Deleted!');
    }
}
