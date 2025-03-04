<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $guarded =[];

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
