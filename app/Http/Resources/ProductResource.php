<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductResource extends JsonResource
{
    protected $sizes;
    protected $colors;

    public function __construct($resource, LengthAwarePaginator $sizes, LengthAwarePaginator $colors)
    {
        parent::__construct($resource);
        $this->sizes = $sizes;
        $this->colors = $colors;
    }
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'article_code' => $this->article_code,
            'manufacture_code' => $this->manufacture_code,
            'brand_id' => $this->brand_id,
            'department_id' => $this->department_id,
            'product_type_id' => $this->product_type_id,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'sale_start' => $this->sale_start,
            'sale_end' => $this->sale_end,
            'season' => $this->season,
            'size_scale_id' => $this->size_scale_id,
            'min_size_id' => $this->min_size_id,
            'max_size_id' => $this->max_size_id,
 
            'brand' => [
                'id' => optional($this->brand)->id,
                'name' => optional($this->brand)->name ?? '',
                'slug' => optional($this->brand)->slug,
            ],
            'department' => [
                'id' => optional($this->department)->id,
                'name' => optional($this->department)->name,
                'slug' => optional($this->department)->slug ?? '',
                'image' => optional($this->department)->image ?? '',
            ],
            'productType' => [
                'id' => optional($this->productType)->id,
                'name' => optional($this->productType)->name,
                'slug' => optional($this->productType)->slug,
            ],
            'size' => [
                'size' => $this->sizes->items(),
                'pagination' => [
                    'total' => $this->sizes->total(),
                    'per_page' => $this->sizes->perPage(),
                    'current_page' => $this->sizes->currentPage(),
                    'last_page' => $this->sizes->lastPage(),
                    'next_page_url' => $this->sizes->nextPageUrl(),
                    'prev_page_url' => $this->sizes->previousPageUrl(),
                    'links' => $this->colors->linkCollection()->toArray(),
                ],
            ],
            'color' => [
                'color' => $this->colors->items(),
                'pagination' => [
                    'total' => $this->colors->total(),
                    'per_page' => $this->colors->perPage(),
                    'current_page' => $this->colors->currentPage(),
                    'last_page' => $this->colors->lastPage(),
                    'next_page_url' => $this->colors->nextPageUrl(),
                    'prev_page_url' => $this->colors->previousPageUrl(),
                    'links' => $this->colors->linkCollection()->toArray(),
                ],
            ],
        ];
    }
}
