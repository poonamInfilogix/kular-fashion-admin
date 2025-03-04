<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => 'true',
            'data' => [
                'id' => $this->id,
                'cart_id' => $this->cart_id,
                'user_id' => $this->user_id,
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'product_color_id' => $this->product_color_id,
                'product_size_id' => $this->product_size_id,
                'varient_id' => $this->varient_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
     
    }
}
