<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
                'success' => true,
                'data' => $this->resource->map(function ($collection) {
                    return [
                        "id" => $collection->id,
                        "slug" => $collection->slug ?? '',
                        "name" => $collection->name ?? '',
                        "include_conditions" => $collection->include_conditions ?? '',
                        "exclude_conditions"=> $collection->exclude_conditions ?? '',
                        "image"=> $collection->image ?? '',
                        "small_image"=> $collection->small_image ?? '',
                        "medium_image"=> $collection->medium_image ?? '',
                        "large_image"=> $collection->large_image ?? '',
                        "summary"=> $collection->summary ?? '',
                        // "description"=> $collection->description ?? '',
                        // "heading"=> $collection->heading,
                        // "meta_title"=> $collection->meta_title,
                        // "meta_keywords"=> $collection->meta_keywords,
                        // "meta_description"=> $collection->meta_description ?? '',
                        "status"=> $collection->status,
                        // "deleted_at"=> $collection->include_conditions,
                        "created_at"=> $collection->created_at,
                        "updated_at"=> $collection->updated_at,
                        ];
                }),
        ];
    }
}
