<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BaseResource;
class DepartmentCollection extends BaseResource
{
    

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
            ],
         
        ];
    }
}
