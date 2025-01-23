<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Department;
use App\Models\Brand;
use App\Models\ProductType;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'in_date' => 'datetime',
        'last_date' => 'datetime',
    ];
    

    protected static function boot() {
        parent::boot(); 
        static::creating(function ($product) { 
            $lastProduct = self::orderBy('id', 'desc')->first(); 
            $product->article_code = $lastProduct ? $lastProduct->article_code + 1 : 300001; 
        }); 
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function quantities(){
        return $this->hasMany(ProductQuantity::class);
    }
}
