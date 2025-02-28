<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BaseResource;

class ProductTypeCollection extends BaseResource
{

    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'data' => $this->resource->map(function ($product_type) {
                return [
                    "id"=>$product_type->id,
                    "slug" => $product_type->slug ,
                    "name" => $product_type->name ,
                    "short_name" => $product_type->short_name ,
                    "image" => $product_type->image ?? '',
                    "small_image" => $product_type->small_image ?? '',
                    "medium_image" => $product_type->medium_image  ?? '',
                    "large_image" => $product_type->large_image ?? '',
                ];
            }),
            'pagination' => [
                'total' => $this->resource->total(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'next_page_url' => $this->resource->nextPageUrl(),
                'prev_page_url' => $this->resource->previousPageUrl(),
            ],
        ];
    }
}
