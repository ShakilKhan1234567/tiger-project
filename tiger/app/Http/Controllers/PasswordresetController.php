<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Passreset;
use App\Notifications\PassresetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PasswordresetController extends Controller
{
    function password_reset(){
        return view('frontend.password_reset.password_reset');
    }

    function pass_reset_req(Request $request){
        $request->validate([
          'email'=>'required',
        ]);

        if(Customer::where('email', $request->email)->exists()){
              $customer = Customer::where('email', $request->email)->first();
              Passreset::where('customer_id', $customer->id)->delete();

              $info = Passreset::create([
                'customer_id'=>$customer->id,
                'token'=>uniqid(),
                'created_at'=>Carbon::now(),
              ]);

              Notification::send($customer, new PassresetNotification($info));

              return back()->with('sent', "we have sent you a password reset link, on $customer->email");

        }
        else{
            return back()->with('exist', 'Email Does Not Exist');
        }
    }

    function password_reset_form($token){
        if(Passreset::where('token', $token)->exists()){
            return view('frontend.password_reset.password_reset_form', [
                'token'=>$token,
            ]);
        }
        else{
            abort('404');
        }
    }

    function password_reset_confirm(Request $request, $token){
        $request->validate([
            'password'=>'required',
            'password_confirmation'=>'required',
        ]);
        $passreset = Passreset::where('token', $token)->first();

        if(Passreset::where('token', $token)->exists()){
           Customer::find($passreset->customer_id)->update([
              'password'=>bcrypt($request->password),
           ]);
           Passreset::where('token', $token)->delete();
           return redirect()->route('customer.login')->with('reset', 'Password Reset Success!');
        }
        else{
            abort('404');
        }
    }
}
