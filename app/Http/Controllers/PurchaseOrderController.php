<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Color;
use App\Models\SizeScale;
use App\Models\Size;
use App\Models\productType;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('purchase-orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::latest()->where('status', 'Active')->get();
        $colors = Color::where('status', 'Active')->get();
        $sizeScales = SizeScale::select('id', 'size_scale')->where('status', 'Active')->latest()->with('sizes')->get();
        $productTypes = ProductType::where('status', 'Active')->whereNull('deleted_at')->latest()->get();

        return view('purchase-orders.create', compact('suppliers', 'colors', 'sizeScales', 'productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
