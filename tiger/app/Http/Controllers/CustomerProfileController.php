<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Emailverify;
use App\Models\Order;
use App\Notifications\EmailverifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;
use PDF;

class CustomerProfileController extends Controller
{
    function __construct()
    {
        $this->middleware('customer');
    }

    function customer_profile(Request $request){
        return view('frontend.customer.customer_profile');
    }

    function customer_logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('index')->with('logout', 'You Are Logged out');
    }

    function profile_update(Request $request){
      if($request->password == ''){
          if($request->photo == ''){
             Customer::find(Auth::guard('customer')->id())->update([
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'phone'=>$request->phone,
                'zip'=>$request->zip,
                'address'=>$request->address,
                'updated'=>Carbon::now(),
             ]);
             return back()->with('without', 'Successfully Updated!');
          }
          else{
            if(Auth::guard('customer')->user()->photo != null){
                $current = public_path('uploads/customer/'.Auth::guard('customer')->user()->photo);
                unlink($current);
            }
             $photo = $request->photo;
             $extension = $photo->extension();
             $file_name = Auth::guard('customer')->id().'.'.$extension;
             Image::make($photo)->save(public_path('uploads/customer/'.$file_name));

             Customer::find(Auth::guard('customer')->id())->update([
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'phone'=>$request->phone,
                'zip'=>$request->zip,
                'address'=>$request->address,
                'photo'=>$file_name,
                'updated'=>Carbon::now(),
             ]);
             return back()->with('photo', 'Successfully Updated!');
          }
      }
      else{
        if($request->photo == ''){
            Customer::find(Auth::guard('customer')->id())->update([
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'phone'=>$request->phone,
                'zip'=>$request->zip,
                'address'=>$request->address,
                'password'=>bcrypt($request->password),
                'updated'=>Carbon::now(),
             ]);
             return back()->with('pass', 'Successfully Updated!');
        }
        else{
            if(Auth::guard('customer')->user()->photo != null){
                $current = public_path('uploads/customer/'.Auth::guard('customer')->user()->photo);
                unlink($current);
            }
            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = Auth::guard('customer')->id().'.'.$extension;
            Image::make($photo)->save(public_path('uploads/customer/'.$file_name));

            Customer::find(Auth::guard('customer')->id())->update([
               'fname'=>$request->fname,
               'lname'=>$request->lname,
               'phone'=>$request->phone,
               'zip'=>$request->zip,
               'address'=>$request->address,
               'password'=>bcrypt($request->password),
               'photo'=>$file_name,
               'updated'=>Carbon::now(),
            ]);
            return back()->with('success', 'Successfully Updated!');
        }
      }
    }

    function my_orders(){
        $my_orders = Order::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.customer.myorder',[
            'my_orders'=>$my_orders,
        ]);
    }
    function download_invoice($id){
        $orders = Order::find($id);
        $pdf = PDF::loadView('frontend.customer.invoicedownload', [
            'order_id'=>$orders->order_id,
        ]);
        return $pdf->stream('myorder.pdf');
    }

    function email_verify_confirm($token){
        $email_verify = Emailverify::where('token', $token)->first();

        if(Emailverify::where('token', $token)->exists()){
          Customer::find($email_verify->customer_id)->update([
            'email_verified_at'=>Carbon::now(),
          ]);

          Emailverify::where('token', $token)->delete();

          return redirect()->route('customer.login')->with('verify', 'Successfully Verified!');
        }
        else{
            abort('404');
        }
    }

    function resend_email_verification(){
        return view('frontend.customer.resend_email_verification');
    }

    function resent_email_verification_confirm(Request $request){
        $customer = Customer::where('email', $request->email)->first();

        if(Customer::where('email', $request->email)->exists()){

            Emailverify::where('customer_id', $customer->id)->delete();

            $info = Emailverify::create([
            'customer_id'=>$customer->id,
            'token'=>uniqid(),
            ]);

            Notification::send($customer, new EmailverifyNotification($info));

           return back()->with('success', 'We have send you a email verification, Please verify your email!');
        }
        else{
            return redirect()->route('customer.register')->with('registration_first', 'Please registration first!');
        }
    }
}
