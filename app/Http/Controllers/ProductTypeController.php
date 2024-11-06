<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Models\Department;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::with('department')->whereHas('department')->get();

        return view('product-types.index', compact('productTypes'));
    }

    public function create()
    {
        $departments = Department::all();

        return view('product-types.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id'     => 'required',
           'product_type_name'  => [
                'required',
                Rule::unique('product_types')
                    ->where(function ($query) use ($request) {
                        return $query->where('department_id', $request->department_id)
                                    ->whereNull('deleted_at');
                    }),
            ],
        ]);

        $imageName = uploadFile($request->file('image'), 'uploads/product-types/');

        ProductType::create([
            'department_id'      => $request->department_id,
            'product_type_name' => $request->product_type_name,
            'status'             => $request->status,
            'description'        => $request->description,
            'image'              => $imageName
        ]);

        return redirect()->route('product-types.index')->with('success', 'Product Type created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $departments = Department::all();
        $productType = ProductType::where('id', $id)->first();

        return view('product-types.edit', compact('departments', 'productType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id'       => 'required',
           'product_type_name' => [
                'required',
                Rule::unique('product_types')
                    ->ignore($id) // Exclude the current record being updated
                    ->where(function ($query) use ($request) {
                        return $query->where('department_id', $request->department_id)
                                    ->whereNull('deleted_at');
                    }),
            ],
        ]);

        $productType = ProductType::where('id', $id)->first();
        $oldProductTypeImage = $productType ? $productType->image : NULL;

        if($request->image) {
            $imageName = uploadFile($request->file('image'), 'uploads/product-types/');
            $image_path = public_path($oldProductTypeImage);

            if ($oldProductTypeImage && File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $productType->update([
            'department_id'      => $request->department_id,
            'product_type_name' => $request->product_type_name,
            'status'             => $request->status,
            'description'        => $request->description,
            'image'              => $imageName ?? $oldProductTypeImage
        ]);

        return redirect()->route('product-types.index')->with('success', 'Product Type updated successfully.');
    }

    public function destroy(string $id)
    {
        $productType = ProductType::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product Type deleted successfully.'
        ]);
    }

    public function productTypeStatus(Request $request)
    {
        $productType = ProductType::find($request->id);
        if ($productType) {
            $productType->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Product Type not found.'], 404);
    }
}
