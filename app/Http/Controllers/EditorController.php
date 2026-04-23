<?php

namespace App\Http\Controllers;

use App\Models\EditorContent;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    // LIST (Dashboard)
    public function index(Request $request)
{
    $query = EditorContent::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('content', 'like', '%' . $search . '%');
    }

    $contents = $query->orderBy('id', 'asc')->get();

    return view('editor.index', compact('contents'));
}

    // CREATE FORM
    public function create()
    {
        return view('editor.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        EditorContent::create($request->only('content'));

        return redirect()->route('editor.index')
            ->with('success', 'Content created successfully');
    }

    // EDIT FORM
    public function edit($id)
    {
        $content = EditorContent::findOrFail($id);
        return view('editor.edit', compact('content'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $content = EditorContent::findOrFail($id);
        $content->update($request->only('content'));

        return redirect()->route('editor.index')
            ->with('success', 'Content updated successfully');
    }

    // SOFT DELETE
    public function destroy($id)
    {
        EditorContent::findOrFail($id)->delete();

        return back()->with('success', 'Moved to trash');
    }

    // TRASH LIST
    public function trash()
    {
        $contents = EditorContent::onlyTrashed()->latest()->get();
        return view('editor.trash', compact('contents'));
    }

    // RESTORE
    public function restore($id)
    {
        EditorContent::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Restored successfully');
    }

    // FORCE DELETE
    public function forceDelete($id)
    {
        EditorContent::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Deleted permanently');
    }
}