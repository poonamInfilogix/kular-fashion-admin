<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWebSpecification extends Model
{
    protected $table = "product_web_specifications";

    protected $fillable = [
            'product_id',
            'key',
            'value', 
            'created_at',
            'updated_at',
        ];
}
