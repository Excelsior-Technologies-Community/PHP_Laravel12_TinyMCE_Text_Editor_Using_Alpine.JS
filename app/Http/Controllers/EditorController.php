<?php

namespace App\Http\Controllers;


use App\Models\EditorContent;
use Illuminate\Http\Request;


class EditorController extends Controller
{
    public function index()
    {
        $content = EditorContent::latest()->first();
        return view('editor', compact('content'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);


        EditorContent::create([
            'content' => $request->input('content')        
            ]);


        return redirect()->back()->with('success', 'Content saved successfully');
    }
}
