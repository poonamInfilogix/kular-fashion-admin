<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BaseResource;
class DepartmentCollection extends BaseResource
{
    private $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'current_page' => $resource->currentPage(),
            'from' => $resource->firstItem(),
            'last_page' => $resource->lastPage(),
            'per_page' => $resource->perPage(),
            'to' => $resource->lastItem(),
            'total' => $resource->total(),
        ];

        $resource = $resource->getCollection(); // Necessary to remove meta and links

        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
     
        return [
            'success' => true,
            'data' => parent::toArray($request),
            'pagination' => $this->pagination,
        ];
    }
}
