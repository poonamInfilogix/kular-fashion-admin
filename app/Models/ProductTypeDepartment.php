<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTypeDepartment extends Model
{
    protected $table = 'product_type_departments';
    protected $guarded =[];

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function productTypes(){
        return $this->hasOne(ProductType::class,'id','product_type_id');
    }
}
