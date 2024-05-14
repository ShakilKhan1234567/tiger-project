<?php

namespace App\Http\Controllers;

use App\Models\Offer1;
use App\Models\Offer2;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    function offer1(){
        $offer = Offer1::all();
        $offer2 = Offer2::all();
        return view('admin.offer.offer', [
            'offer'=>$offer,
            'offer2'=>$offer2,
        ]);
    }

    function offer1_update(Request $request, $id){
        if($request->photo == null){
            Offer1::find($id)->update([
               'title'=>$request->title,
               'price'=>$request->price,
               'discount_price'=>$request->discount_price,
               'date'=>$request->date,
            ]);
            return back()->with('off1', 'Successfully Updated');
        }
        else{
            $offer = Offer1::find($id);
            $current_image = public_path('uploads/offer/'.$offer->photo);
            unlink($current_image);

            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = 'offer1'.'-'.random_int(5000, 6000).'.'.$extension;
            Image::make($photo)->save(public_path('uploads/offer/'.$file_name));

            Offer1::find($id)->update([
                'title'=>$request->title,
                'price'=>$request->price,
                'discount_price'=>$request->discount_price,
                'date'=>$request->date,
                'photo'=>$file_name,
             ]);
             return back()->with('success', 'Successfully Updated');
        }
    }

    function offer2_update(Request $request, $id){
        if($request->photo == null){
            Offer2::find($id)->update([
               'title'=>$request->title,
               'sub_title'=>$request->sub_title,
            ]);
            return back()->with('off2', 'Successfully Updated');
        }
        else{
            $offer2 = Offer2::find($id);
            $current_image = public_path('uploads/offer/'.$offer2->photo);
            unlink($current_image);

            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = 'offer2'.'-'.random_int(5000, 6000).'.'.$extension;
            Image::make($photo)->save(public_path('uploads/offer/'.$file_name));

            Offer2::find($id)->update([
                'title'=>$request->title,
                'sub_title'=>$request->sub_title,
                'photo'=>$file_name,
             ]);
             return back()->with('success2', 'Successfully Updated');
        }
    }
}
