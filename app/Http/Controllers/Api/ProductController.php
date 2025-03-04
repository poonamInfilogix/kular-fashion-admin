<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListCollection;
use App\Http\Resources\ProductResource;
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
        try{
                $validator = Validator::make($request->all(), [
                    'column'      => 'in:price,name,productType',
                ]);
            
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
                }
                $column = $request->input('column') ?? 'products.created_at';
                $orderBy = request()->input('order_by') ??  'asc'; 
                $per_page = $request->input('per_page', 10); // Default to 10 if not provided
                $page = $request->input('page', 1); // Default to 1 if not provided
                $query = Product::with(['brand', 'department', 'productType', 'webImage', 'specifications','quantities', 'colors.colorDetail', 'sizes.sizeDetail', 'webInfo'])
                            ->whereHas('webInfo', function ($q) {
                                $q->where(function ($subQuery) {
                                    $subQuery->where('is_splitted_with_colors', 1)
                                    ->where('status', 1) 
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
                            ->orderBy($column, $orderBy)
                            ->paginate($per_page, ['*'], 'page', $page); // Proper pagination
                

                $products->load(['brand', 'department', 'productType', 'colors.colorDetail', 'sizes.sizeDetail', 'webInfo']);

                $filters = [];
                    foreach ($products as $product) {
                        foreach ($product->colors as $key => $color) {
                                $filters['colors'][$key] = [
                                    'id' => $color->id,
                                    'color_id' => $color->color_id,
                                    'supplier_color_code' => $color->supplier_color_code,
                                    'supplier_color_name' => $color->supplier_color_name,
                                    'swatch_image_path' => $color->swatch_image_path,
                                    'detail' => [
                                        'id' => optional($color->colorDetail)->id,
                                        'name' => optional($color->colorDetail)->name,
                                        'slug' => optional($color->colorDetail)->slug,
                                        'code' => optional($color->colorDetail)->code,
                                        'ui_color_code' => optional($color->colorDetail)->ui_color_code,
                                ]];
                        }
                        foreach ($product->sizes as $key => $size) {
                                $filters['sizes'][$key] =[
                                        'id' => $size->id,
                                        'size_id' => $size->size_id,
                                        'detail' => [
                                            'id' => optional($size->sizeDetail)->id,
                                            'size' => optional($size->sizeDetail)->size,
                                        ]
                            ] ;
                        }
        
                            $filters['brands'] = 
                                [
                                    'id' => optional($product->brand)->id,
                                    'name' => optional($product->brand)->name,
                                    'slug' => optional($product->brand)->slug,
                                ];

                    $filters['minPrice'] = Product::min('price');   
                    $filters['maxPrice'] = Product::max('price');           
                }
            
                return response()->json([
                    'success' => true,
                    // 'data' => $products,    
                    'data' => new ProductListCollection($products),
                    'filters' => $filters
                ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'data' => $e->getMessage()
            ]);
        }
       
 
    }



    public function showProduct(Request $request, $product){
        try{

            $product = Product::with('brand', 'department', 'webInfo', 'webImage', 'specifications','productType', 'colors.colorDetail', 'sizes.sizeDetail')
                        ->where('id', $product)->first();
            if(!$product)
            {
              return response()->json(['success' => false, 'data' => (object)[]]);
            }
            
            $sizes = $product->sizes()->with('sizeDetail')->paginate($request->input('sizes_length', 10)) ?? collect([]);
            
            $colors = $product->colors()->with('colorDetail')->paginate($request->input('colors_length', 10)) ?? collect([]);

           return new ProductResource($product, $sizes, $colors);

        }catch(Exception  $e){
            return response()->json(['success' => false, 'message'=> $e->getMessage(), 'data' => (object)[]]);
        }
         
    }
 
}
