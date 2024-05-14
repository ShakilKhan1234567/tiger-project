<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function tag(){
        $tags = Tag::all();
        return view('admin.tag.tag', [
            'tags'=>$tags,
        ]);
    }

    function tag_store(Request $request){
        Tag::insert([
            'tag_name'=>$request->tag_name,
            'created_at'=>Carbon::now()
        ]);
        return back()->with('tag', 'Successfully Added!');
    }

    function tag_delete($id){
       Tag::find($id)->delete();

       return back()->with('tag_delete', 'successfully deleted!');
    }
}
