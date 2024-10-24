<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
        ]);

        $imageName = uploadFile($request->file('image'), 'uploads/categories/');

        Category::create([
            'name'          => $request->name,
            'status'        => $request->categoryStatus,
            'description'   => $request->description,
            'image'         => $imageName
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required',
        ]);

        $category = Category::where('id', $id)->first();
        if($request->image) {
            $imageName = uploadFile($request->file('image'), 'uploads/categories/');
        }

        $category->update([
            'name'          => $request->name,
            'status'        => $request->categoryStatus,
            'description'   => $request->description,
            'image'         => $imageName ?? $category->image
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = Category::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Category not found.'], 404);
    }
}
