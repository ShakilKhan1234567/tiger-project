<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function profile_update()
    {
        return view('admin.user.profile_update');
    }

    function profile_update_info(Request $request)
    {
        User::find(Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return back()->with('update_info', 'Successfully Updated!');
    }

    function password_update(UserRequest $request)
    {
        $user = User::find(Auth::id());

        if (Hash::check($request->current_password, $user->password)) {
            User::find(Auth::id())->update([
                'password' => bcrypt($request->password),
            ]);

            return back()->with('pass_update', 'Password Successfully Updated!');
        } else {
            return back()->with('invalid_password', 'Old Password does not match!');
        }
    }

    function photo_update(Request $request)
    {
        $request->validate([
            'photo' => 'required',
            'photo' => 'mimes:jpg,png',
            // 'photo'=>'file | max:1024',
            // 'photo'=>'dimensions:min_width=400,min_height=400',
        ], [
            'photo.required' => 'Photo Must Be Needed',
        ]);

        if (Auth::user()->photo == null) {

            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = Auth::id() . '.' . $extension;

            Image::make($photo)->resize(400, 400)->save(public_path('uploads/user/' . $file_name));

            User::find(Auth::id())->update([
                'photo' => $file_name,
            ]);
            return back()->with('photo_update', 'successfully updated');
        } else {
            $current_img = public_path('uploads/user/' . Auth::user()->photo);
            unlink($current_img);

            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = Auth::id() . '.' . $extension;

            Image::make($photo)->resize(400, 400)->save(public_path('uploads/user/' . $file_name));
            User::find(Auth::id())->update([
                'photo' => $file_name,
            ]);
            return back()->with('photo_update', 'successfully updated');
        }
    }
}
