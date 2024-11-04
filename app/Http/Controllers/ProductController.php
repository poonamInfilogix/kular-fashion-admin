<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Department;
use App\Models\ProductType;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand','department','productType')->latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $latestProduct = Product::orderBy('article_code', 'desc')->first();

        $latestNewCode = $latestProduct ? (int)$latestProduct->article_code : 300000;
        $brands = Brand::latest()->get();
        $productTypes = ProductType::latest()->get();
        $departments = Department::latest()->get();

        return view('products.create', compact('latestNewCode', 'brands', 'productTypes', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'manufacture_code' => 'required|unique:products,manufacture_code',
            'brand_id'         => 'required',
            'product_type_id'  => 'required'
        ]);

        $imageName = uploadFile($request->file('image'), 'uploads/products/');

        Product::create([
            'article_code'    => $request->article_code,
            'manufacture_code'=> $request->manufacture_code,
            'brand_id'        => $request->brand_id,
            'product_type_id' => $request->product_type_id,
            'mrp'             => $request->mrp,
            'supplier_price'  => $request->supplier_price,
            'department_id'   => $request->department_id,
            'season'          => $request->season,
            'supplier_ref'    => $request->supplier_ref,
            'tax_id'          => $request->tax,
            'in_date'         => $request->in_date,
            'last_date'       => $request->last_date,
            'short_description'=> $request->short_description,
            'image'           => $imageName,
            'status'          => $request->status
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show()
    {
        //
    }

    public function edit(Product $product)
    {
        $brands = Brand::latest()->get();
        $productTypes = ProductType::latest()->get();
        $departments = Department::latest()->get();

        return view('products.edit', compact('brands', 'productTypes', 'departments', 'product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'manufacture_code' => 'required|unique:products,manufacture_code,' . $id,
            'brand_id'         => 'required',
            'product_type_id'  => 'required'
        ]);

        $product = Product::where('id', $id)->first();
        $oldProductImage = $product ? $product->image : NULL;

        if($request->image) {
            $imageName = uploadFile($request->file('image'), 'uploads/products/');
            $image_path = public_path($oldProductImage);

            if ($oldProductImage && File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $product->update([
            'manufacture_code'=> $request->manufacture_code,
            'brand_id'        => $request->brand_id,
            'product_type_id' => $request->product_type_id,
            'mrp'             => $request->mrp,
            'supplier_price'  => $request->supplier_price,
            'department_id'   => $request->department_id,
            'season'          => $request->season,
            'supplier_ref'    => $request->supplier_ref,
            'tax_id'          => $request->tax,
            'in_date'         => $request->in_date,
            'last_date'       => $request->last_date,
            'short_description'=> $request->short_description,
            'image'           => $imageName ?? $oldProductImage,
            'status'          => $request->status
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        Product::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }

    public function productStatus(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }

        return response()->json(['error' => 'Product not found.'], 404);
    }
}
