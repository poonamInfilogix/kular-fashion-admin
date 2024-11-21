<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $modules = [
            [
                "name" => "Brand",
                "slug" => "brand",
            ],
            [
                "name" => "Customer",
                "slug" => "customer",
            ],
            [
                "name" => "Color",
                "slug" => "color",
            ],
            [
                "name" => "Department",
                "slug" => "department",
            ],
            [
                "name" => "Product",
                "slug" => "product",
            ],
            [
                "name" => "Product Type",
                "slug" => "product-type",
            ],
            [
                "name" => "Size Scale",
                "slug" => "size-scale",
            ],
            [
                "name" => "Supplier",
                "slug" => "supplier",
            ],
            [
                "name" => "Tag",
                "slug" => "tag",
            ]
        ];

        foreach ($modules as $module) {
            Module::create([
                'name' => $module['name'],
                'slug' => $module['slug']
            ]);
        }


    }
}
