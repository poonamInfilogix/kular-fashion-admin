<?php

namespace App\Imports;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Department;
use App\Models\ProductType;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductQuantity;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            //
        ]);
    }
    public function importProductsFromCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Skip the header row
        fgetcsv($handle);

        while (($data = fgetcsv($handle)) !== false) {
            // Map CSV columns to product fields
            $product = Product::create([
                'article_code' => $data[0],
                'manufacture_code' => $data[1],
                'brand_id' => Brand::firstOrCreate(['name' => $data[2]])->id,
                'department_id' => Department::firstOrCreate(['name' => $data[3]])->id,
                'product_type_id' => ProductType::firstOrCreate(['name' => $data[4]])->id,
                'short_description' => $data[5],
                'mrp' => $data[6],
                'supplier_price' => $data[7],
                'image' => $data[8],
                'season' => $data[9],
                'supplier_ref' => $data[10],
                'tax_id' => $data[11],
                'in_date' => $data[12],
                'last_date' => $data[13],
                'size_scale_id' => $data[14],
                'min_size_id' => $data[15],
                'max_size_id' => $data[16],
                'status' => $data[17],
                'are_barcodes_printed' => $data[18],
                'barcodes_printed_for_all' => $data[19],
            ]);

            // Add colors
            $colors = explode(',', $data[20]);
            foreach ($colors as $colorId) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => trim($colorId),
                ]);
            }

            // Add sizes
            $sizes = explode(',', $data[21]);
            foreach ($sizes as $sizeId) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_id' => trim($sizeId),
                ]);
            }

            // Add quantities
            $quantities = explode(',', $data[22]);
            foreach ($quantities as $quantity) {
                ProductQuantity::create([
                    'product_id' => $product->id,
                    'quantity' => trim($quantity),
                ]);
            }
        }

        fclose($handle);

        return redirect()->back()->with('success', 'Products imported successfully!');
    }
}
