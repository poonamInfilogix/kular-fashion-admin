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
                'code' => '100',
                'ui_color_code' => '#FF0000',
            ],
            [
                'name' => 'Green',
                'code' => '200',
                'ui_color_code' => '#008000',
            ],
            [
                'name' => 'Blue',
                'code' => '300',
                'ui_color_code' => '#0000FF',
            ],
            [
                'name' => 'Yellow',
                'code' => '400',
                'ui_color_code' => '#FFFF00',
            ],
            [
                'name' => 'Black',
                'code' => '500',
                'ui_color_code' => '#000000',
            ],
            [
                'name' => 'White',
                'code' => '600',
                'ui_color_code' => '#FFFFFF',
            ],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
