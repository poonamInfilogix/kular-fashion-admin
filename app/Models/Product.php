<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Department;
use App\Models\Brand;
use App\Models\ProductType;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
