<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductBarcodeController extends Controller
{
    public function index(){
        if(!Gate::allows('view print_barcodes')) {
            abort(403);
        }
        $defaultProductsToBePrinted = Product::where('barcodes_printed_for_all', 0)->get()->pluck('id');
        return view('products.barcodes.index', compact('defaultProductsToBePrinted'));
    }

    public function addManufactureBarcode(Request $request){
        $targetedItem = ProductQuantity::find($request->id);
        if(!$targetedItem){
            return response()->json([
                'success' => false
            ]);
        }
        
        $targetedItem->manufacture_barcode = $request->barcode;
        $targetedItem->save();

        return response()->json([
            'success' => true
        ]);
    }
}
