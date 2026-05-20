<?php

namespace App\Http\Controllers;

use App\Models\EditorContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EditorController extends Controller
{
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

    public function create()
    {
        return view('editor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        EditorContent::create($request->only('content'));

        Cache::forget('editor_draft');

        return redirect()->route('editor.index')
            ->with('success', 'Content created successfully');
    }

    public function edit($id)
    {
        $content = EditorContent::findOrFail($id);
        return view('editor.edit', compact('content'));
    }

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

    public function destroy($id)
    {
        EditorContent::findOrFail($id)->delete();

        return back()->with('success', 'Moved to trash');
    }

    public function trash()
    {
        $contents = EditorContent::onlyTrashed()->latest()->get();
        return view('editor.trash', compact('contents'));
    }

    public function restore($id)
    {
        EditorContent::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Restored successfully');
    }

    public function forceDelete($id)
    {
        EditorContent::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Deleted permanently');
    }

    public function autoSave(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
        ]);

        Cache::put('editor_draft', [
            'content' => $request->content
        ], now()->addDays(7));

        return response()->json([
            'status' => 'success',
            'message' => 'Draft Saved'
        ]);
    }
}