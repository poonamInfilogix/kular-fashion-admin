<?php

namespace App\Exports;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }
    public function exportProductsToCSV()
    {
        $products = Product::with(['brand', 'department', 'productType', 'colors', 'sizes', 'quantities'])->get();
        $fileName = 'products.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Article Code', 'Manufacture Code', 'Brand', 'Department', 'Product Type', 'Short Description',
                'MRP', 'Supplier Price', 'Image', 'Season', 'Supplier Ref', 'Tax ID', 'In Date', 'Last Date',
                'Size Scale ID', 'Min Size ID', 'Max Size ID', 'Status', 'Are Barcodes Printed', 'Barcodes Printed For All',
                'Colors', 'Sizes', 'Quantities'
            ]);

            // Add product data
            foreach ($products as $product) {
                $colors = $product->colors->pluck('color_id')->implode(', ');
                $sizes = $product->sizes->pluck('size_id')->implode(', ');
                $quantities = $product->quantities->pluck('quantity')->implode(', ');

                fputcsv($file, [
                    $product->article_code,
                    $product->manufacture_code,
                    $product->brand->name ?? '',
                    $product->department->name ?? '',
                    $product->productType->name ?? '',
                    $product->short_description,
                    $product->mrp,
                    $product->supplier_price,
                    $product->image,
                    $product->season,
                    $product->supplier_ref,
                    $product->tax_id,
                    $product->in_date,
                    $product->last_date,
                    $product->size_scale_id,
                    $product->min_size_id,
                    $product->max_size_id,
                    $product->status,
                    $product->are_barcodes_printed,
                    $product->barcodes_printed_for_all,
                    $colors,
                    $sizes,
                    $quantities,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
