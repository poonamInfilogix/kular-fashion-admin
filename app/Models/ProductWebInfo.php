<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductWebInfo extends Model
{
    protected $table = "product_web_info";

    protected $fillable = [
                    'product_id',
                    'short_description',
                    'description',
                    'meta_title',
                    'meta_keywords',
                    'meta_description',
                    'status'		

    ];

   
}
