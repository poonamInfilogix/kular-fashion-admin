<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BaseResource;
class DepartmentCollection extends BaseResource
{
    // private $pagination;

    // public function __construct($resource)
    // {
    //     $this->pagination = [
    //         'current_page' => $resource->currentPage(),
    //         'from' => $resource->firstItem(),
    //         'last_page' => $resource->lastPage(),
    //         'per_page' => $resource->perPage(),
    //         'to' => $resource->lastItem(),
    //         'total' => $resource->total(),
    //     ];

    //     $resource = $resource->getCollection(); // Necessary to remove meta and links

    //     parent::__construct($resource);
    // }

    // public function toArray(Request $request): array
    // {
     
    //     return [
    //         'success' => true,
    //         'data' => parent::toArray($request),
    //         'pagination' => $this->pagination,
    //     ];
    // }

    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'data' => $this->resource->map(function ($department) {
                return [
                    "id"=>$department->id,
                    "slug"=>$department->slug,
                    "name"=>$department->name ?? '',
                    "description"=>$department->description ?? '',
                    "image"=>$department->image ?? '',
                    // "status"=>$department->status,
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
