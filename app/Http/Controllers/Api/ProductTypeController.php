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
        
        $per_page = $request->per_page ?? 5;
        $page = $request->page ?? 1;
        
        $productTypes = ProductType::where('status','Active')->paginate($per_page,['*'],'page',$page);

        if($productTypes)
        {
            return new ProductTypeCollection($productTypes);
        }
    }
    
}
