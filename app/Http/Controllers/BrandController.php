<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Imports\BrandImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();

        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => [
                'required',
                    Rule::unique('brands')->whereNull('deleted_at'),
                ],
        ]);

        $imageName = uploadFile($request->file('brand_image'), 'uploads/brands/');

        Brand::create([
            'brand_name'    => $request->brand_name,
            'status'        => $request->status,
            'description'   => $request->description,
            'image'         => $imageName
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $brand = Brand::where('id', $id)->first();

        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_name' => [
                'required',
                Rule::unique('brands')->ignore($id)->whereNull('deleted_at'),
            ],
        ]);

        $brand = Brand::where('id', $id)->first();
        $oldBrandImage = $brand ? $brand->image : NULL;

        if($request->brand_image) {
            $imageName = uploadFile($request->file('brand_image'), 'uploads/brands/');
            $image_path = public_path($oldBrandImage);

            if ($oldBrandImage && File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $brand->update([
            'brand_name'    => $request->brand_name,
            'status'        => $request->status,
            'description'   => $request->description,
            'image'         => $imageName ?? $oldBrandImage
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(string $id)
    {
        $brand = Brand::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully.'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $brand = Brand::find($request->id);
        if ($brand) {
            $brand->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Brand not found.'], 404);
    }

    public function importBrands(Request $request)
    {
        $import = new BrandImport;
        Excel::import($import, $request->file('file'));

        $errors = $import->getErrors();
        if (!empty($errors)) {
            session()->flash('import_errors', $errors);
        }

        return redirect()->route('brands.index')->with('success', 'Bay imported successfully.');
    }
}
