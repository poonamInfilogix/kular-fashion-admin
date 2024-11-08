<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Models\Department;
use App\Models\ProductTypeDepartment;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::with('productTypeDepartments')->get();
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
           'department_id'       => 'required',
           'product_type_name'   => 'required|unique:product_types,product_type_name' 
        ]);

        $imageName = uploadFile($request->file('image'), 'uploads/product-types/');

        $productType = ProductType::create([
            'product_type_name' => $request->product_type_name,
            'status'             => $request->status,
            'description'        => $request->description,
            'image'              => $imageName
        ]);
        foreach ($request->department_id as $departmentId) {
            ProductTypeDepartment::create([
                'product_type_id' => $productType->id,
                'department_id'   => $departmentId
            ]);
        }

        return redirect()->route('product-types.index')->with('success', 'Product Type created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $departments = Department::all();
        $productType = ProductType::with('productTypeDepartments')->where('id', $id)->first();
        $selectedDeparments = $productType->productTypeDepartments->pluck('department_id')->toArray();
        return view('product-types.edit', compact('departments', 'productType','selectedDeparments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id'       => 'required',
            'product_type_name'    => 'required|unique:product_types,product_type_name,' . $id
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
            'product_type_name' => $request->product_type_name,
            'status'             => $request->status,
            'description'        => $request->description,
            'image'              => $imageName ?? $oldProductTypeImage
        ]);
        
        ProductTypeDepartment::where('product_type_id',$id)->delete();
        foreach ($request->department_id as $departmentId) {
            ProductTypeDepartment::create([
                'product_type_id' => $id,
                'department_id'   => $departmentId
            ]);
        }

        return redirect()->route('product-types.index')->with('success', 'Product Type updated successfully.');
    }

    public function destroy(string $id)
    {
        $productType = ProductType::where('id', $id)->delete();
        ProductTypeDepartment::where('product_type_id',$id)->delete();
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
