<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;

class Cart extends Model
{
    protected $guarded=[];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
