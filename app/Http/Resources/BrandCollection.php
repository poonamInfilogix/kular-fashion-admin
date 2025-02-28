<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BaseResource;

class BrandCollection extends BaseResource
{

    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'data' => $this->resource->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'slug' => $brand->slug,   
                    'name' => $brand->name,
                    "short_name" => $brand->short_name,
                    "image" => $brand->image ?? '',
                    "small_image" => $brand->small_image ?? '',
                    "medium_image" => $brand->medium_image ?? '',
                    "large_image" => $brand->large_image ?? '',
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
