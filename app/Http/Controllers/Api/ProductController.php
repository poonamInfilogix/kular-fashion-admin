<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductTypeCollection;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\BrandCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductQuantity;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Department;
use App\Models\Coupon;
use Illuminate\Support\Carbon;
use App\Models\ProductType;
use Exception;

class ProductController extends Controller
{
          
    public function index(Request $request){
        
        $query = Product::with(['brand', 'department', 'productType', 'webImage', 'specifications','quantities', 'colors.colorDetail', 'sizes.sizeDetail', 'webInfo'])
                    ->whereHas('webInfo', function ($q) {
                        $q->where('is_splitted_with_colors', 1)
                        ->where(function ($subQuery) {
                            $subQuery->where('status', 1) 
                                    ->orWhere('status', 2); 
                        });
                    })

                    ->where(function ($query) {
                        $query->whereHas('quantities', function ($q) {
                            $q->select(DB::raw('SUM(product_quantities.quantity) as total_quantity'))
                            ->havingRaw('SUM(quantity) > ?', [1]);
                        })
                        ->orWhereHas('webInfo', function ($q) {
                            $q->where('status', 1); 
                        });
                    });
                  
                    
            $filterable = [
                'brand_id' => 'brand',
                'department_id' => 'department',
                'color_id' => 'colors',
                'size_id' => 'sizes',
            ];
            
            foreach ($filterable as $param => $relation) {
                if ($request->filled($param)) {
                    $ids = explode(',', $request->input($param));
                    $query->whereHas($relation, function ($q) use ($ids, $param) {
                        $column = $param === 'color_id' || $param === 'size_id' ? $param : 'id';
                        $q->whereIn($column, $ids);
                    });
                }
            }

            $products = $query->join('product_colors', 'products.id', '=', 'product_colors.product_id')
                    ->select(
                        'products.id', 'products.name', 'products.slug', 'products.article_code',
                        'products.manufacture_code', 'products.brand_id', 'products.department_id', 
                        'products.product_type_id', 'products.price', 'products.sale_price', 
                        'products.sale_start','products.sale_end', 'products.season', 'products.size_scale_id', 
                        'products.min_size_id', 'products.max_size_id', 'product_colors.color_id'
                    )
                    ->groupBy(
                        'products.id', 'products.name', 'products.slug', 'products.article_code',
                        'products.manufacture_code', 'products.brand_id', 'products.department_id', 
                        'products.product_type_id', 'products.price', 'products.sale_price', 
                        'products.sale_start','products.sale_end', 'products.season', 'products.size_scale_id', 
                        'products.min_size_id', 'products.max_size_id', 'product_colors.color_id'
                    )
                  
                     ->orderBy('products.updated_at', 'desc')  

                    ->paginate($request->input('length', 10));

        $products->load(['brand', 'department', 'productType', 'colors.colorDetail', 'sizes.sizeDetail', 'webInfo']);
        return new ProductListCollection($products);
    

    }

    public function productDetail(Request $request, $product){
        try{
            

            if(!$product)
            {
              return response()->json(['success' => false, 'data' => $product]);
            }
            $product = Product::with('brand', 'department', 'webInfo', 'webImage', 'specifications','productType', 'colors.colorDetail', 'sizes.sizeDetail')
                        ->where('id', $product)->firstOrFail();
           
            $sizes = $product->sizes()->with('sizeDetail')->paginate($request->input('sizes_length', 10));
            
            $colors = $product->colors()->with('colorDetail')->paginate($request->input('colors_length', 10));

           return new ProductResource($product, $sizes, $colors);
         

        }catch(Exception  $e){
            return response()->json(['success' => false, 'message'=> $e->getMessage(), 'data' => []]);
        }
         
    }

    public function brandList(Request $request){

        $brands = Brand::where('status','Active')->paginate($request->input('length', 10));
        
        if($brands)
        {
            return new BrandCollection($brands); 
        }
    }


    public function departmentList(Request $request)
    {
        $departments = Department::where('status','Active')->paginate($request->input('length', 10));
        if($departments)
        {
            return new DepartmentCollection($departments); 
        }
    }

    public function producTypesList(Request $request){
        
        $productTypes = ProductType::where('status','Active')->paginate($request->input('length', 10));
        if($productTypes)
        {
            return new ProductTypeCollection($productTypes);
        }
    }
    
      
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon' => 'required||exists:coupons,code',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        $currentDateTime = Carbon::now(); 

        $coupon = Coupon::where('code', $request->coupon)
                        ->where(function ($query) use ($currentDateTime) {
                            $query->whereNotNull('start_date')
                                  ->whereDate('start_date', '>=', $currentDateTime);
                        })
                        ->where(function ($query) use ($currentDateTime) {
                            $query->whereNotNull('expire_date')
                                  ->whereDate('expire_date', '>=', $currentDateTime);
                        })
                        ->where('status', 1) 
                        ->first();
        if (!$coupon) { 
            return response()->json(['success' => false,  'message' => 'Coupon is expired' ], 400);
        } 
   
        return response()->json(['success' => false,  'data' => $coupon ], 200);
    }
}
