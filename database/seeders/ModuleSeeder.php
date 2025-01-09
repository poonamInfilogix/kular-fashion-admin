<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            ['name' => 'Departments', 'slug' => 'departments'],
            ['name' => 'Product Types', 'slug' => 'product_types'],
            ['name' => 'Brands', 'slug' => 'brands'],
            ['name' => 'Colors', 'slug' => 'colors'],
            ['name' => 'Size', 'slug' => 'size'],
            ['name' => 'Size Scales', 'slug' => 'size_scales'],
            ['name' => 'Products', 'slug' => 'products'],
            ['name' => 'Print Barcodes', 'slug' => 'print_barcodes'],
            ['name' => 'Tags', 'slug' => 'tags'],
            ['name' => 'Branches', 'slug' => 'branches'],
            ['name' => 'Inventory Transfer', 'slug' => 'inventory_transfer'],
            ['name' => 'Customers', 'slug' => 'customers'],
            ['name' => 'Suppliers', 'slug' => 'suppliers'],
            ['name' => 'Users', 'slug' => 'users'],
            ['name' => 'Roles & Permissions', 'slug' => 'roles & permissions'],
            ['name' => 'Price Reasons', 'slug' => 'price_reasons'],
            ['name' => 'Settings', 'slug' => 'settings'],
            ['name' => 'Tax', 'slug' => 'tax']
        ];

        foreach ($modules as $module) {
            Module::create($module);
        }
    }
}