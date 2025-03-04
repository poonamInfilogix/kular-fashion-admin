<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Color;
use App\Models\SizeScale;
use App\Models\Size;
use App\Models\productType;
use App\Models\ProductDetail;
use App\Models\ProductVariantDetail;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier','productDetails', 'productDetails.variants')->get();

        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::latest()->where('status', 'Active')->get();
        $colors = Color::where('status', 'Active')->get();
        $sizeScales = SizeScale::select('id', 'name')->where('status', 'Active')->latest()->with('sizes')->get();
        $productTypes = ProductType::where('status', 'Active')->whereNull('deleted_at')->latest()->get();

        return view('purchase-orders.create', compact('suppliers', 'colors', 'sizeScales', 'productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_order_no' => 'required|string|max:255',
            'supplier_order_date' => 'required|date',
            'delivery_date' => 'required|date',
            'supplier' => 'required|exists:suppliers,id',
    
            'products' => 'required|array|min:1',
            'products.*.product_code' => 'required|string|max:255',
            'products.*.short_description' => 'required|string|max:500',
            'products.*.product_type' => 'required|string|max:100',
            'products.*.name' => 'required|string|exists:size_scales,id',
            'products.*.min_size' => 'required|string|exists:sizes,id',
            'products.*.max_size' => 'required|string|exists:sizes,id',
            'products.*.delivery_date' => 'required|date',
            'products.*.price' => 'required',
            // 'products.*.short_description' => 'required|string|max:22',
        ], [
            'supplier_order_no.required' => 'The supplier order number is mandatory',
            'supplier_order_no.max' => 'The supplier order number must not exceed 255 characters',
        
            'supplier_order_date.required' => 'The supplier order date is required',
            'supplier_order_date.date' => 'The supplier order date must be a valid date',
        
            'delivery_date.required' => 'The delivery date is required',
            'delivery_date.date' => 'The delivery date must be a valid date',
        
            'supplier.required' => 'You must select a supplier',
            'supplier.exists' => 'The selected supplier is invalid',
        
            'products.required' => 'At least one product is required',
            'products.array' => 'The products field must be an array',
            'products.min' => 'You must add at least one product',
        
            'products.*.product_code.required' => 'The product code is required for each product',
            'products.*.product_code.max' => 'The product code must not exceed 255 characters',
        
            'products.*.short_description.required' => 'A short description is required for each product',
            'products.*.short_description.max' => 'The short description must not exceed 500 characters',
        
            'products.*.product_type.required' => 'The product type is required',
            'products.*.product_type.exists' => 'The selected product type is invalid',
        
            'products.*.size_scale.required' => 'The size scale is required',
            'products.*.size_scale.exists' => 'The selected size scale is invalid',
        
            'products.*.min_size.required' => 'The minimum size is required',
            'products.*.min_size.exists' => 'The selected minimum size is invalid',
        
            'products.*.max_size.required' => 'The maximum size is required',
            'products.*.max_size.exists' => 'The selected maximum size is invalid',
        
            'products.*.delivery_date.required' => 'The delivery date is required for each product',
            'products.*.delivery_date.date' => 'The delivery date must be a valid date',
        
            'products.*.price.required' => 'The price is required for each product',
            'products.*.price.numeric' => 'The price must be a valid number',
            'products.*.price.between' => 'The price must be between 0 and 999,999.99',
        ]);
       
        $purchaseOrder = PurchaseOrder::create([
            'order_no' => $request->supplier_order_no,
            'supplier_order_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->supplier_order_date),
            'delivery_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->delivery_date),
            'supplier_id'   => $request->supplier,
        ]);

        if($purchaseOrder) {
            foreach ($request->products as $productData) {
                $productDetail = ProductDetail::create([
                    'product_code' => $productData['product_code'],
                    'product_type_id' => $productData['product_type'],
                    'size_scale_id' => $productData['name'],
                    'min_size_id' => $productData['min_size'],
                    'max_size_id' => $productData['max_size'],
                    'delivery_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $productData['delivery_date']),
                    'price' => $productData['price'],
                    'short_description' => $productData['short_description'],
                    'purchase_order_id' => $purchaseOrder->id,
                ]);
    
                foreach ($productData['variants'] as $variantData) {
                    ProductVariantDetail::create([
                        'supplier_color_code' => $variantData['supplier_color_code'],
                        'supplier_color_name' => $variantData['supplier_color_name'],
                        'color_id' => $variantData['color_id'],
                        'size' => json_encode($variantData['size']),
                        'product_detail_id' => $productDetail->id,
                        'purchase_order_id' => $purchaseOrder->id,
                    ]);
                }
            }
        }
        return redirect()->route('purchase-orders.index')->with('success', 'Purchase order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }

    public function getSizeRange(Request $request)
    {
        $sizeScaleId = $request->input('size_scale_id');
        $sizeScale = Size::select('id', 'size')->where('status', 'Active')->where('size_scale_id', $sizeScaleId)->get();

        $minSizes = $sizeScale->pluck('size', 'id');
        $maxSizes = $sizeScale->pluck('size', 'id')->reverse();

        return response()->json([
            'min_size_options' => $minSizes,
            'max_size_options' => $maxSizes,
        ]);
    }
}
