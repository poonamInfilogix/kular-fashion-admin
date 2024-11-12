<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Department;
use Cviebrock\EloquentSluggable\Sluggable;

class ProductType extends Model
{
    use SoftDeletes, Sluggable;
    protected $guarded =[];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function productTypeDepartments()
    {
        return $this->hasMany(ProductTypeDepartment::class, 'product_type_id')->with('departments');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'product_type_name'  // Source column for slug
            ]
        ];
    }
}
