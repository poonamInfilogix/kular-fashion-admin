<?php

namespace App\Models;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class InventoryTransfer extends Model
{
    protected $guarded =[];

   
    public function getSentFrom()
    {
        return $this->belongsTo(Branch::class, 'sent_from','id');
    }


    public function getSentTo()
    {
        return $this->belongsTo(Branch::class, 'sent_to', 'id');
    }

    public function getSentBy()
    {
        return $this->belongsTo(User::class,'sent_by', 'id');
    }
}
