<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWebImage extends Model
{
    protected $table = "product_web_images";

    protected $fillable = [
        'product_id', 
 
        'product_color_id',
        'path'

    ];

  
    
}
