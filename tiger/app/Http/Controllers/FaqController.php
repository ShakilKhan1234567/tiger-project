<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq.faq_list', [
            'faqs'=>$faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faq.faq_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'question'=>'required',
        'answer'=>'required',
        ]);
        Faq::insert([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'Successfully Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Faq::find($id);
        return view('admin.faq.faq_show', compact('show'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faq_edit = Faq::find($id);
        return view('admin.faq.faq_edit', compact('faq_edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Faq::find($id)->update([
            'question'=>$request->question,
            'answer'=>$request->answer,
        ]);
        return back()->with('update_success', 'Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Faq::find($id)->delete();
        return back()->with('delete', 'Successfully Deleted!');
    }
}
