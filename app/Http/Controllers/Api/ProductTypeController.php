<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductTypeCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductType;
use Exception;

class ProductTypeController extends Controller
{

    public function producTypes(Request $request){
        
        $productTypes = ProductType::where('status','Active')->paginate($request->input('length', 10));

        if($productTypes)
        {
            return new ProductTypeCollection($productTypes);
        }
    }
    
}
