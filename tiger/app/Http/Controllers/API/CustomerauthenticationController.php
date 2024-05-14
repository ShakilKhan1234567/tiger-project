<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class CustomerauthenticationController extends Controller
{
    function api_customer_register(Request $request){
        $validator = Validator::make($request->all(),[
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
        ]);
        if($validator->fails()){
            return $validator->errors()->all();
        }

        $customers = Customer::create([
            'fname'=>$request->fname,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        $token = $customers->createToken('apitoken')->plainTextToken;


        return response()->json([
            'data'=>$customers,
            'token'=>$token,
            'success'=>"Successfully Registered",
        ]);
    }

    function customer_login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);

        $customers = Customer::where('email', $request->email)->first();
        if(Customer::where('email', $request->email)->exists()){
            if(Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = $customers->createToken('apitoken')->plainTextToken;
                return response()->json([
                    'success'=>"Successfully Login",
                    'email'=>$customers->email,
                    'token'=>$token,
                ]);
            }
            else{
                return response()->json(['error'=>'Password Does Not Exist']);
            }
        }
        else{
         return response()->json(['error'=>'Email Does Not Exist']);
        }
    }

    function customer_logout(Request $request){
        $accesToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accesToken);

        $token->delete();

        return response()->json(['success'=>'Successfully Logout']);
    }
}
