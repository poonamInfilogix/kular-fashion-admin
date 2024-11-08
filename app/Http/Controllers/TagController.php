<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();

        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|unique:tags,tag_name',
        ]);

        Tag::create([
            'tag_name' => $request->tag_name,
            'status'   => $request->status,
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'tag_name' => 'required|unique:tags,tag_name,' .$tag->id,
        ]);

        $tag->update([
            'tag_name' => $request->tag_name,
            'status'   => $request->status,
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully.'
        ]);
    }

    public function tagStatus(Request $request)
    {
        $tag = Tag::find($request->id);
        if ($tag) {
            $tag->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Tag not found.'], 404);
    }


}
