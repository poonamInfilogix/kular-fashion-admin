<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductBarcodeController extends Controller
{
    public function index(){
        $defaultProductsToBePrinted = Product::where('barcodes_printed_for_all', 0)->get()->pluck('id');
        return view('products.barcodes.index', compact('defaultProductsToBePrinted'));
    }
}
