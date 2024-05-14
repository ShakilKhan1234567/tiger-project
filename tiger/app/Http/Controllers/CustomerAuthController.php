<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Emailverify;
use App\Notifications\EmailverifyNotification;
use App\Rules\ReCaptcha;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    function customer_login(){
        return view('frontend.customer.customer_login');
    }
    function customer_register(){
        return view('frontend.customer.customer_register');
    }

    function customer_store(Request $request){
        $request->validate([
           'fname'=>'required',
           'email'=>'required|unique:customers',
           'password' => [
            'required',
            'confirmed',
            Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols(),
        ],
           'password_confirmation'=>'required',
           'captcha' => 'required|captcha',
        ]);

        $customer_info = Customer::create([
           'fname'=>$request->fname,
           'lname'=>$request->lname,
           'email'=>$request->email,
           'password'=>bcrypt($request->password),
           'created_at'=>Carbon::now(),
        ]);
        Emailverify::where('customer_id', $customer_info->id)->delete();

        $info = Emailverify::create([
          'customer_id'=>$customer_info->id,
          'token'=>uniqid(),
        ]);

        Notification::send($customer_info, new EmailverifyNotification($info));

        return back()->with('success', 'Successfully Registered, Please verify your email!');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    function customer_logged(Request $request){
        $request->validate([
        'email'=>'required',
        'password'=>'required',
        'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        if(Customer::where('email', $request->email)->exists()){
            if(Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])){

                if(Auth::guard('customer')->user()->email_verified_at == null){
                    Auth::guard('customer')->logout();
                   return redirect()->route('customer.login')->with('verify_email', 'Verify your email first!');
                }
                else{
                    return redirect()->route('index');
                }
            }
            else{
                return back()->with('wrong', 'Password Does Not Match');
            }
        }
        else{
            return back()->with('exist', 'Email Does Not Exist');
        }
    }
}
