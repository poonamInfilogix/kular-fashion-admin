<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BrandCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Brand;
use Exception;

class BrandController extends Controller
{
    public function brands(Request $request){
        $per_page = $request->per_page ?? 2;
        $page = $request->page ?? 1;
        
        $brands = Brand::where('status','Active')->paginate($per_page, ['*'],'page', $page);
        
        if($brands)
        {
            return new BrandCollection($brands); 
        }
    }
}
