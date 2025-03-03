<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public function paginationInformation($request, $paginated, $default)
    {
        $default['pagination']['current_page'] = $default['meta']['current_page'];
        $default['pagination']['from'] = $default['meta']['from'];
        $default['pagination']['last_page'] = $default['meta']['last_page'];
        $default['pagination']['per_page'] = $default['meta']['per_page'];
        $default['pagination']['to'] = $default['meta']['to'];
        $default['pagination']['total'] = $default['meta']['total'];

        unset($default['links']);
        unset($default['meta']);

        return $default;
    }
}
