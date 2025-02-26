<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\File;
class CouponDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'asc')->get();
        return view('coupon-discounts.index', compact('coupons'));
    }

  
    public function create()
    {
        $products = Product::select('id', 'article_code', 'name')->where('status', 'Active')->get();
        $tags = Tag::select('id', 'name')->where('status', 'Active')->get();
        return view('coupon-discounts.create', compact('products', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:255',
            'type' => 'required|in:percentage,fixed,free_shipping,buy_x_get_y,buy_x_for_y',
            'value' => 'required|numeric|min:0',
            'min_spend' => 'nullable|numeric|min:0',
            'max_spend' => 'nullable|numeric|min:0',
            'shipping_methods' => 'nullable|array',
            'buy_x_product_ids' => 'nullable|array',
            'get_y_product_ids' => 'nullable|array',
            'buy_x_quantity' => 'nullable|integer|min:1',
            'get_y_quantity' => 'nullable|integer|min:1',
            'buy_x_discount' => 'nullable|numeric|min:0',
            'usage_limit_total_value' => 'nullable|integer|min:1',
            'usage_limit_per_customer_value' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date|after_or_equal:today',
            'expire_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:0,1,2',
            'description' => 'nullable|string',
        ]);
        
        dd();
        $imageName = uploadFile($request->file('banner_path'), 'uploads/coupons/');
        $starts_at = date('Y-m-d H:i:s', strtotime($request->starts_at)); 
        $expires_at = date('Y-m-d H:i:s', strtotime($request->expire_at)); 
        $numeric_value = 0;
        $non_numeric_value = [];

        if(is_array($request->type_value))
        {
           $non_numeric_value =  json_encode([
                'x' => $request->type_value['0'],
                'y' => $request->type_value['1']
            ]);
        }
        else {
            $numeric_value = $request->type_value;
        }


         Coupon::create(
            [
                "type" => $request->type,
                "numeric_value" => $numeric_value,
                'non_numeric_value' => $non_numeric_value,
                "code" => $request->coupon_code,
                "usage_limit" => $request->usage_limit,
                "used_count" => $request->limit_val,
                "starts_at" => $starts_at ,
                "expires_at" => $expires_at,
                "is_active" => $request->status,
                "description" => $request->coupon_desc,
                "min_amount" => $request->min_purchase_amount,
                "min_items_count" => $request->min_items_count,
                "image_path" => $imageName
            ]
            );
            return redirect()->route('coupon-discounts.index')->with('success', 'Coupon created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $coupon =  Coupon::find($id);
       return view('coupon-discounts.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $oldCouponImage = $coupon->banner_path ?? null;
        $imageName = $oldCouponImage; 

        if ($request->hasFile('banner_path')) {
            $imageName = uploadFile($request->file('banner_path'), 'uploads/coupons/');
            
            if ($oldCouponImage) {
                $image_path = public_path($oldCouponImage);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }

        $starts_at = $request->starts_at ? date('Y-m-d H:i:s', strtotime($request->starts_at)) : $coupon->starts_at;
        $expires_at = $request->expire_at ? date('Y-m-d H:i:s', strtotime($request->expire_at)) : $coupon->expires_at;

        $coupon->update([
            "type" => $request->type ?? $coupon->type,
            "value" => $request->type_value ?? $coupon->value,
            "code" => $request->coupon_code ?? $coupon->code,
            "usage_limit" => $request->usage_limit ?? $coupon->usage_limit,
            "used_count" => $request->limit_val ?? $coupon->used_count ?? 0, 
            "starts_at" => $starts_at,
            "expires_at" => $expires_at,
            "is_active" => $request->status ?? $coupon->is_active,
            "description" => $request->coupon_desc ?? $coupon->description,
            "min_amount" => $request->min_purchase_amount ?? $coupon->min_amount,
            "min_items_count" => $request->min_items_count ?? $coupon->min_items_count,
            "banner_path" => $imageName
        ]);

        return redirect()->route('coupon-discounts.index')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $coupon = Coupon::find($id);
       if($coupon){
            $coupon->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully.',
        ]);
    }

}
