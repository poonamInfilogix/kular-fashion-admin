<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Nike', 'short_name' => 'Nike'],
            ['name' => 'Adidas', 'short_name' => 'Adidas'],
            ['name' => 'Puma', 'short_name' => 'Puma'],
            ['name' => 'Reebok', 'short_name' => 'Reebok'],
            ['name' => 'Under Armour', 'short_name' => 'Under Armour'],
            ['name' => 'New Balance', 'short_name' => 'New Balance'],
            ['name' => 'Asics', 'short_name' => 'Asics'],
            ['name' => 'Converse', 'short_name' => 'Converse'],
            ['name' => 'Vans', 'short_name' => 'Vans'],
            ['name' => 'Fila', 'short_name' => 'Fila'],
        ];
        

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
