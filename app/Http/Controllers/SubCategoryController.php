<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->whereHas('category')->get();

        return view('sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'       => 'required',
            'sub_category_name' => 'required',
        ]);

        $imageName = uploadFile($request->file('sub_category_image'), 'uploads/sub-categories/');

        SubCategory::create([
            'category_id'       => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
            'status'            => $request->subCategoryStatus,
            'description'       => $request->description,
            'image'             => $imageName
        ]);

        return redirect()->route('sub-categories.index')->with('success', 'Sub Category created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $categories = Category::all();
        $subCategory = SubCategory::where('id', $id)->first();

        return view('sub-categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id'       => 'required',
            'sub_category_name' => 'required',
        ]);

        $subCategory = SubCategory::where('id', $id)->first();
        $oldSubCategoryImage = $subCategory ? $subCategory->image : NULL;

        if($request->sub_category_image) {
            $imageName = uploadFile($request->file('sub_category_image'), 'uploads/sub-categories/');
            $image_path = public_path($oldSubCategoryImage);

            if ($oldSubCategoryImage && File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $subCategory->update([
            'category_id'       => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
            'status'            => $request->subCategoryStatus,
            'description'       => $request->description,
            'image'             => $imageName ?? $oldSubCategoryImage
        ]);

        return redirect()->route('sub-categories.index')->with('success', 'Sub Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $subCategory = SubCategory::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'SubCategory deleted successfully.'
        ]);
    }

    public function SubCategoryStatus(Request $request)
    {
        $subCategory = SubCategory::find($request->id);
        if ($subCategory) {
            $subCategory->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Sub Category not found.'], 404);
    }
}
