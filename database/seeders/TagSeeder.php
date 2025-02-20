<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Casual Wear'],
            ['name' => 'Streetwear'],
            ['name' => 'Formal Wear'],
            ['name' => 'Vintage'],
            ['name' => 'Sustainable Fashion'],
            ['name' => 'Plus Size'],
            ['name' => 'Athleisure'],
            ['name' => 'Minimalist'],
            ['name' => 'Boho'],
            ['name' => 'Luxury'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
