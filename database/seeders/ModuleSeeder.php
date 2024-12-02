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
            ['name' => 'Categories', 'slug' => 'categories'],
            ['name' => 'Product', 'slug' => 'products'],
            ['name' => 'Stores', 'slug' => 'stores'],
            ['name' => 'Users', 'slug' => 'users'],
            ['name' => 'Sales', 'slug' => 'sales'],
            ['name' => 'Customers', 'slug' => 'customers'],
            ['name' => 'Roles & Permissions', 'slug' => 'roles & permissions'],
        ];

        foreach ($modules as $module) {
            Module::create($module);
        }
    }
}