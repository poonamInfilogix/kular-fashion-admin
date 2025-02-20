<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\ProductType;
use App\Models\ProductTypeDepartment;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Men'],
            ['name' => 'Women'],
            ['name' => 'Unisex']
        ];

        // Store created departments in an array for easy reference
        $createdDepartments = [];
        foreach ($departments as $departmentData) {
            $createdDepartments[$departmentData['name']] = Department::create($departmentData);
        }

        $productTypes = [
            'T-Shirts' => ['Men', 'Women', 'Unisex'],
            'Shirts'   => ['Men', 'Women'],
            'Jeans'    => ['Men', 'Unisex'],
            'Dresses'  => ['Women'],
            'Tops'     => ['Women', 'Unisex'],
            'Skirts'   => ['Women'],
            'Hats'     => ['Unisex'],
            'Shoes'    => ['Men', 'Women', 'Unisex'],
            'Bags'     => ['Unisex']
        ];

        foreach ($productTypes as $productTypeName => $departmentsArray) {
            $productType = ProductType::create([
                'name' => $productTypeName,
                'short_name' => $productTypeName
            ]);

            foreach ($departmentsArray as $departmentName) {
                $department = $createdDepartments[$departmentName];

                ProductTypeDepartment::create([
                    'product_type_id' => $productType->id,
                    'department_id'   => $department->id
                ]);
            }
        }
    }
}
