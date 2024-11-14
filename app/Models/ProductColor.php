<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $guarded =[];

    public function colorDetail(){
        return $this->belongsTo(Color::class, 'color_id');
    }
}
