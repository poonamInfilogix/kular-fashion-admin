<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SizeScale;

class Size extends Model
{
    protected $guarded = [];

    public function sizeScale()
    {
        return $this->belongsTo(SizeScale::class);
    }
}
