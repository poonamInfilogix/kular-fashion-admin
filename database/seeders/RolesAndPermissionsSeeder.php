<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'backend',
            'frontend',
            'view stores', 'create stores', 'edit stores', 'delete stores',
            'view users', 'create users', 'edit users', 'delete users',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view products', 'create products', 'edit products', 'delete products',
            'view sales', 'create sales', 'edit sales', 'delete sales',
            'view customers', 'create customers', 'edit customers', 'delete customers',
            'view roles & permissions', 'edit roles & permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'Super Admin' => Permission::all(),
            'Admin' => Permission::all(),
            'Manager' => ['backend', 'view sales', 'view customers'],
            'Sales Person' => ['frontend']
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            if (is_array($permissions)) {
                $role->givePermissionTo($permissions);
            } else {
                $role->givePermissionTo($permissions);
            }
        }
    }
}