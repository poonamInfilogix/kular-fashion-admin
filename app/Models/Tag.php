<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tag extends Model
{
    use SoftDeletes, Sluggable;
    protected $guarded = [];
    
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Automatically generate slug if the name is updated.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::saving(function ($tag) {
            // If the name has changed, regenerate the slug
            if ($tag->isDirty('name')) {
                $slug = Str::slug($tag->name);  // Generate the base slug
                
                // Check if the slug already exists in the database
                $existingSlugCount = Tag::withTrashed()->where('slug', $slug)->count();
                
                // If the slug exists, append a unique identifier to it
                if ($existingSlugCount) {
                    $slug .= '-' . ($existingSlugCount + 1);
                }

                // Assign the unique slug to the tag
                $tag->slug = $slug;
            }
        });
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
