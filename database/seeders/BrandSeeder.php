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
            ['name' => 'Nike'],
            ['name' => 'Adidas'],
            ['name' => 'Puma'],
            ['name' => 'Reebok'],
            ['name' => 'Under Armour'],
            ['name' => 'New Balance'],
            ['name' => 'Asics'],
            ['name' => 'Converse'],
            ['name' => 'Vans'],
            ['name' => 'Fila'],
        ];
        

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
