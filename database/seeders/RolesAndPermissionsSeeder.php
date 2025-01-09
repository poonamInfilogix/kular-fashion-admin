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
            'pos',
            'backend',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view product_types', 'create product_types', 'edit product_types', 'delete product_types',
            'view brands', 'create brands', 'edit brands', 'delete brands',
            'view colors', 'create colors', 'edit colors', 'delete colors',
            'view size', 'create size', 'edit size', 'delete size',
            'view size_scales', 'create size_scales', 'edit size_scales', 'delete size_scales',
            'view products', 'create products', 'edit products', 'delete products',
            'view print_barcodes', 'create print_barcodes', 'edit print_barcodes', 'delete print_barcodes',
            'view tags', 'create tags', 'edit tags', 'delete tags',
            'view branches', 'create branches', 'edit branches', 'delete branches',
            'view inventory_transfer', 'create inventory_transfer', 'edit inventory_transfer', 'delete inventory_transfer',
            'view customers', 'create customers', 'edit customers', 'delete customers',
            'view suppliers', 'create suppliers', 'edit suppliers', 'delete suppliers',
            'view users', 'create users', 'edit users', 'delete users',
            'view roles & permissions', 'edit roles & permissions',
            'view price_reasons', 'create price_reasons', 'edit price_reasons', 'delete price_reasons',
            'view settings', 'create settings', 'edit settings', 'delete settings',
            'view tax', 'create tax', 'edit tax', 'delete tax',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'Super Admin' => Permission::all(),
            'Admin' => Permission::all(),
            'Manager' => ['backend', 'view customers'],
            'Sales Person' => ['pos']
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