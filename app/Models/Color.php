<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Color extends Model
{
    use SoftDeletes, Sluggable;
    protected $guarded =[];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'color_name'
            ]
        ];
    }

    public function qauntity(){
        return $this->belongsTo(ProductQuantity::class);
    }
}
