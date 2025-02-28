<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::create([
            'name' => 'Store',
            'short_name' => 'Store',
            'email' => 'store@gmail.com',
            'contact' => '8970564231',
            'location' => 'Store',
        ]);
        $superAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'branch_id' => $branch->id,
            'password' => Hash::make('Admin@12345'),
        ]);
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $superAdmin->assignRole($superAdminRole);

        
        $branch = Branch::create([
            'name' => 'Frequary street',
            'short_name' => 'Fqry',
            'email' => 'frequarystreet@gmail.com',
            'contact' => '9876541230',
            'location' => 'Frequary street',
        ]);

        $salesPerson = User::create([
            'name' => 'Sales Person',
            'email' => 'salesperson@gmail.com',
            'branch_id' => $branch->id,
            'password' => Hash::make('Admin@12345'),
        ]);
        $salesPersonRole = Role::where('name', 'Sales Person')->first();
        $salesPerson->assignRole($salesPersonRole);

        $branch = Branch::create([
            'name' => 'Chandigarh Fashion Club',
            'short_name' => 'chd fshn',
            'email' => 'chdfashion@gmail.com',
            'contact' => '0123456789',
            'location' => 'Sector 17, Chandigarh',
        ]);

        $salesPerson = User::create([
            'name' => 'Sales Person 2',
            'email' => 'salesperson2@gmail.com',
            'branch_id' => $branch->id,
            'password' => Hash::make('Admin@12345'),
        ]);
        $salesPersonRole = Role::where('name', 'Sales Person')->first();
        $salesPerson->assignRole($salesPersonRole);
    }
}
