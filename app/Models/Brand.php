<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use SoftDeletes, Sluggable;
    protected $guarded=[];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'brand_name'  // Source column for slug
            ]
        ];
    }
}
