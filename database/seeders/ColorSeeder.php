<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'name' => 'Red',
                'short_name' => 'Red',
                'code' => '001',
                'ui_color_code' => '#FF0000',
            ],
            [
                'name' => 'Green',
                'short_name' => 'Green',
                'code' => '002',
                'ui_color_code' => '#008000',
            ],
            [
                'name' => 'Blue',
                'short_name' => 'Blue',
                'code' => '003',
                'ui_color_code' => '#0000FF',
            ],
            [
                'name' => 'Yellow',
                'short_name' => 'Yellow',
                'code' => '004',
                'ui_color_code' => '#FFFF00',
            ],
            [
                'name' => 'Black',
                'short_name' => 'Black',
                'code' => '005',
                'ui_color_code' => '#000000',
            ],
            [
                'name' => 'White',
                'short_name' => 'White',
                'code' => '006',
                'ui_color_code' => '#FFFFFF',
            ],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
