<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SizeScale;
use App\Models\Size;

class SizeScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizeScales = [
            'Z' => [
                ['size' => 'ISZ'],
            ],
            'ju1' => [
                ['size' => '3xs'],
                ['size' => '2xs'],
                ['size' => 'xs'],
                ['size' => 's'],
                ['size' => 'm'],
                ['size' => 'l'],
                ['size' => 'xl'],
                ['size' => 'xxl'],
                ['size' => '3xl'],
                ['size' => '4xl'],
                ['size' => '5xl'],
            ],
            'D2' => [
                ['size' => '36'],
                ['size' => '37'],
                ['size' => '38'],
                ['size' => '39'],
                ['size' => '40'],
                ['size' => '41'],
                ['size' => '42'],
                ['size' => '43'],
                ['size' => '44'],
                ['size' => '45'],
                ['size' => '46'],
                ['size' => '47'],
            ],
            'J1' => [
                ['size' => '28'],
                ['size' => '30'],
                ['size' => '32'],
                ['size' => '34'],
                ['size' => '36'],
                ['size' => '38'],
                ['size' => '40'],
                ['size' => '42'],
                ['size' => '44'],
                ['size' => '46'],
                ['size' => '48'],
                ['size' => '50'],
                ['size' => '52'],
            ],
            'JLL' => [
                ['size' => '23'],
                ['size' => '24'],
                ['size' => '25'],
                ['size' => '26'],
                ['size' => '27'],
                ['size' => '28'],
                ['size' => '29'],
                ['size' => '30'],
                ['size' => '31'],
                ['size' => '32'],
                ['size' => '33'],
                ['size' => '34'],
                ['size' => '36'],
            ],
            'JUR' => [
                ['size' => '1'],
                ['size' => '2'],
                ['size' => '3'],
                ['size' => '4'],
                ['size' => '5'],
                ['size' => '6'],
                ['size' => '7'],
                ['size' => '8'],
                ['size' => '9'],
                ['size' => '10'],
                ['size' => '11'],
                ['size' => '12'],
                ['size' => '13'],
            ],
            'SL3' => [
                ['size' => '3'],
                ['size' => '4'],
                ['size' => '5'],
                ['size' => '5.5'],
                ['size' => '6'],
                ['size' => '6.5'],
                ['size' => '7'],
                ['size' => '8'],
                ['size' => '9'],
                ['size' => '10'],
                ['size' => '11'],
                ['size' => '12'],
                ['size' => '13'],
            ],
            'SL4' => [
                ['size' => '4'],
                ['size' => '5'],
                ['size' => '6'],
                ['size' => '7'],
                ['size' => '8'],
                ['size' => '9'],
                ['size' => '10'],
                ['size' => '11'],
                ['size' => '12'],
                ['size' => '13'],
                ['size' => '14'],
                ['size' => '15'],
                ['size' => '16'],
            ],
            'SM1' => [
                ['size' => '5'],
                ['size' => '6'],
                ['size' => '6.5'],
                ['size' => '7'],
                ['size' => '7.5'],
                ['size' => '8'],
                ['size' => '8.5'],
                ['size' => '9'],
                ['size' => '9.5'],
                ['size' => '10'],
                ['size' => '10.5'],
                ['size' => '11'],
                ['size' => '12'],
                ['size' => '13'],
            ],	
            'SML' => [
                ['size' => 'XS/S'],
                ['size' => 'S/M'],
                ['size' => 'M/L'],
                ['size' => 'L/XL'],
            ]
        ];
        $totalSizesCount = 0;
        foreach ($sizeScales as $scale => $sizes) {
            // Create the size scale and get its ID
            $sizeScale = SizeScale::create(['name' => $scale, 'is_default' => $scale==='ju1']);

            foreach ($sizes as $size) {
                $totalSizesCount++; // Increment the counter

                Size::create([
                    'size_scale_id' => $sizeScale->id,
                    'size' => $size['size'],
                    'new_code' => str_pad($totalSizesCount, 3, '0', STR_PAD_LEFT), // Generate new_code based on total count
                    'old_code' => $size['old_code'] ?? null,
                ]);
            }
        }
    }
}
