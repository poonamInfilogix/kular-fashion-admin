<?php

namespace App\Models;
use App\Models\Branch;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;

class InventoryTransfer extends Model
{
    protected $guarded =[];

   
    public function sentFrom()
    {
        return $this->belongsTo(Branch::class, 'sent_from','id');
    }


    public function sentTo()
    {
        return $this->belongsTo(Branch::class, 'sent_to', 'id');
    }

    public function sentBy()
    {
        return $this->belongsTo(User::class,'sent_by', 'id');
    }
   
    
}
