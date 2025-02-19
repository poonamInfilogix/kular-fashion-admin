<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'euro_to_pound',
                'value' => '0.83'
            ]
        ];
        

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
        

        $taxes = [
            [
                'tax' => 0,
                'status' => 1, 
                'is_default' => 0
            ],
            [
                'tax' => 5,
                'status' => 1,
                'is_default' => 0
            ],
            [
                'tax' => 20,
                'status' => 1,
                'is_default' => 1
            ],
        ];
        
        foreach ($taxes as $taxData) {
            Tax::create([
                'tax'        => $taxData['tax'],
                'status'     => $taxData['status'],
                'is_default' => $taxData['is_default']
            ]);
        }        
    }
}
