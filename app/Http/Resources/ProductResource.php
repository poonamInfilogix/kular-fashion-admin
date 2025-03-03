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
 
            'brand' =>  [
                            'id' => optional($this->brand)->id,
                            'name' => optional($this->brand)->name ?? '',
                            'slug' => optional($this->brand)->slug,
                            "short_name" => optional($this->brand)->short_name,
                            "image"=> optional($this->brand)->image,
                            "small_image"=> optional($this->brand)->small_image,
                            "medium_image"=> optional($this->brand)->medium_image,
                            "large_image"=> optional($this->brand)->large_image,
                          
                        ],
            'department' => [
                'id' => optional($this->department)->id,
                'name' => optional($this->department)->name,
                'slug' => optional($this->department)->slug ?? '',
                'image' => optional($this->department)->image ?? '',
                "description"=> optional($this->department)->description ?? '',
                "image"=> optional($this->department)->image ?? '',
                "status"=> optional($this->department)->status ?? '',
            ],
            'productType' =>  [
                'id' => optional($this->productType)->id,
                'name' => optional($this->productType)->name,
                'slug' => optional($this->productType)->slug,
                "short_name"=> optional($this->productType)->short_name,
                "image" => optional($this->productType)->image,
                "small_image"=> optional($this->productType)->small_image,
                "medium_image"=> optional($this->productType)->medium_image,
                "large_image"=> optional($this->productType)->large_image,
            ],
            'webInfo' =>  [
                            "id"=> optional($this->webInfo)->id,
                            "product_id"=> optional($this->webInfo)->product_id,
                            "summary"=> optional($this->webInfo)->summary,
                            "description"=> optional($this->webInfo)->description,
                            "is_splitted_with_colors"=> optional($this->webInfo)->is_splitted_with_colors,
                            "heading"=> optional($this->webInfo)->heading,
                            "meta_title"=> optional($this->webInfo)->meta_title,
                            "meta_keywords"=> optional($this->webInfo)->meta_keywords,
                            "meta_description"=> optional($this->webInfo)->meta_description,
                            "status"=> optional($this->webInfo)->status,  
                        ],
            'images' => $this->webImage->map(function($image){
                        return [
                            "id" => $image->id,
                            "product_id"=> $image->product_id,
                            "product_color_id"=> $image->product_color_id,
                            "path"=> $image->path,
                            "alt"=> $image->alt,
                            "is_default"=> $image->is_default,
                        ];
            }),
            'specifications' => $this->specifications->map(function($specification){
                return [
                    "id" => $specification->id,
                    "product_id"=> $specification->product_id,
                    "key"=> $specification->key,
                    "value"=> $specification->value,
                ];
                }),
            'sizes' => $this->sizes->map(function ($size) {
                    return [
                        'id' => $size->id,
                        'product_id' => $size->product_id,
                        'size_id' => $size->size_id,
                        'mrp' => $size->mrp,
                        'web_price' => $size->web_price,
                        'web_sale_price' => $size->web_sale_price,
                        'sizeDetail' => $size->sizeDetail ? [
                            "id" => $size->sizeDetail->id,
                            "size_scale_id" => $size->sizeDetail->size_scale_id,
                            "size" => $size->sizeDetail->size,
                            "new_code" => $size->sizeDetail->new_code,
                            "old_code" => $size->sizeDetail->old_code,
                            "length" => $size->sizeDetail->length,
                            "status" => $size->sizeDetail->status,
                        ] : null, 
                    ];
                }),
                'pagination' => [
                    'total' => $this->sizes->total(),
                    'per_page' => $this->sizes->perPage(),
                    'current_page' => $this->sizes->currentPage(),
                    'last_page' => $this->sizes->lastPage(),
                    'next_page_url' => $this->sizes->nextPageUrl(),
                    'prev_page_url' => $this->sizes->previousPageUrl(),
                    'links' => $this->colors->linkCollection()->toArray(),
                ],
       
     
                'colors' => $this->colors->map(function($color){
                    return [
                        'id' => $color->id,
                        'product_id' => $color->product_id,
                        'color_id' => $color->color_id,
                        'supplier_color_code' => $color->supplier_color_code,
                        'supplier_color_name' => $color->supplier_color_name,
                        'swatch_image_path' => $color->swatch_image_path,
                       
                        'colorDetail' => $color->colorDetail ? [
                            "id" => $color->colorDetail->id,
                            "name" => $color->colorDetail->name,
                            "slug" => $color->colorDetail->slug,
                            "short_name" => $color->colorDetail->short_name,
                            "code" => $color->colorDetail->code,
                            "ui_color_code" => $color->colorDetail->ui_color_code,
                            "status" => $color->colorDetail->status,
                        ] : null, 
                    ];
                }),
                'pagination' => [
                    'total' => $this->colors->total(),
                    'per_page' => $this->colors->perPage(),
                    'current_page' => $this->colors->currentPage(),
                    'last_page' => $this->colors->lastPage(),
                    'next_page_url' => $this->colors->nextPageUrl(),
                    'prev_page_url' => $this->colors->previousPageUrl(),
                    'links' => $this->colors->linkCollection()->toArray(),
                ],
           
        ];
    }
}
