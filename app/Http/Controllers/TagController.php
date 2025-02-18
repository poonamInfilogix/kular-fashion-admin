<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    public function index()
    {
        if(!Gate::allows('view tags')) {
            abort(403);
        }
        $tags = Tag::latest()->get();

        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        if(!Gate::allows('create tags')) {
            abort(403);
        }
        return view('tags.create');
    }

    public function store(Request $request)
    {
        if(!Gate::allows('create tags')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|unique:tags,name',
        ]);

        Tag::create([
            'name' => $request->name,
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
        if(!Gate::allows('edit tags')) {
            abort(403);
        }
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        if(!Gate::allows('edit tags')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|unique:tags,name,' .$tag->id,
        ]);

        $tag->update([
            'name' => $request->name,
            'status'   => $request->status,
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        if(!Gate::allows('delete tags')) {
            abort(403);
        }
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
