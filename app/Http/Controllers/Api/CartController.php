<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CartItemResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProductQuantity;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Exception;


class CartController extends Controller
{
    
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required||exists:products,id',
            'cart_id' => 'exists:carts,id', 
            'varient_id' => 'required||exists:product_quantities,id|numeric',
            'color_id' => 'required||exists:product_colors,id||numeric',
            'size_id'=> 'required||exists:product_sizes,id||numeric',
            'quantity' => 'numeric',
            'coupon_id' => [
                            // 'nullable',  // Allows NULL values
                            // 'sometimes', // Only applies validation if 'coupon_id' is present in the request
                            'exists:coupons,id' 
                        ]
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        try{
                $userId = Auth::id();
                $sessionId = session()->getId();
                
                $productId = $request->product_id;
                $variantId = $request->varient_id;
                $quantity = $request->quantity ?? 1;
                $colorId = $request->color_id;
                $sizeId = $request->size_id;
                $couponId = $request->coupon_id ?? null;
                $variant = ProductQuantity::where( [
                                                    'id' => $variantId,
                                                    'product_id' => $productId,
                                                    'product_color_id' => $colorId,
                                                    'product_size_id' => $sizeId,
                                                    ])
                                                    ->first();

                if (!$variant || $variant->total_quantity < $quantity) {
                    return response()->json(['error' => 'Insufficient stock', 'data' => (object)[]], 400);
                }

                $product = Product::find($productId);
                $cart = Cart::where('user_id', $userId)->orWhere('session_id', $sessionId)->where('status', 'active')->first();
                            
                if (!$cart) {
                    $cart = Cart::create([
                        'user_id' => $userId,
                        'session_id' => $sessionId,
                        'coupon_id' => $couponId,
                        'status' => 1,
                    ]);
                }

                $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
                
                if ($cartItem) {
                        $cartItem->varient_id = $variantId;
                        $cartItem->quantity +=  $quantity;
                        $cartItem->product_color_id = $colorId;
                        $cartItem->product_size_id = $sizeId;
                        $cartItem->save();
                } else {
                    $cartItem = CartItem::create([
                                                    'cart_id' => $cart->id,
                                                    'user_id' => $userId,
                                                    'product_id' => $productId,
                                                    'quantity' => $quantity,
                                                    'product_color_id' => $colorId,
                                                    'product_size_id' => $sizeId,
                                                    'varient_id' => $variantId,

                                                ]);
                   
                }
                $cartItem = Cart::with('items')->where('carts.id', $cartItem->cart_id)->get();

                return response()->json(['data' => $cartItem]);
            
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage(), 'cart' => (object)[]]);
        }
      
    }
    

    public function removeCartItem(Request $request, $cartItemId){

        $cart = Cart::with('items')->find($cartItemId);

        if(!$cart){
           return  response()->json(['error' => 'Cart Not Found!', 'data' => (object)[]]);
        }
        if($cart && isset($cart->items))
        {
            $cart->items()->delete();
        }
        
        return response()->json(['error' => 'Deleted successfully!', 'data' => (object)[]]);
      
    }
}
