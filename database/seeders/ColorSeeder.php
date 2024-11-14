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
                'color_name' => 'Red',
                'color_code' => '100',
                'ui_color_code' => 'FF0000',
            ],
            [
                'color_name' => 'Green',
                'color_code' => '200',
                'ui_color_code' => '#008000',
            ],
            [
                'color_name' => 'Blue',
                'color_code' => '300',
                'ui_color_code' => '#0000FF',
            ],
            [
                'color_name' => 'Yellow',
                'color_code' => '400',
                'ui_color_code' => '#FFFF00',
            ],
            [
                'color_name' => 'Black',
                'color_code' => '500',
                'ui_color_code' => '#000000',
            ],
            [
                'color_name' => 'White',
                'color_code' => '600',
                'ui_color_code' => '#FFFFFF',
            ],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
