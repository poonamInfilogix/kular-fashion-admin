<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Size;

class SizeScale extends Model
{
    protected $guarded =[];
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
}
